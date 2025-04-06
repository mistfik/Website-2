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

$message = ""; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST["table_number"];
    $customer_count = $_POST["customer_count"];
    $items = $_POST["items"];
    $waiter_id = $_POST["waiter_id"];

    if (empty($table_number) || empty($customer_count) || empty($items) || empty($waiter_id)) {
        $message = "Пожалуйста, заполните все поля.";
    } else {

        $stmt = $conn->prepare("INSERT INTO orders (table_number, customer_count, items, waiter_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $table_number, $customer_count, $items, $waiter_id);

        if ($stmt->execute()) {
            $message = "Заказ успешно добавлен!";
        } else {
            $message = "Ошибка добавления заказа: " . $conn->error;
        }
        $stmt->close();
    }
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
        body { font-family: sans-serif; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }

        form { width: 80%; margin: 20px auto; padding: 15px; border: 1px solid #ddd; }
        form label { display: block; margin-bottom: 5px; }
        form input[type="number"], form textarea, form select { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        form input[type="submit"] { background-color:rgb(0, 162, 255); color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
   <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="table_number">Номер стола:</label>
        <input type="number" id="table_number" name="table_number" required>

        <label for="customer_count">Количество клиентов:</label>
        <input type="number" id="customer_count" name="customer_count" required>

        <label for="items">Список блюд:</label>
        <textarea id="items" name="items" rows="4" required></textarea>

        <label for="waiter_id">ID официанта:</label>
        <input type="number" id="waiter_id" name="waiter_id" required>

        <input type="submit" value="Добавить заказ">
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Номер стола</th>
                <th>Количество клиентов</th>
                <th>Список блюд</th>
                <th>Статус</th>
                <th>Официант</th>
                <th>Дата создания</th>
                <th>Дата обновления</th>
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

</body>
</html>

<?php
$conn->close();
?>