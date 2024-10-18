<?
include './config.php';
$catch_fish_id = $_POST['catch_fish_id'];
$query = "SELECT c.catch_date, c.boat_id FROM Catch_Fish cf 
          JOIN Catch c ON cf.catch_id = c.catch_id 
          WHERE cf.catch_fish_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $catch_fish_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $catch_date = $row['catch_date'];
    $boat_id = $row['boat_id'];
    
    $delete_query = "DELETE FROM Catch_Fish WHERE catch_fish_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $catch_fish_id);
    $stmt->execute();
    
    $check_query = "SELECT COUNT(*) AS count FROM Catch_Fish cf 
                    JOIN Catch c ON cf.catch_id = c.catch_id 
                    WHERE c.boat_id = ? AND c.catch_date = ?";
    $check_stmt = $con->prepare($check_query);
    $check_stmt->bind_param("is", $boat_id, $catch_date);
    $check_stmt->execute();
    
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    
    if ($check_row['count'] == 0) {
        $delete_catch_query = "DELETE FROM Catch WHERE boat_id = ? AND catch_date = ?";
        $delete_catch_stmt = $con->prepare($delete_catch_query);
        $delete_catch_stmt->bind_param("is", $boat_id, $catch_date);
        $delete_catch_stmt->execute();
    }
}
$stmt->close();

header('Location: ./admin.php');
?>