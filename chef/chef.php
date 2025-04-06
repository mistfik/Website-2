<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "chef") {
    header("Location: login.php");
    exit;
}
$servername = "127.127.126.25";
$username = "root";
$password = "";
$dbname = "cafe_database";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, table_number, customer_count, items, status, waiter_id, created_at, updated_at
        FROM orders
        ORDER BY created_at DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Ошибка SQL: " . $conn->error);
}
$allowedStatuses = ["принято", "готовится", "готово", "оплачено"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Панель повара</title>
    <style>
body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

.container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            margin-bottom: 20px;
        }

table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }

th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

th {
            background-color:rgb(0, 102, 255);
        }

tr:nth-child(even) {
 background-color: #f9f9f9;
        }

select {
            padding: 5px;
 border-radius: 4px;
            border: 1px solid #ccc;
        }
button{
background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Все заказы</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Номер стола</th>
                <th>количество клиентов</th>
                <th>Блюда</th>
                <th>Статус</th>
                <th>ID Официанта</th>
                <th>Дата создания</th>
                <th>Дата обновления</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='order-row-" . htmlspecialchars($row["id"]) . "'>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["table_number"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["customer_count"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["items"]) . "</td>";
                    echo "<td>";
                    echo "<select onchange='updateStatus(" . htmlspecialchars($row["id"]) . ", this.value)'>";
                    foreach ($allowedStatuses as $status) {
                        $selected = ($row["status"] == $status) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($status) . "' " . $selected . ">" . htmlspecialchars($status) . "</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row["waiter_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["updated_at"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Нет заказов</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        function updateStatus(orderId, newStatus) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_order_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log("Статус успешно обновлен для заказа ID: " + orderId);
                  alert("Статус успешно обновлен!");
                } else {
                    console.error("Не удалось обновить статус для заказа ID: " + orderId, xhr.responseText);
                    alert("Не удалось обновить статус. Смотрите консоль для деталей.");
                }
            };
            xhr.onerror = function() {
                alert("Ошибка сети при обновлении статуса.");
            }
            xhr.send("order_id=" + orderId + "&status=" + encodeURIComponent(newStatus));
        }
    </script>
</body>
</html>
<?php
$conn->close();
?>