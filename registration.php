<?php
include './config.php';
session_start();

                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $middle_name = $_POST['middle_name'];
                    $login_person = $_POST['login_person'];
                    $password_person = $_POST['password_person']; 
                    $position_id = $_POST['Position']; 
                    $role_name = $_POST['Role']; 
                    $email = $_POST['email'];
                    
                    
                    $role_query = "SELECT role_id FROM Role WHERE role_name = ?;";
                    $stmt_role = $con->prepare($role_query);
                    $stmt_role->bind_param('s', $role_name);
                    $stmt_role->execute();
                    $result_role = $stmt_role->get_result();
                    
                    if($result_role->num_rows > 0){
                        $row = $result_role->fetch_assoc();
                        $role_id = $row['role_id'];
                    }
                    $stmt_role->close();
                    
                    $query = "INSERT INTO Person (first_name, last_name, middle_name, position_id, role_id, login, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param('sssiiss', $first_name, $last_name, $middle_name, $position_id, $role_id, $login_person, $password_person);
                  
                    
                    if($stmt->execute()){
                          $stmt->close();
                          $person_id = $con->insert_id;
                        
                        if ($position_id == 2) {
                            
                            $query_manager = "INSERT INTO Manager (person_id) VALUES (?)";
                            $stmt_manager = $con->prepare($query_manager);
                            $stmt_manager->bind_param("i", $person_id);
                            $stmt_manager->execute();
                            $stmt_manager->close();
                        } else {
                            $query_sailor = "INSERT INTO Sailor (person_id) VALUES (?)";
                            $stmt_sailor = $con->prepare($query_sailor);
                            $stmt_sailor->bind_param("i", $person_id);
                            $stmt_sailor->execute();
                            $stmt_sailor->close();
                        }
                        
                        require "../w/vendor/autoload.php";                        
                        //письмо
                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);                        
                        $mail -> Host = "";                        
                        $mail->Username = "";
                        $mail->Password = "";                        
                        $mail->SMTPSecure = "";
                        $mail->Port = ;                        
                        $mail -> setFrom ('mail@mail.ru', 'Почти настоящая компания');                        
                        $mail -> addAddress($email, $_POST['first_name']);
                        $mail -> Subject = "Регистрация на сайте";                        
                        $mail->Body = "Здравствуйте, $first_name $last_name!                        
                        Вы успешно зарегистрировались.\nВаши данные:<br>
                        Логин: $login_person<br>Пароль: $password_person<br><br>                        
                        Спасибо за регистрацию!";
                        $mail->isHTML(true);
                                              
                        //отправляем                        
                        if($mail->send()){
                            header('Location: ./admin.php');
                        }
                        else{                            
                            echo "Не вышло";
                        }
                    }
                    else{
                        echo "не вышло";
                    }
                    
?>

