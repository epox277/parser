<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of main_controller
 *
 * @author jazz
 */
require_once '/core/Page.php';
require_once '/core/csvHandler.php';
require_once '/core/dbHandler.php';

$word = trim($argv[1]);
$page = new page;
$csvout = new csvHandler;
$db = new dbHandler();
$htmltext = $page->get_web_page($word);
$parsedContent = $page->parse($htmltext);
$csvout->output_to_csv($parsedContent);
$db->try_create_table();
$db->write_data_to_db($word, $parsedContent);
echo 'All tasks are done';
    

