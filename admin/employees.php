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
$sql = "SELECT id, username, role FROM users";
$result = $conn->query($sql);
if (!$result) {
    echo "Ошибка SQL: " . $conn->error;
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Управление сотрудниками</title>
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
    .employee-table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px auto;
    }

    .employee-table th,
    .employee-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .employee-table th {
        background-color:rgb(0, 162, 255);
    }

    .employee-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .add-employee-form {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(39, 46, 109, 0.29);
    }

    .add-employee-form label {
        display: block;
        margin-bottom: 5px;
    }

    .add-employee-form input[type="text"],
    .add-employee-form input[type="password"],
    .add-employee-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .add-employee-form button[type="submit"] {
        background-color:rgb(0, 162, 255);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-employee-form button[type="submit"]:hover {
        background-color:rgb(0, 0, 0);
    }
    </style>
</head>
<body>
<div class="container">
    <h1>Управление сотрудниками</h1>
    <table class="employee-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Роль</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Нет пользователей</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Добавить нового сотрудника</h2>
    <form action="add_employee_process.php" method="POST" class="add-employee-form">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="role">Роль:</label>
        <select id="role" name="role" required>
            <option value="admin">Администратор</option>
            <option value="chef">Повар</option>
            <option value="waiter">Официант</option>
        </select><br><br>

        <button type="submit">Добавить сотрудника</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>