<?php
session_start();
$host = '127.127.126.25';
$db   = 'cafe_database';
$user = 'root';
$pass = '';
$port = "3306";

$dsn = "mysql:host=$host;dbname=$db;port=$port";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];


    $stmt = $pdo->prepare("SELECT id, role FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        switch ($user["role"]) {
            case "admin":
                header("Location: admin/admin.php");
                break;
            case "chef":
                header("Location: chef/chef.php");
                break;
            case "waiter":
                header("Location: waiter/waiter.php");
                break;
            default:
                echo "Неизвестная роль!";
        }
        exit;
    } else {
        $error_message = "<p class='error-message'>Неверное имя пользователя или пароль.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            text-align: left;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        
        .error-message {
            color: #e74c3c;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Вход</h1>
        <form method="post">
            <label for="username">Имя пользователя:</label><br>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Войти">
        </form>

        <?php if (isset($error_message)) {
            echo $error_message;
        } ?>
    </div>
</body>
</html>