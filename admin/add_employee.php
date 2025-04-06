<!DOCTYPE html>
<html>
<head>
    <title>Добавить сотрудника</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Добавить сотрудника</h1>
    <form action="add_employee_process.php" method="post">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Роль:</label>
        <select id="role" name="role">
            <option value="admin">Администратор</option>
            <option value="chef">Повар</option>
            <option value="waiter">Официант</option>
        </select><br><br>

        <input type="submit" value="Добавить">
        <a href="employees.php">Отмена</a>
    </form>
</body>
</html>