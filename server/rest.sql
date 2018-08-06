-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 06 2018 г., 10:12
-- Версия сервера: 5.6.38
-- Версия PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model` varchar(25) NOT NULL,
  `tm` varchar(25) NOT NULL,
  `price` int(11) NOT NULL,
  `color` varchar(25) NOT NULL,
  `year` varchar(25) NOT NULL,
  `gas` varchar(25) NOT NULL,
  `odo` varchar(25) NOT NULL,
  `engine` varchar(25) NOT NULL,
  `town` varchar(25) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `model`, `tm`, `price`, `color`, `year`, `gas`, `odo`, `engine`, `town`, `images`) VALUES
(1, 'Civic', 'Honda', 9000, 'black', '2008', 'gas', '125000', '1800', 'Mykolaiv', 'https://cdn4.riastatic.com/photosnew/auto/photo/honda_civic__242203354fx.webp'),
(2, 'Micra', 'Nissan', 7000, 'silver', '2007', 'gasoline', '160000', '1400', 'Mykolaiv', 'https://cdn4.riastatic.com/photosnew/auto/photo/nissan_micra__243070814fx.webp'),
(5, '04', 'JIGA', 2000, 'WHITE', '2004', 'GAS', '15000', '1500', 'Mykolaiv', 'https://cdn1.riastatic.co.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Dima', 'diminapochta@gmail.com', '333'),
(2, 'peter', 'petere@mail.com', '1212');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
