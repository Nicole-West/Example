<?php

header ('Content-Type: text/html; charset=utf-8');

$host = 'localhost';
$user = 'funan4cq_artel';
$password = '2%m8Xta0be*q';
$db = 'funan4cq_artel';

$con = new mysqli($host, $user, $password, $db);
if(mysqli_connect_error()){
    printf("<br>Подключение не удалось: %s\n", mysqli_connect_error());
    exit;
}

?>