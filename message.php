<?php 
session_start();
include './auth.php';
include './config.php';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Итоговый проект 2024</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/style_login.css">
    <style>
      form {
          display: grid;
          align-items: end;
          padding-top: 0px;
          padding-bottom: 0px;
      }
      
      .message {
          min-height: 334px;
      }
    </style>
</head>
<body>

  <div class="header">
    <div class="header__inner">
      <div class="header__item header__left">
        <a href="/" class="header__logo">
          <img src="../images/image3.png" alt="Рыболовецкая артель">
        </a>
      </div>
    </div>
  </div>
  
  <div class="page">

    <div class="auth-layout__cell">
      

      <div class="auth-form tabs">
        <div class="tabs__content tabs__content_show">
          <form method="post" action="email.php" class="message">
            <div class="form__input-wrap">
              <label for="email">Введите свою почту:</label>
              <input type="email" name="email" size="30" class="form__input form__input_icon" required>
              
            </div>
            <div class="form__footer">
              <button type="submit" name="click" class="button header__sign button_md button_block">Отправить</button>
            </div>
          </form>
          
          <form action="" method="post">
              <a href="../index.php" class="button header__sign header__sign-in">Назад</a>
          </form>
          
        </div>
      </div>

    </div>


    <footer class="footer paper">
      <p>Добро пожаловать)</p>
    </footer>
  </div>
  
</body>
</html>


