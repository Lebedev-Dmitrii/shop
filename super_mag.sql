-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 20 2019 г., 19:55
-- Версия сервера: 5.7.24
-- Версия PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `super_mag`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `sort_order`, `status`) VALUES
(1, 'Рубашки', 1, 1),
(2, 'Платья', 2, 1),
(3, 'Футболки', 3, 1),
(4, 'Сумки', 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `price` float NOT NULL,
  `availability` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT '0',
  `is_recommended` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `category_id`, `code`, `price`, `availability`, `brand`, `image`, `description`, `is_new`, `is_recommended`, `status`) VALUES
(1, 'продукт 1 - рубашка', 1, 53543, 552, 1, 'Piazza', '', 'Описание продукта 1', 0, 0, 1),
(2, 'продукт 2 - рубашка', 1, 17468, 777, 1, 'DKNY', '', 'Описание продукта 2', 1, 1, 1),
(3, 'продукт 3 - рубашка', 1, 87345, 832, 1, 'Piazza', '', 'Описание продукта 3', 0, 1, 1),
(4, 'продукт 4 - рубашка', 1, 17849, 1229, 0, 'G-star', '', 'Описание продукта 4', 1, 1, 1),
(5, 'продукт 5 - рубашка', 1, 83222, 1009, 0, 'G-star', '', 'Описание продукта 5', 0, 1, 1),
(6, 'продукт 6 - рубашка', 1, 12267, 788.5, 1, 'Piazza', '', 'Описание продукта 6', 0, 1, 1),
(7, 'продукт 7 - сумка', 4, 18734, 435, 1, 'D&G', '', 'Описание продукта 7', 0, 0, 1),
(8, 'продукт 8 - футболка', 3, 458963, 22.6, 1, 'D&G', '', 'Описание продукта 8', 0, 0, 1),
(9, 'продукт 9 - платье', 2, 432536475, 56, 1, 'Zara', '', 'Описание продукта 9', 0, 1, 1),
(10, 'продукт 10 - рубашка', 1, 3569, 8.76, 1, 'H&M', '', 'Описание продукта 10', 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_order`
--

DROP TABLE IF EXISTS `product_order`;
CREATE TABLE IF NOT EXISTS `product_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_comment` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `products` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_order`
--

INSERT INTO `product_order` (`id`, `user_name`, `user_phone`, `user_comment`, `user_id`, `date`, `products`, `status`) VALUES
(1, 'Aaaaaaaaaaaa', '111111111111111111111111111', '', 1, '2019-03-16 17:51:57', '{\"7\":2}', 1),
(2, 'Aaaaaaaaaaaa', '1111111111111111111', '', 1, '2019-03-16 18:15:10', '{\"8\":2,\"7\":1}', 1),
(3, 'Aaaaaaaaaaaa', '7777777777', '', 1, '2019-03-20 17:17:25', '{\"9\":3,\"8\":1}', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Aaaaaaaaaaaa', 'aaa@aaa.aa', '111111'),
(2, 'qqqqqqqqqqqqqqqqq', 'fsvjkaern@fskdjv.rvjaeb', 'arerjbqvor'),
(3, 'gg', 'ggg@ggg.gg', '222222'),
(4, 'vv', 'vvv@vvv.vv', '333333'),
(10, 'mm', 'mmm@mmm.mm', '555555'),
(11, 'bb', 'bbb@bbb.bb', '111111'),
(12, 'фывап', 'i@i.i', 'zxcvbnm');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
