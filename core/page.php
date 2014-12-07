<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page
 *
 * @author jazz
 */
class page {

    //put your code here
    public function get_web_page($word) {
        $url = 'http://rozetka.com.ua/search/?p=[pageiterator]&section=%3F2&text=' . $word;
        $str = "";
        $i = 0;
        $stop = false;
        while (!$stop) {
            $ch = curl_init(str_replace('[pageiterator]', $i, $url));
            echo "Processing page ".$i." ";

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_ENCODING, "");       
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); 
            $content = curl_exec($ch);
            $str.=$content;
            $httpresponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (($httpresponse == 301) || ($httpresponse == 400)) {
                $stop = true;
            }
            $i++;
        }

        return $str;
    }

    public function parse($content) {
        $reg = '|<div class="g-i-list-title">.*href="(.*)/">(.*)</a>.*</div>.*'
                . '<div class="g-i-list-price-uah">(.*)<span|isU';
        preg_match_all($reg, $content, $parsedContent, PREG_SET_ORDER);
        for ($i = 0; $i < count($parsedContent); $i++) {

            $parsedContent[$i][2] = preg_replace('|[^a-z0-9\(\) ]*|i', '', $parsedContent[$i][2]);
            $pieces = explode(" ", trim($parsedContent[$i][2]), 2);
            $parsedContent[$i][2] = trim($pieces[0]);
            $parsedContent[$i][3] = str_replace('&thinsp;', '', $parsedContent[$i][3]);
            $parsedContent[$i][] = trim($pieces[1]);

            //1 - link
            //2 - vendor
            //3 - price
            //4 - model
        }

        function cmp($a, $b) {
            return ($a[3] >= $b[3]) ? -1 : 1;
        }

        usort($parsedContent, "cmp");

        for ($i = 0; $i < count($parsedContent); $i++) {
            $outputarray[$i]['link'] = $parsedContent[$i][1];
            $outputarray[$i]['vendor'] = $parsedContent[$i][2];
            $outputarray[$i]['price'] = $parsedContent[$i][3];
            $outputarray[$i]['model'] = $parsedContent[$i][4];
        }
        return $outputarray;
    }

}
