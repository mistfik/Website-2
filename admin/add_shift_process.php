<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "127.127.126.25";
$username = "root";
$password = "";
$dbname = "cafe_database";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_POST["user_id"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];

if (empty($user_id) || empty($start_time) || empty($end_time)) {
    die("Все поля обязательны для заполнения!");
}
$sql = "INSERT INTO shifts (user_id, start_time, end_time) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
  die("Ошибка подготовки запроса: " . $conn->error);
}

$stmt->bind_param("iss", $user_id, $start_time, $end_time);

if ($stmt->execute()) {
    header("Location: shifts.php");
    exit();
} else {
    echo "Ошибка при добавлении смены: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>