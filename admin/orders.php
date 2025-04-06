<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "127.127.126.25";
$username = "root";
$password = "";
$dbname = "cafe_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

$sql = "SELECT orders.id, orders.table_number, orders.customer_count, orders.items, orders.status, users.username AS waiter_name, orders.created_at, orders.updated_at
        FROM orders
        INNER JOIN users ON orders.waiter_id = users.id
        ORDER BY orders.created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    echo "Ошибка SQL: " . $conn->error;
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Управление заказами</title>
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
        .orders-table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }

        .orders-table th,
        .orders-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .orders-table th {
            background-color:rgb(0, 174, 255);
        }

        .orders-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Управление заказами</h1>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Столик</th>
                    <th>Гостей</th>
                    <th>Заказано</th>
                    <th>Статус</th>
                    <th>Официант</th>
                    <th>Создан</th>
                    <th>Обновлен</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["table_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["customer_count"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["items"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["waiter_name"]) . "</td>";
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
    </div>
</body>
</html>

<?php
$conn->close();
?>