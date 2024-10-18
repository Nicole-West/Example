<?php 
include './config.php';
include './auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Итоговый проект 2024</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .qwe2{
            display: block;
            flex-grow: 1;
            min-height: 150px;
        }
        
        .section__body{
            flex-direction: column;
            align-items: flex-start;
            min-height: 450px;
        }
        .tabs__content_show {
            min-height: 200px;
            display: block;
        }
    </style>
</head>

<body>

  <div class="header">
    <div class="header__inner">
      <div class="header__item header__left">
        <a href="./admin.php" class="header__logo">
          <img src="../images/image3.png" alt="Рыболовецкая артель">
        </a>
      </div>

      <div class="header__item header-right-menu">
          <?php if($_COOKIE['login']=='admin'){?>
            <!-- <a href="./admin.php" class="button header__sign header__sign-in">Админ</a> -->
          <? } ?>
          <?php if (empty($_COOKIE['login'])): ?>
              <a href="./login.php" class="button header__sign header__sign-in" tabindex="-1">Вход</a>
          
          <?php else: ?>
          <form action="auth.php" method="post">
              <button name="out" class="button header__sign header__sign-in">Выход</button>
          </form>
          <?php endif; ?>
      </div>

    </div>
  </div>

  <div class="page">
    <div class="page__inner">

      <div class="container container_offset">
          
        <div class="aside aside_right ">
          <div class="aside__panel paper">
            <h3 class="aside__title">
              <span class="aside__title-inner">Меню</span>
            </h3>
            <p></p>
            <div class="aside__content">
              <form method="post">
                  
                <?php 
                    if($_COOKIE["login"] == 'admin'){
                        $position_name = $_COOKIE["login"];
                    }
                    echo $position_name;
                    
                    
                    if($position_name == 'admin'): ?>
                    <br>
                        <button name = "table_selection" type="submit" class="button button_menu">Добавление</button><br>
                        
                        <button name = "registration_person" type="submit" class="button button_menu">Регистация</button><br>
                      <?php endif;
                      
                ?>
              </form>
            </div>
          </div>
        </div>

        <div class="page__wrapper page__wrapper_left">
          <section class="section paper tabs" id="latest-updates">
            <div class="section__header section__header_tabs">
              <span class="section__header-title">Добро пожаловать на сайт рыболовецкой артели!</span>
            </div>
            <div class="section__body">
              <div class="qwe2">
                <? 
                $query = "CALL GetAdminBoatCatchInfo();";
                $result = $con->query($query);
                echo "<table border='1'>";
                echo "<tr><th>Лодка</th><th>Капитан</th><th>Команда рыбаков</th><th>Дата вылова</th><th>Вид рыбы</th><th>Количество</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Лодка'] . "</td>";
                    echo "<td>" . $row['Капитан'] . "</td>";
                    echo "<td>" . $row['Команда рыбаков'] . "</td>";
                    echo "<td>" . $row['Дата вылова'] . "</td>";
                    echo "<td>" . $row['Вид рыбы'] . "</td>";
                    echo "<td>" . $row['Количество'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                $con->close();
                ?>
              </div>
              <div class="updates tabs__content tabs__content_show"> 
                <br>
                <p>Добавление вылова:</p>
                <form action="add_catch_info.php" method="post">
                    <label for="boat_id">Лодка:</label>
                    <select id="boat_id" name="boat_id">
                        <?php
                        include './config.php';
                        $query = 'SELECT boat_id, boat_name FROM Boat;';
                        $result = $con->query($query);
                        while ($boat_row = $result->fetch_assoc()) {
                            echo "<option value='" . $boat_row['boat_id'] . "'>" . $boat_row['boat_name'] . "</option>";
                        }
                        ?>
                    </select>
                    
                    <label for="catch_date">Дата вылова:</label>
                    <input type="date" id="catch_date" name="catch_date" required>
                    
                    <label for="fish_id">Вид рыбы:</label>
                    <select id="fish_id" name="fish_id">
                        <?php
                        $fish_query = "SELECT fish_id, fish_name FROM Fish";
                        $fish_result = $con->query($fish_query);
                        while ($fish_row = $fish_result->fetch_assoc()) {
                            echo "<option value='" . $fish_row['fish_id'] . "'>" . $fish_row['fish_name'] . "</option>";
                        }
                        ?>
                    </select>
                    
                    <label for="quantity">Количество:</label>
                    <input type="number" id="quantity" name="quantity" required>

                    <!-- <button name = "" type="submit" class="button button_menu">Добавить вылов</button><br> -->
                    <input type="submit" id="" class="button button_menu" name="" value="Добавить вылов" required>
                    
                </form>
                
                <p>Удаление вылова:</p>
                <?
                $query = "SELECT cf.catch_fish_id, b.boat_name, c.catch_date, f.fish_name, cf.quantity 
                    FROM Catch_Fish cf 
                    JOIN Catch c ON cf.catch_id = c.catch_id
                    JOIN Boat b ON c.boat_id = b.boat_id
                    JOIN Fish f ON cf.fish_id = f.fish_id";
                $result = $con->query($query);
                
                if ($result->num_rows > 0) {
                    ?>
                    <form action='delete_catch_info.php' method='post'>
                        <select name='catch_fish_id'>
                            <?php 
                            while ($row = $result->fetch_assoc()) { ?>
                            <option value='<?= $row['catch_fish_id'] ?>'>
                                <?= $row['boat_name'] ?> - <?= $row['catch_date'] ?> - <?= $row['fish_name'] ?> (<?= $row['quantity'] ?>)
                            </option>
                            <?php } ?>
                        </select>
                        <input type='submit' name='' class="button button_menu" value='Удалить' required>
                    </form>
                    <?php
                } else {
                    echo "Нет записей о вылове.";
                }
                
                
              
                if(isset($_POST['table_selection'])){
                    ?>
                    
                    <h3>Добавление</h3>
                    
                    <form method="post"> 
                        <?
                        $result = $con->query("Show tables");
                        $tables = array('Boat', 'Fish', 'Position', 'Role');
                        ?>
                        <label>Выберите таблицу</label>
                        <select name="table">
                            <?
                            while($row = $result->fetch_array()){
                                if (in_array($row[0], $tables)) {
                                    echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <button name = "num_of_lines" type="submit" class="button button_menu">Далее</button><br>
                    </form>
                    
                    <?
                }
                
                if(isset($_POST['num_of_lines'])){
                    $_SESSION['table'] = $_POST['table'];
                    ?>
                    <form method="post"> 
                    <label>Сколько строк добавить</label>
                    <input type="number" name="row_count" min="1" value="1">
                    <button name = "adding" type="submit" class="button button_menu">Далее</button><br>
                    </form>
                    <?
                }
                
                if(isset($_POST['adding'])){
                    $table = $_SESSION['table'];
                    $_SESSION['row_count'] = $_POST['row_count'];
                    $row_count = $_SESSION['row_count'];
                    
                    $result = $con->query("DESCRIBE $table");
                    ?>
                    
                    <form method="post">
                        <?
                        echo "<table border='1'>";
                        echo "<tr>";
                        while ($column = $result->fetch_assoc()) {
                            if ($column['Extra'] != 'auto_increment') {
                                echo "<th>" . $column['Field'] . "</th>";
                            }

                        }
                        echo "</tr>";
                        $result->data_seek(0);
                        
                        for ($i = 0; $i < $row_count; $i++) {
                            echo "<tr>";
                            while ($column = $result->fetch_assoc()) {
            
                                if ($column['Extra'] != 'auto_increment') {
                                    echo "<td><input type='text' name='" . $column['Field'] . "[$i]' required></td>";
                                }
                            }
                            echo "</tr>";
                            $result->data_seek(0);
                        }
                        
                        echo "</table>";
                        ?>
                        <button name = "submit_data" type="submit" class="button button_menu">Далее</button><br>
                    </form>
                    <?
                }
                
                if(isset($_POST['submit_data'])){
                    $table = $_SESSION['table'];
                    $row_count = $_SESSION['row_count'];
                    
                    $result = $con->query("DESCRIBE $table");
                    $columns = array();
                    while ($column = $result->fetch_assoc()) {
                       if ($column['Extra'] != 'auto_increment') {
                           $columns[] = $column['Field'];
                       }
                    }
                    
                    for ($i = 0; $i < $row_count; $i++) {
                        $values = array();
                        foreach ($columns as $column) {
                            $values[] = "'" . $_POST[$column][$i] . "'";
                        }
                        $values_str = implode(', ', $values);
                        $query = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES ($values_str)";
                        if (!$con->query($query)) {
                            //echo "Ошибка!";
                            //break;
                        } else {
                            echo "Данные успешно добавлены";
                        }
                    }
                }
                
                
                
                
                //delete//delete//delete//delete//delete//delete
                if(isset($_POST['table_selection_for_delete'])){
                    ?>
                    <form method="post"> 
                        <?
                        $result = $con->query("Show tables");
                        ?>
                        <label>Выберите таблицу</label>
                        <select name="table">
                            <?
                            while($row = $result->fetch_array()){
                                echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                            }
                            ?>
                        </select>
                        <button name = "" type="submit" class="button button_menu">Далее</button><br>
                    </form>
                    <?
                }
                
                if(isset($_POST[''])){
                    
                }
                
                if(isset($_POST['registration_person'])){
                    echo "<h1>Регистация</h1>";
                    
                    ?>
                    <form method="post" action="registration.php"> 
                        <label>Фамилия Имя Отчество</label><br>
                        <input name="last_name" type="text">
                        <input name="first_name" type="text">
                        <input name="middle_name" type="text"><br>
                    
                    
                        <label>Логин</label>
                        <input name="login_person" type="text"><br>
                        <label>Пароль</label>
                        <input name="password_person" type="text"><br>
                        <?
                        
                        $query = "select * from Position";
                        $result = $con->query($query);
                        
                        
                        echo "<label>Должность</label><br>
                        <fieldset>";
                        
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div>
                            <input id="<?=$row['position_id']?>" type='radio' name='Position' value="<?=$row['position_id']?>"> </input>
                            <label for="<?=$row['position_id']?>"><?=$row['position_name']?></label>
                            </div>
                            <?
                        }
                        echo "</fieldset>";
                        
                        
                        $query = "select * from Role";
                        $result = $con->query($query);
                        
                        echo "<label>Позиция</label><br>
                        <fieldset>";
                        
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div>
                            <input id="<?=$row['role_name']?>" type='radio' name='Role' value="<?=$row['role_name']?>"> </input>
                            <label for="<?=$row['role_name']?>"><?=$row['role_name']?></label>
                            </div>
                            <?
                        }
                        echo "</fieldset>";
                        
                        ?>
                        <label>Почта</label>
                        <input name="email" type="email"><br>
                        
                        <input type="submit" class="button button_menu" value="Отправить данные на почту" required> </input><br>

                    </form>
                    <?
                    
                }
                
                ?>
              </div>
              
            </div>
          </section>
        </div>
      </div>
      
    </div>
    

    <footer class="footer paper">
      <p>© 2024</p>
    </footer>
  </div>
  

  
</body>
</html>