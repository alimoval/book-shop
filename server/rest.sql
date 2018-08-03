-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 03 2018 г., 17:54
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
  `price` int(15) NOT NULL,
  `color` varchar(15) NOT NULL,
  `year` int(4) NOT NULL,
  `gas` varchar(15) NOT NULL,
  `odo` int(15) NOT NULL,
  `engine` int(5) NOT NULL,
  `town` varchar(15) NOT NULL,
  `images` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `model`, `tm`, `price`, `color`, `year`, `gas`, `odo`, `engine`, `town`, `images`) VALUES
(1, 'Civic', 'Honda', 9000, 'black', 2008, 'gasoline/gas', 175000, 2, 'Mykolaiv', 'https://cdn4.riastatic.com/photosnew/auto/photo/honda_civic__243473714fx.webp');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
