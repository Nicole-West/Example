<?php
include '../config.php';
session_start();


if(!isset($_SESSION['click'])){
    $_SESSION['email'] = $_POST['email'];
    
    if(empty($_SESSION['name'])){
        if($_COOKIE['login']=='admin'){
            $_SESSION['name'] = 'Админ';
        }
        else{
            $_SESSION['name'] = 'Гость';
        }
    }
    
    
    require "../w/vendor/autoload.php";
    //письмо
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    $mail -> Host = "smtp.yandex.ru";
    $mail->Username = "fun-an4stasia";
    $mail->Password = "pgaixcchymhmrxdj";
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    
    $mail -> setFrom ('fun-an4stasia@yandex.ru', 'Почти настоящая компания');
    $mail -> addAddress($_SESSION["email"], $_SESSION['name']);
    $mail -> Subject = 'Проверка отправки сообщения';
    
    $mail->Body = "Уважаемый " . $_SESSION['name'] . "!";
    $mail->isHTML(true);
    $mail→SMTPDebug = 2;
    
    //отправляем
    if($mail->send()){
        header('Location: ../index.php');
    }
    else{
        header('Location: message.php');
    }
    
}
?>