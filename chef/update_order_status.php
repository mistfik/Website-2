<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "127.127.126.25";
    $username = "root";
    $password = "";
    $dbname = "cafe_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $order_id = isset($_POST["order_id"]) ? intval($_POST["order_id"]) : 0;
    $status = isset($_POST["status"]) ? trim($_POST["status"]) : ""; 
    $allowedStatuses = ["принято", "готовится", "готово", "оплачено"];

    if (!in_array($status, $allowedStatuses)) {
        http_response_code(400);
        echo "Недопустимый статус: " . htmlspecialchars($status);
        $conn->close();
        exit;
    }

    $maxLength = 20; 
    if (strlen($status) > $maxLength) {
        http_response_code(400);
        echo "Статус слишком длинный (максимум " . $maxLength . " символов).";
        $conn->close();
        exit;
    }



    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo "Ошибка подготовки запроса: " . $conn->error;
        $conn->close();
        exit;
    }

    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "success"; 
    } else {
        http_response_code(500);
        echo "Ошибка выполнения запроса: " . $stmt->error;
    }

    $conn->close();
} else {
    http_response_code(400);
    echo "Неправильный запрос";
}
?>