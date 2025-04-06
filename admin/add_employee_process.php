<?php
session_start();

$servername = "127.127.126.25";
$username = "root";
$password = "";
$dbname = "cafe_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    $role = $_POST["role"];
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("sss", $username, $password, $role); 

        if ($stmt->execute()) {

            echo "<p style='color: green;'>Сотрудник успешно добавлен!</p>"; 

            header("Location: employees.php");
            exit;
        } else {
            echo "Ошибка при добавлении сотрудника: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Ошибка подготовки запроса: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Недопустимый метод запроса.";
}
?>