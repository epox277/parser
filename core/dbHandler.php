<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbHandler
 *
 * @author jazz
 */
class dbHandler {

    //put your code here

    function try_create_table() {
        require '/dbConnector.php';
        $query = 'CREATE TABLE rozetka (`id` INT NOT NULL AUTO_INCREMENT,`word`'
                . ' VARCHAR(45) NULL,`data` TEXT NULL,`parseDate`'
                . ' DATETIME NULL, PRIMARY KEY (`id`));';
        if ($mysqli->query($query) === TRUE) {
            echo'table created';
        } else {
            echo ' Table already exists, moving froward...';
        }
    }

    function write_data_to_db($word, $data) {
        require '/dbConnector.php';
        $query = "INSERT INTO rozetka (word, data, parseDate) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query) or trigger_error($mysqli->error);
        $val1 = $word;

        $val3 = date('Y-m-d H:i:s');
        for ($i = 0; $i < count($data); $i++) {
            $val2 = implode(",", $data[$i]);
            $stmt->bind_param('sss', $val1, $val2, $val3);
            $stmt->execute()or trigger_error($mysqli->error);
        }
        $stmt->close();
    }

}
