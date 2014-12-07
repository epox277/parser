<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csvHandler
 *
 * @author jazz
 */
class csvHandler {

    
    function output_to_csv($data) {
        if (!$outstream = fopen('output.csv', 'w')) {
            die('Some problems in creating file. Check permission');
        }
        foreach ($data as $line) {
            if (!fputcsv($outstream, array($line['vendor'],
                        $line['model'], $line['price'], $line['link']))) {
                die('Some problems in writing files. Maybe file opened in another program');
            }
        }
        fclose($outstream);
    }

}
