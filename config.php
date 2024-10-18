<?php

header ('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'root';

$con = new mysqli($host, $user, $password, $db);
if(mysqli_connect_error()){
    printf("<br>Подключение не удалось: %s\n", mysqli_connect_error());
    exit;
}
