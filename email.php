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
    
    $mail -> Host = "";
    $mail->Username = "mail";
    $mail->Password = "";
    $mail->SMTPSecure = "";
    $mail->Port = ;
    
    $mail -> setFrom ('mail@mail.ru', 'Почти настоящая компания');
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
