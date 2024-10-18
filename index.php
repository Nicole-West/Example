<?php 
include './config.php';
include './pages/auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Итоговый проект 2024</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        .qwe2{
            display: block;
            flex-grow: 1;
            /* min-height: 150px; */
        }
        
        .section__body{
            flex-direction: column;
            align-items: flex-start;
            min-height: 450px;
        }
        .tabs__content_show {
            /* min-height: 500px; */
            display: block;
        }
    </style>
</head>
<body>

  <div class="header">
    <div class="header__inner">
      <div class="header__item header__left">
        <a href="/" class="header__logo">
          <img src="./images/image3.png" alt="Рыболовецкая артель">
        </a>
      </div>

      <div class="header__item header-right-menu">
          <form action="./pages/message.php" method="post">
              <button name="" class="button header__sign header__sign-in">Почта</button>
          </form>
          <?php if($_COOKIE['login']=='admin'){?>
            <a href="./pages/admin.php" class="button header__sign header__sign-in">Админ</a>
          <? } ?>
          
          <?php if (empty($_COOKIE['login'])): ?>
        <a
          href="./pages/login.php" class="button header__sign header__sign-in" tabindex="-1">Вход
        </a>
        <?php else: ?>
        
          <form action="pages/auth.php" method="post">
              <button name="out" class="button header__sign header__sign-in">Выход</button>
          </form>
        <?php endif; ?>
      </div>

    </div>
  </div>

  <div class="page">
    <div class="page__inner">

      <div class="container container_offset">

        <div class="page__wrapper page__wrapper_left">
          <section class="section paper tabs" id="latest-updates">
            <div class="section__header section__header_tabs">
              <span class="section__header-title">Добро пожаловать на сайт рыболовецкой артели!</span>
            </div>
            <div class="section__body">
                <div class="qwe2">
                    <?php
                    
                    if($_COOKIE["login"] == 'admin'){
                        $position_name = $_COOKIE["login"];
                    } 
                    else{
                        $position_name = $_SESSION['position_name'];
                    }
                    $person_id = $_SESSION['person_id'];
                    
                    if(!$_COOKIE["login"]){
                        
                    }
                 
                    if($position_name == 'Капитан'){
                        $queryAll = "CALL get_captain_boat_info(?)";
                        if ($stmt = $con->prepare($queryAll)) {
                            $stmt->bind_param("i", $person_id);
                            $stmt->execute();
                            $resultAll = $stmt->get_result();
                            
                            $dataAll = array();
                            while ($rowAll = $resultAll->fetch_assoc()) {
                                $dataAll[] = $rowAll;
                            }
                            if (!empty($dataAll)) {
                                echo "<table border='1'>";
                                echo "<tr><th>Лодка</th><th>Моряки</th><th>Дата выхода в море</th><th>Вид рыбы</th><th>Количество</th></tr>";
                                
                                foreach ($dataAll as $rowAll) {
                                    echo "<tr>";
                                    echo "<td>" . $rowAll['Лодка'] . "</td>";
                                    echo "<td>" . $rowAll['Моряки'] . "</td>";
                                    echo "<td>" . $rowAll['Дата выхода в море'] . "</td>";
                                    echo "<td>" . $rowAll['Вид рыбы'] . "</td>";
                                    echo "<td>" . $rowAll['Количество'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                        }
                        $stmt->close();
                    }
                
                    if($position_name == 'Менеджер'){
                        $qu = "SELECT manager_id FROM Manager  WHERE person_id = $person_id";
                        $res = $con->query($qu);
                        
                        $stmt = $con->prepare("CALL get_manager_boat_info(?)");
                        $stmt->bind_param("i", $res);
                        $stmt->execute();
                        
                        $result = $stmt->get_result();
                        
                        echo "<table border='1'>";
                        echo "<tr><th>Лодка</th><th>Дата вылова</th><th>Вид рыбы</th><th>Количество</th><th>Дата отправки</th></tr>";
                        
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['Лодка'] . "</td>";
                            echo "<td>" . $row['Дата вылова'] . "</td>";
                            echo "<td>" . $row['Вид рыбы'] . "</td>";
                            echo "<td>" . $row['Количество'] . "</td>";
                            echo "<td>" . $row['Дата отправки'] . "</td>";
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                        $stmt->close();
                    }
                    
                    if($position_name == 'Рыбак'){
                        
                        $stmt = $con->prepare("CALL get_sailor_boat_info(?)");
                        $stmt->bind_param("i", $person_id);
                        $stmt->execute();
                        
                        $result = $stmt->get_result();
                        
                        echo "<table border='1'>";
                        echo "<tr><th>Лодка</th><th>Капитан</th><th>Дата выхода в море</th><th>Вид рыбы</th><th>Количество</th></tr>";
                        
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Лодка"] . "</td>";
                            echo "<td>" . $row["Капитан"] . "</td>";
                            echo "<td>" . $row["Дата выхода в море"] . "</td>";
                            echo "<td>" . $row["Вид рыбы"] . "</td>";
                            echo "<td>" . $row["Количество"] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    
                    if($_COOKIE["login"] == 'admin'){
                        
                    }
                    
                    ?>
                </div>
                <div class="updates tabs__content tabs__content_show">
                
                    <p></p>
                    <?php
                    
                    if(isset($_POST['types_of_fish'])){
                        $query = "SELECT fish_name FROM view_fish_name ";
                        $result  = $con->query($query);
                        
                        
                        if ($result->num_rows > 0) {
                            
                            echo "<table border='1'>";
                            echo "<tr><th>Название рыбы</th></tr>";
                        
                            
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . htmlspecialchars($row['fish_name']) . "</td></tr>";
                            }
                        
                            
                            echo "</table>";
                        } else {
                            echo "Нет данных о рыбах.";
                        }
                    }
                    
                    if(isset($_POST['most_caught_fish'])){
                        
                        $query = "SELECT get_most_caught_fish() AS most_caught_fish";
                        
                        
                        $result = $con->query($query);
                        
                        
                        if ($result->num_rows > 0) {
                            
                            $row = $result->fetch_assoc();
                            echo "<p>Рыба, с наибольшим уловом: " . htmlspecialchars($row['most_caught_fish']) . "</p>";
                        } else {
                            echo "Нет данных о выловах.";
                        }
                    }
                    
                    if(isset($_POST['date_request'])) {
                        $query = "select distinct catch_date from Catch order by catch_date ASC";
                        $result = $con->query($query);
                        ?>
                            <form method="post" action="">
                                <lable>Выберите дату вылова:</lable><br>
                                <select name="catch_date">
                                    <?
                                    if ($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()){
                                            echo "<option values='" . htmlspecialchars($row['catch_date']) . "'>" . htmlspecialchars($row['catch_date']) . "</option>";
                                        }
                                    } else {
                                        echo "<option values=''>Нет доступных дат</option>";
                                    }
                                    ?>
                                </select>
                                <button name = "catch_info_by_date" type="submit">Выбрать</button>
                            </form>
                        <?php  
                    }
                    
                    if(isset($_POST['catch_info_by_date'])) {
                        $catch_date = $_POST['catch_date'];
                        $query = "CALL get_catch_info_by_date(?)";
                        if ($stmt = $con->prepare($query)) {
                            $stmt->bind_param("s", $catch_date);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if($result->num_rows>0){
                                echo "<table border='1'>";
                                echo "<tr><th>Дата вылова</th><th>Название лодки</th><th>Вид рыбы</th><th>Количество</th></tr>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['catch_date']) . "</td>
                                            <td>" . htmlspecialchars($row['boat_name']) . "</td>
                                            <td>" . htmlspecialchars($row['fish_name']) . "</td>
                                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                                          </tr>";
                                }
                                echo "</table>";
                            } else {
                            echo "Нет данных о вылове на указанную дату.";
                            }
                        }
                    }
                    
                    if(isset($_POST['boat_request'])) {
                        $stmt = $con->prepare("SELECT boat_id, boat_name FROM Boat");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        ?>
                        <form method="post">
                            <select name='boat_id'>
                                <?
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['boat_id'] . "'>" . $row['boat_name'] . "</option>";
                                }
                                ?>
                            </select>
                            <button name = "catch_by_boat" type="submit">Выбрать</button>
                        </form>
                        <?
                    }
                    
                    if(isset($_POST['catch_by_boat'])){
                        $boat_id = $_POST['boat_id'];
                        
                        $stmt = $con->prepare("CALL p_catches_by_boat(?)");
                        $stmt->bind_param("i", $boat_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "Имя судна: " . $row['boat_name'] . "<br>";
                            echo "Дата: " . $row['catch_date'] . "<br>";
                            echo "Название рыбы: " . $row['fish_name'] . "<br>";
                            echo "Количество: " . $row['quantity'] . "<br><br>";
                        }
                    }
                    
                    
                    
                    if(isset($_POST['graph'])){
                        require ('./g/vendor/mitoteam/jpgraph/src/lib/jpgraph.php');
                        require ('./g/vendor/mitoteam/jpgraph/src/lib/jpgraph_bar.php');
                        
                        
                        
                            $query = "SELECT f.fish_name AS Рыба, SUM(cf.quantity) AS Суммарный_улов
                                        FROM Catch_Fish cf
                                        JOIN Fish f ON cf.fish_id = f.fish_id
                                        GROUP BY f.fish_name
                                        ORDER BY Суммарный_улов;";
                                        
                            $result = $con->query($query);
                            
                            $fish_names = [];
                            $catches = [];
                            
                            while ($row = $result->fetch_assoc()) {
                                $fish_names[] = $row['Рыба'];
                                $catches[] = $row['Суммарный_улов'];
                            }
                            
                            $graph = new Graph(600, 400);
                            $graph->SetScale('textlin');
                            
                            $graph->title->Set('Суммарный улов рыбы');
                            $graph->xaxis->title->Set('Вид рыбы');
                            $graph->yaxis->title->Set('Количество');
    
                            // Create a TextTick scale for the x-axis
                            $graph->xaxis->SetTickLabels($fish_names);
                            
                            
                            $barplot = new BarPlot($catches);
                            $barplot->SetFillColor('blue');
                            
                            $graph->Add($barplot);
                            
                            $graph->Stroke("mygraph2.png");
                            /*echo '<img src="mygraph2.png" alt="JPGraph" width="600" height="400">';*/
                            
                            if (file_exists('./mygraph2.png')) {
                                echo '<img src="mygraph2.png" alt="JPGraph">';
                        }
                                            
                    }
                    
                    
                    
                    
                    ?>
                </div>
              

              
            </div>
          </section>
        </div>
  
        <div class="aside aside_right ">
          <div class="aside__panel paper">
            <h3 class="aside__title">
              <span class="aside__title-inner">Меню</span>
            </h3>
            <p></p>
            <div class="aside__content">
                
              <form method="post">
                  
                      <?echo $position_name;?>
                      <br>
                  
                      <?php if (empty($_COOKIE['login'])): ?><!--  || $_COOKIE["login"] == 'admin'): ?> -->
                      <button name = "types_of_fish" type="submit" class="button button_menu">Представление(Виды рыб)</button><br>
                      <button name = "most_caught_fish" type="submit" class="button button_menu">Функция(Рыба с наиб. уловом)</button><br>
                      <button name = "date_request" type="submit" class="button button_menu">Процедура(Улов по дате)</button><br>
                      <?php endif; ?>
                  
                      <!-- общее/рыбаки -->
                      <?php if(!empty($_COOKIE['login'])): ?>
                        <button name = "graph" type="submit" class="button button_menu">График()</button><br>
                      <?php endif; ?>
                      
                      <!-- для менеджера -->
                      
                      
                      <!-- для капитана -->
                      <?php if($position_name == 'Капитан'): ?><!--  || $_COOKIE["login"] == 'admin'): ?> -->
                        <button name = "boat_request" type="submit" class="button button_menu">Процедура(Улов по лодкам)</button><br>
                      <?php endif; ?>
              </form>
              
            </div>
          </div>
        </div>
      </div>
      
    </div>
    

    <footer class="footer paper">
      <p>© 2024</p>
    </footer>
  </div>
  

  
</body>
</html>