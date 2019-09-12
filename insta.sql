-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Час створення: Вер 12 2019 р., 11:12
-- Версія сервера: 5.7.21
-- Версія PHP: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `insta`
--

CREATE DATABASE insta;

use insta;

-- --------------------------------------------------------

--
-- Структура таблиці `photo`
--

CREATE TABLE `photo` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `likes` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `photo`
--

INSERT INTO `photo` (`id`, `user_id`, `path`, `likes`) VALUES
(1, 5, 'images/profiles/man.jpg', 0),
(2, 6, 'images/profiles/woman.jpg', 0),
(3, 5, 'images/photoes/2d3b72a92d645e17c79e8d7596915c1b.jpg', 0),
(4, 5, 'images/photoes/47f5f9c6dd325428fec691d946691e5a.jpg', 0),
(5, 5, 'images/photoes/996aab41ff835efe4db1682d7e7c454f.jpg', 0),
(6, 5, 'images/photoes/5af07e07f141fc36812a822223876c9b.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `valid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `valid`) VALUES
(5, 'root', '', '', 'koz@gmail.com', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 1),
(6, 'olga', '', '', 'email@gmail.com', '4925da7da7a56260baf1c37925a8fa24e46ad8b107dcd21f44e39e4751bae1304fc70de7acb847ffa96126bb372de005f5320f1ede6f9df07c7d53f9c160f022', 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
