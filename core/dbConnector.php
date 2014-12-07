<?php
$host="localhost";
$user="root";
$password="putYourPasswordHere";
$schema="test";
$mysqli = new mysqli($host, $user, $password);
if ($mysqli->connect_errno) {
    echo 'connection failed';   
}
$mysqli->select_db($schema);