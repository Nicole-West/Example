<?
include './config.php';

        $boat_id = $_POST['boat_id'];
        $catch_date = $_POST['catch_date'];
        $fish_id = $_POST['fish_id'];
        $quantity = $_POST['quantity'];
        
        
        $catch_check_query = "SELECT catch_id FROM Catch WHERE boat_id = ? AND catch_date = ?";
        $stmt = $con->prepare($catch_check_query);
        $stmt->bind_param("is", $boat_id, $catch_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($result->num_rows > 0) {
            $catch = $result->fetch_assoc();
            $catch_id = $catch['catch_id'];
        } else {
            $catch_insert_query = "INSERT INTO Catch (boat_id, catch_date) VALUES (?, ?)";
            $stmt = $con->prepare($catch_insert_query);
            $stmt->bind_param("is", $boat_id, $catch_date);
            if ($stmt->execute()) {
                $catch_id = $stmt->insert_id;
            } else {
                echo "Ошибка добавления";
                exit;
            }
        }
        
        $catch_fish_insert_query = "INSERT INTO Catch_Fish (catch_id, fish_id, quantity) VALUES (?, ?, ?)";
        $stmt = $con->prepare($catch_fish_insert_query);
        $stmt->bind_param("iii", $catch_id, $fish_id, $quantity);
        $stmt->execute();
        
        $stmt->close();
        header('Location: ./admin.php');
?>