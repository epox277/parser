<?php
$host="localhost";
$user="root";
$password="48097989";
$schema="test";
$mysqli = new mysqli($host, $user, $password);
if ($mysqli->connect_errno) {
    echo 'connection failed';   
}
$mysqli->select_db($schema);