<!DOCTYPE html>
<html>
<head>
    <title>Панель официанта</title>
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

        p {
            text-align: center;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            width: 200px; 
            text-align: center;
        }

        li {
            margin-bottom: 10px;
        }

        li a {
            display: block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        li a:hover {
            background-color: #0056b3;
        }

        a.logout-button {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color:rgb(0, 174, 255);
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        a.logout-button:hover {
            background-color:rgb(0, 183, 255);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Панель официанта</h1>
        <p>Добро пожаловать, официант!</p>

        <ul>
            <li><a href="new_order.php">Создать новый заказ</a></li>
        </ul>
        <a href="../index.php" class="logout-button">Выйти</a>
    </div>
</body>
</html>
