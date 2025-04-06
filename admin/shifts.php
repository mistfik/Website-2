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

$sql = "SELECT shifts.id, users.username, shifts.start_time, shifts.end_time
        FROM shifts
        INNER JOIN users ON shifts.user_id = users.id
        ORDER BY shifts.start_time DESC";

$result = $conn->query($sql);

if (!$result) {
    echo "Ошибка SQL: " . $conn->error;
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Управление сменами</title>
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

    .shifts-table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px auto;
    }

    .shifts-table th,
    .shifts-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .shifts-table th {
        background-color:rgb(0, 162, 255);
    }

    .shifts-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .add-shift-form {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(54, 109, 134, 0.46);
    }

    .add-shift-form label {
        display: block;
        margin-bottom: 5px;
    }

    .add-shift-form input[type="datetime-local"],
    .add-shift-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .add-shift-form button[type="submit"] {
        background-color:rgb(0, 140, 255);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-shift-form button[type="submit"]:hover {
        background-color:rgb(0, 0, 0);
    }
    </style>
</head>
<body>
<div class="container">
    <h1>Управление сменами</h1>
    <table class="shifts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Сотрудник</th>
                <th>Начало смены</th>
                <th>Конец смены</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["start_time"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["end_time"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Нет смен</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <h2>Добавить новую смену</h2>
    <form action="add_shift_process.php" method="POST" class="add-shift-form">
        <label for="user_id">Сотрудник:</label>
        <select name="user_id" id="user_id" required>
            <?php
            $sql_users = "SELECT id, username FROM users WHERE role = 'waiter'";
            $result_users = $conn->query($sql_users);

            if ($result_users->num_rows > 0) {
                while ($user = $result_users->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($user["id"]) . "'>" . htmlspecialchars($user["username"]) . "</option>";
                }
            } else {
                echo "<option value=''>Нет официантов</option>";
            }
            ?>
        </select><br><br>

        <label for="start_time">Начало смены:</label>
        <input type="datetime-local" id="start_time" name="start_time" required><br><br>

        <label for="end_time">Конец смены:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br><br>

        <button type="submit">Добавить смену</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>