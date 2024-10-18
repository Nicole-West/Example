<?php 
session_start();
include './auth.php';
include '../config.php';
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
        padding-top: 110px;
        padding-bottom: 140px;
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
          <form method="post" action="auth.php">
            <div class="auth-form-title">Авторизация</div>
            <div class="form__field">
              <div class="form__input-wrap">
                <input type="text" name="login" value="" class="form__input form__input_icon" placeholder="Логин" required>
              </div>
            </div>

            <div class="form__field">
              <div class="form__input-wrap">
                <input type="password" name="password" class="form__input form__input_icon" placeholder="Пароль" required>
              </div>
            </div>
            
            <div class="form__footer">
              <button type="submit" name="in" class="button button_primary button_md button_block">Войти</button>
            </div>

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


