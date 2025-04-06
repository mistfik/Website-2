<!DOCTYPE html>
<html>
<head>
<title>Панель администратора</title>
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


ul {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center; 
}

li {
    display: inline-block; 
    margin: 10px; 
}

li a {
    display: block; 
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease; 
    min-width: 150px; 
    text-align: center; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); 
}

li a:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

p {
    text-align: center;
    font-size: 1.1em;
}
</style>
</head>
<body>
<div class="container">
    <h1>Панель администратора</h1>
    <p>Добро пожаловать, администратор!</p>

    <ul>
        <li><a href="employees.php">Управление сотрудниками</a></li>
        <li><a href="orders.php">Просмотр всех заказов</a></li>
        <li><a href="shifts.php">Управление сменами</a></li>
        <li><a href="../index.php">Выйти</a></li>
    </ul>
</div>
</body>
</html>