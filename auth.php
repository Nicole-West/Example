<?php
include "./config.php";
session_start();
if (!empty($_POST['login']) && !empty($_POST['password'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    //
    
    $stmt = $con->prepare("SELECT * FROM Person WHERE login = ? AND password = ?"); 
    $stmt->bind_param("ss", $login, $password); 
    $stmt->execute(); 
    
    $result = $stmt->get_result();
    
    
    if ($login == 'admin' && $password == 'qwe'){
        setcookie('login', $login, time() + 3600, "/");
        header('Location: ./admin.php');
    }
    else if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $position_id = $row['position_id'];
        $_SESSION['person_id'] = $row['person_id'];
        $name = $row['first_name'];
        
        $_SESSION['name'] = $name;
        
        $stmt2 = $con->prepare("SELECT position_name FROM Position WHERE position_id = ?"); 
        $stmt2->bind_param("i", $position_id); 
        $stmt2->execute(); 
        
        $result2 = $stmt2->get_result();
        $row2 = $result2->fetch_assoc();
        $_SESSION[''];
        $_SESSION['position_name'] = $row2['position_name'];
        
        
        
        setcookie('login', $login, time() + 3600, "/");
        header('Location:../index.php');
    }
    else{
        header('Location: login.php');
    }
    
}

if (isset($_POST['out'])){
    session_unset();
    session_destroy();
    setcookie("login", "", time() - 3600, "/");

    header('Location: ../index.php');
    exit;
}
?>   