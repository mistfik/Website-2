-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Апр 07 2025 г., 00:46
-- Версия сервера: 5.7.44
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cafe_database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `customer_count` int(11) NOT NULL DEFAULT '1',
  `items` varchar(255) DEFAULT NULL,
  `status` enum('принято','готовится','готово','оплачено') NOT NULL DEFAULT 'принято' COMMENT 'Статус заказа (принято, готовится, готово, оплачено)',
  `waiter_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `table_number`, `customer_count`, `items`, `status`, `waiter_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Борщ, Хлеб, Компот', 'готовится', 3, '2025-04-05 20:52:23', '2025-04-06 18:12:29'),
(2, 5, 2, 'Салат \"Цезарь\", Паста Карбонара, Два Латте', 'готовится', 4, '2025-04-05 20:52:23', '2025-04-05 20:52:23'),
(3, 3, 4, 'Пицца \"Маргарита\", Стейк из лосося, Три Coca-Cola', 'готовится', 3, '2025-04-05 20:52:23', '2025-04-06 18:12:25'),
(12, 2, 3, 'Кола', 'готовится', 3, '2025-04-06 17:53:08', '2025-04-06 18:12:31'),
(14, 2, 3, 'Кола, Борщ', 'готовится', 3, '2025-04-06 17:53:43', '2025-04-06 18:12:33'),
(15, 1, 3, 'Кола,Борщ,Вода', 'готовится', 4, '2025-04-06 17:54:19', '2025-04-06 19:44:08'),
(16, 5, 3, 'Кола, Картошка, Борщ, Вода, Цезарь', 'оплачено', 3, '2025-04-06 18:15:36', '2025-04-06 19:13:11'),
(17, 2, 2, 'Сода', 'готовится', 3, '2025-04-06 19:44:55', '2025-04-06 19:45:18');

-- --------------------------------------------------------

--
-- Структура таблицы `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `shifts`
--

INSERT INTO `shifts` (`id`, `user_id`, `start_time`, `end_time`) VALUES
(1, 3, '2024-01-01 08:00:00', '2024-01-01 16:00:00'),
(2, 4, '2024-01-01 16:00:00', '2024-01-02 00:00:00'),
(3, 3, '2024-01-02 08:00:00', '2024-01-02 16:00:00'),
(4, 4, '2024-01-02 16:00:00', '2024-01-03 00:00:00'),
(5, 3, '2025-04-06 23:48:00', '2025-04-06 01:48:00'),
(6, 3, '2025-04-06 21:49:00', '2025-04-06 22:49:00'),
(7, 4, '2025-04-06 23:55:00', '2025-04-06 23:59:00'),
(8, 4, '2025-04-20 01:00:00', '2025-04-20 22:04:00'),
(9, 3, '2025-04-06 22:13:00', '2025-04-06 22:14:00'),
(10, 4, '2025-04-13 22:18:00', '2025-04-13 23:18:00'),
(11, 5, '2025-04-13 23:14:00', '2025-04-13 00:15:00'),
(12, 4, '2025-04-07 01:42:00', '2025-04-07 02:42:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT 'Логин пользователя',
  `password` varchar(255) NOT NULL COMMENT 'Хэш пароля',
  `role` enum('admin','chef','waiter') NOT NULL DEFAULT 'waiter' COMMENT 'admin, chef, waiter'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'password123', 'admin'),
(2, 'chef', 'password321', 'chef'),
(3, 'waiter1', 'password321', 'waiter'),
(4, 'waiter2', 'securepass', 'waiter'),
(5, 'waiter3', '112233', 'waiter'),
(11, 'admin10', 'll', 'admin'),
(12, 'JG', '1122', 'chef');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waiter_id` (`waiter_id`);

--
-- Индексы таблицы `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shifts_user_id_idx` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_waiter_id` FOREIGN KEY (`waiter_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `fk_shifts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
