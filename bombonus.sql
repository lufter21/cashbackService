-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 02 2018 г., 15:23
-- Версия сервера: 5.6.37
-- Версия PHP: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bombonus`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `alias` varchar(255) NOT NULL,
  `nav` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `all_qnt` smallint(5) UNSIGNED NOT NULL,
  `ru_qnt` smallint(5) UNSIGNED NOT NULL,
  `ua_qnt` smallint(5) UNSIGNED NOT NULL,
  `name_shops` varchar(255) NOT NULL,
  `title_shops` varchar(255) NOT NULL,
  `description_shops` varchar(255) NOT NULL,
  `text_shops` text NOT NULL,
  `all_shops` smallint(5) UNSIGNED NOT NULL,
  `ru_shops` smallint(5) UNSIGNED NOT NULL,
  `ua_shops` smallint(5) UNSIGNED NOT NULL,
  `key_s` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `alias`, `nav`, `name`, `title`, `description`, `text`, `all_qnt`, `ru_qnt`, `ua_qnt`, `name_shops`, `title_shops`, `description_shops`, `text_shops`, `all_shops`, `ru_shops`, `ua_shops`, `key_s`) VALUES
(1, 'kompyuteri', 'Компьютеры', 'Компьютеры', 'Скидки на компьютеры', '', '', 11, 0, 0, '', '', '', '', 0, 0, 0, 'компьютер'),
(2, 'elektronika', 'Электроника', 'Электронику', 'Скидки на электронику', '', '', 11, 0, 0, '', '', '', '', 0, 0, 0, 'электрон'),
(3, 'avtotovari', 'Автотовары', 'Автотовары', 'Скидки на автотовары', '', '', 1, 0, 0, '', '', '', '', 3, 3, 0, 'автотовар'),
(4, 'odezhda', 'Одежда', 'Одежда', 'Скидки на одежду', '', '', 16, 0, 0, '', '', '', '', 5, 7, 0, 'одежд'),
(5, 'aksessuari', 'Аксессуары', 'Аксессуары', 'Скидки на аксессуары', '', '', 18, 0, 0, '', '', '', '', 5, 8, 0, 'аксессуар'),
(6, 'moda', 'Мода', 'Модные товары', 'Скидки на модные товары', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'мода'),
(7, 'krasota', 'Красота', 'Товары для красоты', 'Скидки на товары для красоты', '', '', 14, 0, 0, '', '', '', '', 1, 4, 0, 'красот'),
(8, 'zdorove', 'Здоровье', 'Товары для здоровья', 'Скидки на товары для здоровья', '', '', 14, 0, 0, '', '', '', '', 1, 4, 0, 'здоров'),
(9, 'detskie-tovari', 'Детские товары', 'Детские товары', 'Скидки и акции на детские товары от лучших интернет магазинов. Радуйте своих детишек и при этом экономьте', 'Акции и скидки на детские товары от самых хороших интернет магазинов. Все товары для детей отличного качества, а сэкономленные деньги - это очень приятно.', '', 10, 0, 0, '', '', '', '', 2, 8, 0, 'дет'),
(10, 'dlya-doma', 'Для дома', 'Товары для дома', 'Скидки на товары для дома', '', '', 15, 0, 0, '', '', '', '', 3, 5, 0, 'дом'),
(11, 'obuv', 'Обувь', 'Обувь', 'Скидки на обувь', '', '', 13, 0, 0, '', '', '', '', 5, 7, 0, 'обув'),
(12, 'sportivnie-tovari', 'Спортивные товары', 'Спортивные товары', 'Скидки на спортивные товары', '', '', 20, 0, 0, '', '', '', '', 2, 3, 0, 'спорт'),
(13, 'chasi', 'Часы', 'Часы', 'Скидки на часы', '', '', 10, 0, 0, '', '', '', '', 0, 0, 0, 'часы'),
(14, 'turizm', 'Туризм', 'Туризм', 'Скидки на товары для туризма', '', '', 1, 0, 0, '', '', '', '', 0, 0, 0, 'туризм'),
(15, 'puteshestviya', 'Путешествия', 'Путешествия', 'Скидки на путешествия', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'путешеств'),
(16, 'igrushki', 'Игрушки', 'Игрушки', 'Скидки на игрушки', '', '', 8, 0, 0, '', '', '', '', 0, 1, 0, 'игр'),
(17, 'cveti', 'Цветы', 'Цветы', 'Скидки на цветы', '', '', 11, 0, 0, '', '', '', '', 0, 0, 0, 'цветы'),
(18, 'podarki', 'Подарки', 'Подарки', 'Скидки на подарки', '', '', 11, 0, 0, '', '', '', '', 0, 1, 0, 'подар'),
(19, 'zoo-tovari', 'ЗОО товары', 'ЗОО товары', 'Скидки на зоо товары', '', '', 5, 0, 0, '', '', '', '', 0, 0, 0, 'зоо'),
(20, 'bitovaya-tekhnika', 'Бытовая техника', 'Бытовая техника', 'Скидки на бытовую технику', '', '', 0, 0, 0, '', '', '', '', 5, 9, 0, 'бытов'),
(21, 'krediti', 'Кредиты', 'Кредиты', 'Скидки на кредиты', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'кредит'),
(22, 'obrazovanie', 'Образование', 'Образование', 'Скидки на образование', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'образован'),
(23, 'eda', 'Еда', 'Еда', 'Скидки на еду', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'еда'),
(24, 'uslugi', 'Услуги', 'Услуги', 'Скидки на услуги', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'услуг'),
(25, 'cifrovaya-tekhnika', 'Цифровая техника', 'Цифровая техника', 'Скидки на цифровую технику', '', '', 0, 0, 0, '', '', '', '', 5, 9, 0, 'цифров'),
(26, 'tovari-iz-kitaya', 'Товары из Китая', 'Товары из Китая', 'Скидки на товары из Китая', '', '', 0, 0, 0, '', '', '', '', 7, 1, 0, 'китая'),
(27, 'strakhovanie', 'Страхование', 'Страхование', 'Скидки на страховку', '', '', 0, 0, 0, '', '', '', '', 0, 0, 0, 'страхов');

-- --------------------------------------------------------

--
-- Структура таблицы `discounts`
--

CREATE TABLE `discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `shop` varchar(21) NOT NULL,
  `promocode` varchar(21) NOT NULL,
  `discount` varchar(21) NOT NULL,
  `dis_count` smallint(5) UNSIGNED NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `region` varchar(3) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `discounts`
--

INSERT INTO `discounts` (`id`, `category`, `title`, `description`, `shop`, `promocode`, `discount`, `dis_count`, `date_start`, `date_end`, `url`, `region`, `available`) VALUES
(11458441, 'Товары для детей, Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Компьютеры и электроника, Цветы и подарки, Часы и украшения, Зоотовары, Игры, Автотовары, Инструменты и садовая техника, Товары для туризма', 'Быстрые Сделки! Скидки до 70% каждый день на все виды товаров!', 'Ввод промокода не требуется.\r\nАкция действует на все товары.', 'aliexpress', '', '70%', 70, '2017-10-09 16:30:00', '2017-12-31 23:59:00', 'https://alitems.com/g/1ezic5y5ke30b9bc509216525dc3e8/?i=3', 'all', 1),
(11589301, 'Аксессуары и сумки, Одежда, Спорт и отдых', 'Hot Products! Скидки до 70% на товары всех категорий!', '', 'aliexpress', '', '70%', 70, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/u9znr3usrp30b9bc509216525dc3e8/?i=3', 'all', 1),
(11589351, 'Красота и здоровье, Товары для дома', 'Hot Products! Скидки до 50% на товары для красоты и здоровья!', '', 'aliexpress', '', '50%', 50, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/pedr50vupd30b9bc509216525dc3e8/?i=3', 'all', 1),
(11589441, 'Товары для детей, Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Игры', 'Hot Products! Скидки до 50% на детскую одежду, обувь, игрушки и товары для безопасности!', '', 'aliexpress', '', '50%', 50, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/7qyb3j60y430b9bc509216525dc3e8/?i=3', 'all', 1),
(11589461, 'Аксессуары и сумки, Обувь ', 'Hot Products! Скидки до 60% на обувь, бумажники и кошельки, женские суимки!', '', 'aliexpress', '', '60%', 60, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/2y3sdtopsq30b9bc509216525dc3e8/?i=3', 'all', 1),
(11589481, 'Аксессуары и сумки, Одежда', 'Hot Products! Скидки до 60% на мужскую и женскую одежду, аксессуары и вечерние платья!', '', 'aliexpress', '', '60%', 60, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/0ao556wxz830b9bc509216525dc3e8/?i=3', 'all', 1),
(11589501, 'Аксессуары и сумки, Цветы и подарки, Часы и украшения', 'Hot Products! Скидки до 80% на украшения, часы, очки и ювелирные изделия!', '', 'aliexpress', '', '80%', 80, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/8il7k088y630b9bc509216525dc3e8/?i=3', 'all', 1),
(11589521, 'Спорт и отдых, Товары для дома, Компьютеры и электроника, Зоотовары, Инструменты и садовая техника', 'Hot Products! Скидки до 50% на товары для рукоделия, для дома, сада и дизайна, бытовую технику!', '', 'aliexpress', '', '50%', 50, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/wyaa5r2n2n30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593131, 'Товары для детей, Красота и здоровье, Обувь , Одежда, Игры', 'Hot Products! Kids Clothing, Kids Shoes, Baby products & Toys. Up to 50% OFF!', '', 'aliexpress', '', '50%', 50, '2017-12-11 16:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/njyzf4b2go30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593191, 'Спорт и отдых, Товары для дома, Цветы и подарки, Инструменты и садовая техника', 'Hot Products! Arts & Crafts, Home Decor & Textiles, Kitchen & Home Appliances. Up to 50% OFF!', '', 'aliexpress', '', '50%', 50, '2017-12-11 16:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/chh1pf96om30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593251, 'Компьютеры и электроника', 'Hot Products! Скидки до 40% электронику, смартфоны и аксессуары!', '', 'aliexpress', '', '40%', 40, '2017-12-08 15:01:00', '2017-12-31 23:59:00', 'https://alitems.com/g/a23dbin9my30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593271, 'Спорт и отдых, Товары для дома, Компьютеры и электроника, Игры', 'Hot Products! Mobile Phones & accessory, Audio & Video, Camera & Photography. Up to 40% OFF!', '', 'aliexpress', '', '40%', 40, '2017-12-11 17:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/2agwixd2qa30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593281, 'Товары для детей, Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Компьютеры и электроника, Цветы и подарки, Часы и украшения, Зоотовары, Игры, Инструменты и садовая техника', 'Hot Products! Comprehensive categories. Up to 80% OFF!', '', 'aliexpress', '', '80%', 80, '2017-12-11 17:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/jcbo733m7430b9bc509216525dc3e8/?i=3', 'all', 1),
(11593371, 'Одежда, Спорт и отдых', 'Hot Products! Women\'s & Men\'s Clothing. Up to 60% OFF!', '', 'aliexpress', '', '60%', 60, '2017-12-11 17:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/0h8lft367430b9bc509216525dc3e8/?i=3', 'all', 1),
(11593381, 'Красота и здоровье', 'Hot Products! Beauty & Hair Goods. Up to 50% OFF!', '', 'aliexpress', '', '50%', 50, '2017-12-11 18:57:00', '2017-12-31 23:59:00', 'https://alitems.com/g/137eqz263w30b9bc509216525dc3e8/?i=3', 'all', 1),
(11593401, 'Аксессуары и сумки, Цветы и подарки, Часы и украшения', 'Hot Products! Jewelry, Watches, Sunglasses & Accessories. Up to 80% OFF!', '', 'aliexpress', '', '80%', 80, '2017-12-11 18:03:00', '2017-12-31 23:59:00', 'https://alitems.com/g/ug3iew0in530b9bc509216525dc3e8/?i=3', 'all', 1),
(11593411, 'Аксессуары и сумки, Обувь ', 'Hot Products! Shoes, Bags & Wallets. Up to 60% OFF!', '', 'aliexpress', '', '60%', 60, '2017-12-11 18:03:00', '2017-12-31 23:59:00', 'https://alitems.com/g/6ulusrn0bw30b9bc509216525dc3e8/?i=3', 'all', 1),
(11603131, 'Аксессуары и сумки, Цветы и подарки, Часы и украшения', 'Hasta 80% en Accesorios De Moda! ', '', 'aliexpress', '', '80%', 80, '2017-12-15 15:18:00', '2017-12-31 23:59:00', 'https://alitems.com/g/4udoktqhvm30b9bc509216525dc3e8/?i=3', 'all', 1),
(11603151, 'Товары для детей, Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Компьютеры и электроника, Цветы и подарки, Часы и украшения, Игры, Инструменты и садовая техника', 'Hasta 80% en todas las categorias de productos', '', 'aliexpress', '', '80%', 80, '2017-12-15 15:27:00', '2017-12-31 23:59:00', 'https://alitems.com/g/abl65jrco430b9bc509216525dc3e8/?i=3', 'all', 1),
(11603321, 'Спорт и отдых, Компьютеры и электроника', 'Hasta 80% en Teléfonos Móviles y accesorios, Audio Y Video, Cámara Y Fotografía!', '', 'aliexpress', '', '40%', 40, '2017-12-15 16:18:00', '2017-12-31 23:59:00', 'https://alitems.com/g/9gqgdwt6du30b9bc509216525dc3e8/?i=3', 'all', 1),
(11603451, 'Одежда, Спорт и отдых', 'Hasta 60% en Moda Mujer Y Hombre!', '', 'aliexpress', '', '60%', 60, '2017-12-15 16:18:00', '2017-12-31 23:59:00', 'https://alitems.com/g/3vmta6xrk430b9bc509216525dc3e8/?i=3', 'all', 1),
(11605991, 'Товары для детей, Красота и здоровье, Обувь , Одежда, Спорт и отдых, Товары для дома', 'Hasta 50% en Todo para tus peques!', '', 'aliexpress', '', '50%', 50, '2017-12-18 14:49:00', '2017-12-31 23:59:00', 'https://alitems.com/g/0xwv1sm8ag30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606001, 'Товары для детей, Спорт и отдых, Инструменты и садовая техника', 'Casa y Jardín. Hasta -50%!', '', 'aliexpress', '', '50%', 50, '2017-12-18 14:59:00', '2017-12-31 23:59:00', 'https://alitems.com/g/89nmbfh0pi30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606211, 'Спорт и отдых, Товары для дома, Инструменты и садовая техника', 'Maison et Jardin: Jusqu\'à 50% de remise!', '', 'aliexpress', '', '50%', 50, '2017-12-18 16:45:00', '2017-12-31 23:59:00', 'https://alitems.com/g/a4y9m3ukph30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606221, 'Товары для детей, Красота и здоровье, Обувь , Одежда, Спорт и отдых', 'Jusqu\'à 50% de remise sur les produits pour Mères et Enfants.', '', 'aliexpress', '', '50%', 50, '2017-12-18 16:48:00', '2017-12-31 23:59:00', 'https://alitems.com/g/gk4v35k07c30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606231, 'Красота и здоровье', 'Jusqu\'à 50% de remise sur les produits pour Beauté et Capillaire.', '', 'aliexpress', '', '50%', 50, '2017-12-18 16:48:00', '2017-12-31 23:59:00', 'https://alitems.com/g/fs5he5dnao30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606241, 'Товары для дома, Компьютеры и электроника', 'Jusqu\'à 40% de remise sur l’Électronique et Téléphones.', '', 'aliexpress', '', '40%', 40, '2017-12-18 17:39:00', '2017-12-31 23:59:00', 'https://alitems.com/g/vrgfmk094u30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606261, 'Аксессуары и сумки', 'Jusqu\'à 60% de remise sur les Chaussures et Sacs.', '', 'aliexpress', '', '60%', 60, '2017-12-18 17:45:00', '2017-12-31 23:59:00', 'https://alitems.com/g/rv1c84it6h30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606281, 'Аксессуары и сумки, Цветы и подарки, Часы и украшения', 'Jusqu\'à 80% de remise sur les Accessoires.', '', 'aliexpress', '', '80%', 80, '2017-12-18 17:52:00', '2017-12-31 23:59:00', 'https://alitems.com/g/bhnn2q1jkp30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606291, 'Аксессуары и сумки, Одежда', 'Jusqu\'à 60% de remise sur la Mode homme et femme.', '', 'aliexpress', '', '60%', 60, '2017-12-18 17:52:00', '2017-12-31 23:59:00', 'https://alitems.com/g/auprixneje30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606301, 'Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Компьютеры и электроника, Цветы и подарки, Часы и украшения, Зоотовары, Игры, Инструменты и садовая техника', 'Jusqu\'à 80% de remise sur les produits phares.', '', 'aliexpress', '', '80%', 80, '2017-12-18 18:00:00', '2017-12-31 23:59:00', 'https://alitems.com/g/jv5bye0rc530b9bc509216525dc3e8/?i=3', 'all', 1),
(11606311, 'Товары для детей, Красота и здоровье, Обувь , Одежда, Спорт и отдых, Товары для дома', 'Rabaty do 50% na towary dla mam i dzieci.', '', 'aliexpress', '', '50%', 50, '2017-12-18 18:12:00', '2017-12-31 23:59:00', 'https://alitems.com/g/6p6cie4ovq30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606321, 'Спорт и отдых, Товары для дома, Инструменты и садовая техника', 'Rabaty do 50% na towary dla domu i ogrodu.', '', 'aliexpress', '', '50%', 50, '2017-12-18 18:12:00', '2017-12-31 23:59:00', 'https://alitems.com/g/r6lyf160p530b9bc509216525dc3e8/?i=3', 'all', 1),
(11606331, 'Компьютеры и электроника', 'Rabaty do 40% na telefony i elektronikę.', '', 'aliexpress', '', '40%', 40, '2017-12-18 18:12:00', '2017-12-31 23:59:00', 'https://alitems.com/g/j4nc58yxhn30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606341, 'Товары для детей, Красота и здоровье, Аксессуары и сумки, Обувь , Одежда, Спорт и отдых, Товары для дома, Компьютеры и электроника, Цветы и подарки, Часы и украшения, Зоотовары, Игры, Инструменты и садовая техника', 'Rabaty do 80% na wszystkie kategorie.', '', 'aliexpress', '', '80%', 80, '2017-12-18 18:12:00', '2017-12-31 23:59:00', 'https://alitems.com/g/nyidrfcii830b9bc509216525dc3e8/?i=3', 'all', 1),
(11606351, 'Одежда, Спорт и отдых', 'Rabaty do 60% na kobiecą i męską odzież', '', 'aliexpress', '', '60%', 60, '2017-12-18 18:20:00', '2017-12-31 23:59:00', 'https://alitems.com/g/0oey5zgcfo30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606361, 'Красота и здоровье', 'Rabaty do 50% na towary dla urody i włosów!', '', 'aliexpress', '', '50%', 50, '2017-12-18 18:22:00', '2017-12-31 23:59:00', 'https://alitems.com/g/yjbw7nshtu30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606371, 'Аксессуары и сумки, Цветы и подарки, Часы и украшения', 'Rabaty do 80% na akcesoria!', '', 'aliexpress', '', '80%', 80, '2017-12-18 18:22:00', '2017-12-31 23:59:00', 'https://alitems.com/g/twz1t6sqnd30b9bc509216525dc3e8/?i=3', 'all', 1),
(11606381, 'Аксессуары и сумки, Обувь ', 'Rabaty do 60% na torebki i buty!', '', 'aliexpress', '', '60%', 60, '2017-12-18 18:22:00', '2017-12-31 23:59:00', 'https://alitems.com/g/88hed431p830b9bc509216525dc3e8/?i=3', 'all', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--

CREATE TABLE `shops` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `region` varchar(21) NOT NULL,
  `cashback` varchar(255) NOT NULL,
  `csv_discounts` varchar(255) NOT NULL,
  `cashback_details` text NOT NULL,
  `available` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `shops`
--

INSERT INTO `shops` (`id`, `category`, `name`, `alias`, `url`, `region`, `cashback`, `csv_discounts`, `cashback_details`, `available`) VALUES
(1, 'Одежда & Обувь, Цифровая & Бытовая техника, Мебель & Товары для дома, Красота & Здоровье, Товары для детей, Аксессуары, Автотовары, Товары из Китая', 'AliExpress', 'aliexpress', 'https://alitems.com/g/1e8d11449430b9bc509216525dc3e8/', 'all', 'до 4,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=6115&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<ul>\r\n	<li>Мобильные телефоны (Телефоны и Телекоммуникация): <b>2%</b></li>\r\n	<li>Остальные товары из категории Телекоммуникации: <b>4,5%</b></li>\r\n	<li>Другие категории: <b>4,5%</b></li>\r\n	<li>Неаффилиатные товары: <b>1,5%</b></li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 38 дней</p>', 1),
(2, 'Одежда & Обувь, Цифровая & Бытовая техника, Мебель & Товары для дома, Красота & Здоровье, Товары для детей, Аксессуары, Автотовары, Товары из Китая', 'Tmall AliExpress', 'tmall', 'https://alitems.com/g/1e8d11449430b9bc509216525dc3e8/?ulp=https%3A%2F%2Ftmall.aliexpress.com%2F', 'ru', 'до 1,8%', '', '<ul>\r\n	<li>Телевизоры: <b>1.4%</b></li>\r\n	<li>Смартфоны (Apple): <b>0.9%</b></li>\r\n	<li>Смартфоны: <b>1.8%</b></li>\r\n	<li>Планшеты: <b>1.5%</b></li>\r\n	<li>Компьютеры: <b>1.5%</b></li>\r\n	<li>Другие товары из категории бытовая техника: <b>1.5%</b></li>\r\n	<li>Другие категории: <b>1.5%</b></li>\r\n	<li>Бытовая техника: <b>1.5%</b></li>\r\n	<li>Аудио- и видеотехника: <b>1.2%</b></li>\r\n</ul>\r\n<p class=\"c-red\">Учитываются заказы только при прямом заходе в раздел Tmall, и если вы ушли на главную страницу AliExpress, то будут фиксироваться только заказы AliExpress. Если вы изначально перешли на главную страницу AliExpress или на товары AliExpress, то заказы из категории Tmall учитываться не будут.</p>\r\n<p>Заказы оформленные из раздела Tmall отображаются в системе через 2 дня.</p>', 1),
(3, 'Одежда & Обувь, Аксессуары, Товары из Китая', 'Gamiss', 'gamiss', 'https://ad.admitad.com/g/h1llq5r6q530b9bc5092594123b6a9/', 'all', '23,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=16641&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 23 дня</p>', 1),
(4, ' Одежда & Обувь, Товары для детей, Аксессуары, Спорт', 'KupiVip.ru', 'kupivipru', 'https://pafutos.com/g/2559705e2430b9bc50924b9351d46e/', 'ru', 'до 5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=153&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>5% - за оплаченный заказ</li>\r\n	<li>3,5% - за оплаченный заказ с использованием промо-кода <span class=\"c-red\">(при использовании промокода из других источников, кэшбэк не начислится)</span></li>\r\n	<li>2,3% - программы лояльности</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 43 дня</p>', 1),
(5, 'Цифровая & Бытовая техника, Мебель & Товары для дома, Автотовары, Музыка & Звук, Инструменты & Садовая техника', 'ПлеерРУ', 'pleer', 'https://ad.admitad.com/g/9c4ca2202b30b9bc509292c5d6d73b/', 'ru', 'до 31.5%', '', '<p class=\"c-red\">Кэшбэк НЕ НАЧИСЛЯЕТСЯ на товары указанные в <a href=\"https://docs.google.com/spreadsheets/d/1CsaKBmJMYCLrymVK1rvlD-HBk-VqzB21i2FWRVWBn8c/edit?ts=5a1d7780#gid=152004616\" target=\"_blank\">этом документе</a></p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 6 дней</p>', 1),
(6, 'Цифровая & Бытовая техника, Товары из Китая, Музыка & Звук', 'Geekbuying', 'geekbuying', 'https://ad.admitad.com/g/78tuvzaw8k30b9bc50920267b86f6e/', 'all', 'до 6,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15467&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<ul>\r\n	<li>Consumer Electronics, Computer & Networking, Security Systems, Car Accessories, Home & Garden - 3,5%</li>\r\n	<li>Apple & Samsung Accessories, Sports & Outdoors - 4,5%</li>\r\n	<li>Watches & Jewelry - 6,5%</li>\r\n	<li>Other categories - 2,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 55 дней</p>', 1),
(7, 'Одежда & Обувь, Аксессуары, Товары из Китая', 'Rosegal', 'rosegal', 'https://ad.admitad.com/g/d2jtns1h0x30b9bc5092e683584499/', 'all', '7,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15415&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 26 дней</p>', 1),
(8, 'Одежда & Обувь, Мебель & Товары для дома, Аксессуары', 'La Redoute', 'laredoute', 'https://ad.admitad.com/g/e5be4e10ef30b9bc5092cb6358ff62/', 'ru', 'до 21,57%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=7958&code=4091f1232c&user=lufter&format=csv&v=4', '<ul> 	<li>Старый клиент - 6,19%</li> 	<li>Оплаченный заказ при использовании несанкционированного купона - 1,03%</li> 	<li>Новый клиент - 21,57%</li> </ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 54 дня</p>', 1),
(9, 'Красота & Здоровье, Подарки', 'LANCOME', 'lancome', 'https://ad.admitad.com/g/aab245250b30b9bc50920559723564/', 'ru', '8,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=7651&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 25 дней</p>', 1),
(10, 'Товары для детей, Книги, Товары для творчества', 'Читай-город', 'chitaigorod', 'https://ad.admitad.com/g/q6gfnfvsq030b9bc5092a804937a48/', 'ru', 'до 7,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15460&code=4091f1232c&user=lufter&format=csv&v=4', '<ul> 	<li>Оплаченный заказ - 7,5%</li> 	<li>Оплаченный заказ с использованием промо-кода - 3,5%</li> </ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 36 дней</p>', 1),
(11, 'Мебель & Товары для дома', 'GROHE', 'grohe', 'https://ad.admitad.com/g/mo0s1ybcuq30b9bc509245cb66c5e6/', 'ru', '5,02%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=14110&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 28 дней</p>', 1),
(12, 'Цифровая & Бытовая техника, Мебель & Товары для дома, Спорт, Товары из Китая, Инструменты & Садовая техника', 'Banggood', 'banggood', 'https://ad.admitad.com/g/e8f129b05e30b9bc50926213826a88/', 'all', '4,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=13623&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 30 дней</p>', 1),
(13, 'Цифровая & Бытовая техника, Товары для детей, Музыка & Звук', 'CINEMOOD', 'cinemood', 'https://ad.admitad.com/g/ndofynhz0o30b9bc5092695df1ded9/', 'ru', '8,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=18088&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 11 дней</p>', 1),
(14, 'Одежда & Обувь, Товары для детей, Аксессуары', 'Finn Flare', 'finnflare', 'https://ad.admitad.com/g/8ab65fb2f030b9bc5092e50977eb13/', 'ru', '6,32%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=9668&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 29 дней</p>', 1),
(15, 'Цифровая & Бытовая техника', 'Вольт Маркет', 'voltmarket', 'https://ad.admitad.com/g/v4sdyl1w5830b9bc50924bd2109cf3/', 'ru', 'до 13,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=14339&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Однофазные стабилизаторы напряжения Энергия Classic - 13,5%</li>\r\n	<li>Однофазные стабилизаторы напряжения Энергия Ultra - 13,5%</li>\r\n	<li>Трехфазные стабилизаторы напряжения Энергия Hybrid - 13,5%</li>\r\n	<li>Трехфазные стабилизаторы напряжения Энергия Voltron 3D - 13,5%</li>\r\n	<li>Сварочные аппараты Энергия - 13,5%</li>\r\n	<li>Вся остальная техника Энергия - 8,5%</li>\r\n	<li>Товары других брэндов - 0,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 11 дней</p>', 1),
(16, 'Доставка еды и продукты', 'Интернет-магазин Алёнка', 'alenka', 'https://ad.admitad.com/g/hzssb78yxy30b9bc509245305aaa81/', 'ru', '4,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=17345&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Оплаченный заказ за нового пользователя - 4,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 11 дней</p>', 1),
(17, 'Цифровая & Бытовая техника', 'Huawei', 'huawei', 'https://ad.admitad.com/g/sulzzo59sa30b9bc50929c697b6d2a/', 'ru', '1,69%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=16080&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 53 дня</p>', 1),
(18, 'Одежда & Обувь, Мебель & Товары для дома, Аксессуары', 'Quelle', 'quelle', 'https://ad.admitad.com/g/84582bebef30b9bc50924a2f625b4f/', 'ru', '1%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=515&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 54 дня</p>', 1),
(19, 'Цифровая & Бытовая техника, Товары для детей, Аксессуары, Софт & Игры, Музыка & Звук', 'Store77', 'store77', 'https://ad.admitad.com/g/sjrityqtnp30b9bc5092be0600316f/', 'ru', 'до 9,35%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=14086&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Электротранспорт - 2,12%</li>\r\n	<li>Умные часы - 1,9%</li>\r\n	<li>Телефоны, планшеты - 1,3%</li>\r\n	<li>Остальные категории - 1%</li>\r\n	<li>Ноутбуки, Телевизоры - 2%</li>\r\n	<li>Аксессуары - 9,35%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 54 дня</p>', 1),
(20, 'Красота & Здоровье', 'KRASOTKAPRO', 'krasotkapro', 'https://ad.admitad.com/g/7uzna7dccl30b9bc5092eaaf7e7f1d/', 'ru', '8,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15895&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 37 дней</p>', 1),
(21, 'Цифровая & Бытовая техника', 'Нотик', 'notik', 'https://ad.admitad.com/g/c68ad94ef530b9bc509281a31afc55/', 'ru', 'до 8,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=2868&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Телевизоры - 0,5%</li>\r\n	<li>Ноутбуки, Моноблоки, Планшеты, МФУ - 1,5%</li>\r\n	<li>Смартфоны - 1,5%</li>\r\n	<li>Гаджеты - 2%</li>\r\n	<li>Софт - 3,5%</li>\r\n	<li>Сумки - 7,5%</li>\r\n	<li>Аксессуары - 8,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 28 дней</p>', 1),
(22, 'Цифровая & Бытовая техника, Автотовары', 'КАРКАМ', 'karkam', 'https://ad.admitad.com/g/jztq3fgl6230b9bc5092ee6fec0cac/', 'all', '8,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15173&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Российский рубль</p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 28 дней</p>', 1),
(23, 'Одежда & Обувь, Аксессуары, Спорт', 'Roxy', 'roxy', 'https://ad.admitad.com/g/b5e36b3fd730b9bc50923ba973aefe/', 'ru', '10,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=6288&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 39 дней</p>', 1),
(24, 'Цифровая & Бытовая техника, Красота & Здоровье, Товары для детей, Автотовары, Гипермаркеты', 'КЕЙ', 'kei', 'https://ad.admitad.com/g/bzpi4i8ecc30b9bc5092c5093dea8f/', 'ru', 'до 4%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15574&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 19 дней</p>', 1),
(25, 'Товары для детей, Книги, Товары для творчества', 'Book24', 'book24', 'https://ad.admitad.com/g/szq4wwgsqh30b9bc50920334bf6817/', 'ru', 'до 15%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15870&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Оплаченный заказ старого клиента (до 10 000 рублей) - 6%</li>\r\n	<li>Оплаченный заказ нового клиента (до 10 000 рублей) - 15%</li>\r\n	<li>Оплаченный заказ (от 10 001 рублей) - 750р.</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 34 дня</p>', 1),
(26, 'Одежда & Обувь, Цифровая & Бытовая техника, Мебель & Товары для дома, Товары для детей, Аксессуары, Спорт, Автотовары, Товары из Китая, Инструменты & Садовая техника', 'Tomtop', 'tomtop', 'https://ad.admitad.com/g/xljorca89630b9bc50924bf89f6ddb/', 'all', '7,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=14350&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"c-red\">Валюта кэшбэка - Американский доллар</p>\r\n<p class=\"appr-time\">Среднее время подтверждения - 49 дней</p>', 1),
(27, 'Одежда & Обувь, Аксессуары, Товары из Китая', 'Dresslily', 'dresslily', 'https://ad.admitad.com/g/dru1fiprm430b9bc5092c54bdbf551/', 'all', '7,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15504&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 19 дней</p>', 1),
(28, 'Одежда & Обувь, Аксессуары, Спорт', 'КАНТ', 'kant', 'https://ad.admitad.com/g/0sqtzemoyx30b9bc5092135d19ca85/', 'ru', 'до 5,02%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=14806&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Товары, которые входят в список исключений: велосипеды Altair, Bergamont, Black One, Bulls, Challenger, CUBE, Dahon, Fisher, Format, Forward, Giant, Kellys, Olimp, ORBEA, Scool, Scott, Silverback, Stark, Stels; <br>\r\n	Cнаряжение Petzl, Stanley, Leatherman, Led Lenser, Pieps; веревки, репшнуры - 1,76%</li>\r\n	<li>Тариф за товары из категорий: Велосипеды - 3,71%</li>\r\n	<li>Тариф за товары из других категорий - 5,02%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 25 дней</p>', 1),
(29, 'Цифровая & Бытовая техника', 'Nikonstore', 'nikonstore', 'https://ad.admitad.com/g/wgui3grwsy30b9bc50921591d7082c/', 'ru', '5,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=15837&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 30 дней</p>', 1),
(30, 'Аксессуары', 'Адамас', 'adamas', 'https://ad.admitad.com/g/830685a7a830b9bc509275f1c04f0a/', 'ru', 'до 9,5%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=12907&code=4091f1232c&user=lufter&format=csv&v=4', '<ul>\r\n	<li>Оплаченный заказ ювелирного изделия с бриллиантом, в артикулах 41,4хх в конце - 9,5%</li>\r\n	<li>Оплаченный заказ ювелирного украшения (остальной ассортимент) - 7,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 19 дней</p>', 1),
(31, 'Красота & Здоровье, Товары для творчества', 'NYX Professional Makeup', 'nyx', 'https://ad.admitad.com/g/98obgo3gtn30b9bc50925b75425f0e/', 'ru', '8,5%', '', '<p class=\"appr-time\">Среднее время подтверждения - 32 дня</p>', 1),
(32, 'Красота & Здоровье', 'KIKO MILANO', 'kiko', 'https://ad.admitad.com/g/eeh8b5g5ga30b9bc509272ea885266/', 'ru', '8,5%', '', '<p class=\"appr-time\">Среднее время подтверждения - 26 дней</p>', 1),
(33, 'Одежда & Обувь, Красота & Здоровье', 'Mario Berluchi', 'marioberluchi', 'https://ad.admitad.com/g/3ywfwobzu930b9bc5092173362a5a2/', 'ru', '9,59%', 'http://export.admitad.com/ru/webmaster/websites/506206/coupons/export/?website=506206&advcampaigns=17799&code=4091f1232c&user=lufter&format=csv&v=4', '<p class=\"appr-time\">Среднее время подтверждения - 23 дня</p>', 1),
(34, 'Красота & Здоровье', 'Myslitsky-Nail', 'myslitsky', 'https://ad.admitad.com/g/n84lxqg9pw30b9bc50929b53f9e671/', 'ru', '8,5%', '', '<p class=\"appr-time\">Среднее время подтверждения - 22 дня</p>', 1),
(35, 'Красота & Здоровье', 'LA ROCHE-POSAY', 'larosheposay', 'https://ad.admitad.com/g/18ee485e9330b9bc5092e490185392/', 'ru', 'до 10,5%', '', '<ul>\r\n	<li>Оплаченный заказ без использования промокода - 10,5%</li>\r\n	<li>Оплаченный заказ с применением промокода - 5,5%</li>\r\n</ul>\r\n<p class=\"appr-time\">Среднее время подтверждения - 37 дней</p>', 1),
(36, 'Цифровая & Бытовая техника, Мебель & Товары для дома, Красота & Здоровье', 'Shveiburg', 'shveiburg', 'https://ad.admitad.com/g/qzp53o7l9430b9bc50925a19b0c0b2/', 'ru', '2,12%', '', '<p class=\"appr-time\">Среднее время подтверждения - 26 дней</p>', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `identity` varchar(255) NOT NULL,
  `network` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `country` varchar(21) NOT NULL,
  `password` varchar(255) NOT NULL,
  `seed` varchar(255) NOT NULL,
  `registration_date` date NOT NULL,
  `activity` varchar(255) NOT NULL,
  `sum_open_usd` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sum_approved_usd` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sum_open_rub` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sum_approved_rub` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sum_open_uah` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `sum_approved_uah` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `last_upd_stat_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `payment_usd` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `payment_rub` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `payment_uah` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `paid_usd` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `paid_rub` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `paid_uah` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `access_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `identity`, `network`, `name`, `email`, `country`, `password`, `seed`, `registration_date`, `activity`, `sum_open_usd`, `sum_approved_usd`, `sum_open_rub`, `sum_approved_rub`, `sum_open_uah`, `sum_approved_uah`, `last_upd_stat_time`, `payment_usd`, `payment_rub`, `payment_uah`, `paid_usd`, `paid_rub`, `paid_uah`, `access_key`) VALUES
(30, '5d5408335aa7793596895916c23aa5e5', 'facebook', 'Vitaliy Lufter', 'lufter21@gmail.com', 'ua', '3b12b3a6d9858089b7686579f2cb1b20', 'ea665dddde3ee856a0352d2c9997069d4cdc71a2', '2017-10-01', '[\"2017-08-30\",\"2017-09-04\",\"2017-09-06\",\"2017-09-18\",\"2017-10-01\",\"2017-10-02\",\"2017-10-08\",\"2017-10-09\",\"2017-11-23\",\"2017-12-17\",\"2017-12-18\",\"2017-12-19\",\"2017-12-24\",\"2017-12-26\",\"2017-12-29\",\"2017-12-30\",\"2017-12-31\"]', '2.40', '1.26', '22.20', '12.11', '0.00', '0.00', 1514895099, '0.03', '3.35', '0.00', '1.20', '0.00', '0.00', '5d5408335aa7793596895916c23aa5e5952d93177ce48a4319417bc341d37eda608b6641'),
(34, '26ac92ef135c17379544265ab197199d', '', 'lufter', 'lufter22@gmail.com', 'ua', 'a6652429c596b2215d5b27cf08a0c7a0', '9313b10be40215f50a8394173d423bd1017729b0', '2017-10-01', '[\"2017-10-01\"]', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1506849818, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '26ac92ef135c17379544265ab197199d448331d5ce18f200368095a73e71558704b3b835'),
(35, 'ff54673e8a8ad85a5101059760f479c0', 'twitter', 'Vitaliy Lufter', 'lufter@gmail.com', 'ru', 'd39d3ca386e28c1660cd58740eba2dd3', 'db80c47317a5c9b41559ea0055f16afc26847e7c', '2017-10-02', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1506935955, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'ff54673e8a8ad85a5101059760f479c014a9fc199a57e12a7e0302e694b56fb4380ff42c');

-- --------------------------------------------------------

--
-- Структура таблицы `users_stat`
--

CREATE TABLE `users_stat` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_stat`
--

INSERT INTO `users_stat` (`id`, `userid`, `date`, `data`) VALUES
(3020170830, 30, '2017-08-30', '[{\"shop_name\":\"Magazin\",\"cashback\":\"5.32\\u0440\\u0443\\u0431\",\"status\":\"pending\",\"currensy\":\"rub\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1v6VIOXXXXXaUaFXXq6xXFXXXZ\\/Original-Power-Bank-10000mAh-Portable-External-Battery-Portable-Charger-with-LED-Indicator-for-iphone-5-6s.jpg\",\"product_name\":\"Original Power Bank 10000mAh Portable External Battery Portable Charger with LED Indicator for iphone 5 6s plus Xiaomi Cellphone\",\"price\":\"145.49\\u0440\\u0443\\u0431\"},{\"shop_name\":\"Magazin\",\"cashback\":\"1.77\\u0440\\u0443\\u0431\",\"status\":\"pending\",\"currensy\":\"rub\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1v6VIOXXXXXaUaFXXq6xXFXXXZ\\/Original-Power-Bank-10000mAh-Portable-External-Battery-Portable-Charger-with-LED-Indicator-for-iphone-5-6s.jpg\",\"product_name\":\"Original Power Bank 10000mAh Portable External Battery Portable Charger with LED Indicator for iphone 5 6s plus Xiaomi Cellphone\",\"price\":\"145.49\\u0440\\u0443\\u0431\"},{\"shop_name\":\"Magazin\",\"cashback\":\"$1.57\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1By4wNFXXXXb0XpXXq6xXFXXXP\\/SUOYANG-Power-Bank-20000mAh-10000mAh-Mi-External-Battery-Bank-Portable-Charger-Powerbank-18650-For-iPhone-Xiaomi.jpg\",\"product_name\":\"SUOYANG Power Bank 20000mAh 10000mAh Mi External Battery Bank Portable Charger Powerbank 18650 For iPhone Xiaomi Android Phones\",\"price\":\"$28.05\"},{\"shop_name\":\"Magazin\",\"cashback\":\"12.11\\u0440\\u0443\\u0431\",\"status\":\"approved\",\"currensy\":\"rub\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1By4wNFXXXXb0XpXXq6xXFXXXP\\/SUOYANG-Power-Bank-20000mAh-10000mAh-Mi-External-Battery-Bank-Portable-Charger-Powerbank-18650-For-iPhone-Xiaomi.jpg\",\"product_name\":\"SUOYANG Power Bank 20000mAh 10000mAh Mi External Battery Bank Portable Charger Powerbank 18650 For iPhone Xiaomi Android Phones\",\"price\":\"218.05\\u0440\\u0443\\u0431\"}]'),
(3020170904, 30, '2017-09-04', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.72\",\"status\":\"declined\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1By4wNFXXXXb0XpXXq6xXFXXXP\\/SUOYANG-Power-Bank-20000mAh-10000mAh-Mi-External-Battery-Bank-Portable-Charger-Powerbank-18650-For-iPhone-Xiaomi.jpg\",\"product_name\":\"SUOYANG Power Bank 20000mAh 10000mAh Mi External Battery Bank Portable Charger Powerbank 18650 For iPhone Xiaomi Android Phones\",\"price\":\"$18.05\"},{\"shop_name\":\"Magazin\",\"cashback\":\"15.11\\u0440\\u0443\\u0431\",\"status\":\"pending\",\"currensy\":\"rub\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1By4wNFXXXXb0XpXXq6xXFXXXP\\/SUOYANG-Power-Bank-20000mAh-10000mAh-Mi-External-Battery-Bank-Portable-Charger-Powerbank-18650-For-iPhone-Xiaomi.jpg\",\"product_name\":\"SUOYANG Power Bank 20000mAh 10000mAh Mi External Battery Bank Portable Charger Powerbank 18650 For iPhone Xiaomi Android Phones\",\"price\":\"18.05\\u0440\\u0443\\u0431\"}]'),
(3020170906, 30, '2017-09-06', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.57\",\"status\":\"declined\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1v6VIOXXXXXaUaFXXq6xXFXXXZ\\/Original-Power-Bank-10000mAh-Portable-External-Battery-Portable-Charger-with-LED-Indicator-for-iphone-5-6s.jpg\",\"product_name\":\"Original Power Bank 10000mAh Portable External Battery Portable Charger with LED Indicator for iphone 5 6s plus Xiaomi Cellphone\",\"price\":\"$14.49\"}]'),
(3020170918, 30, '2017-09-18', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.71\",\"status\":\"approved\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1qMi.OFXXXXcTaXXXq6xXFXXX3\\/ROMOSS-Sense4-Plus-with-LCD-Battery-Indicator-Power-Bank-10400mAh-Portable-Charger-Battery-18650-Dual-USB.jpg\",\"product_name\":\"ROMOSS Sense4 Plus with LCD Battery Indicator Power Bank 10400mAh Portable Charger Battery 18650 Dual USB Output\",\"price\":\"$17.99\"}]'),
(3020171123, 30, '2017-11-23', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.55\",\"status\":\"approved\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1_9oIcBcHL1JjSZFBq6yiGXXa0\\/7-Frequency-Silicone-Prostate-Massager-Sex-Toys-For-Men-Rechargeable-Anal-Vibrator-Vibrating-butt-plug-Erotic.jpg\",\"product_name\":\"7 Frequency Silicone Prostate Massager Sex Toys For Men Rechargeable Anal Vibrator Vibrating butt plug Erotic Anal Toys\",\"price\":\"$12.49\"}]'),
(3020171218, 30, '2017-12-18', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.39\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1LgKYSXXXXXagXFXXq6xXFXXXH\\/For-THL-T7-LCD-Display-Touch-Screen-Assembly-Replacement-for-thl-t-7-lcd-touch-screen.jpg\",\"product_name\":\"For THL T7 LCD Display + Touch Screen Assembly Replacement for thl t 7 lcd touch screen digitizer + tools gift\",\"price\":\"$26\"}]'),
(3020171219, 30, '2017-12-19', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.02\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1NdYURpXXXXcgXpXXq6xXFXXXy\\/Classic-Stand-Up-Food-Meat-Dial-Oven-Thermometer-Temperature-Gauge-Gage-New.jpg\",\"product_name\":\"Classic Stand Up Food Meat Dial Oven Thermometer Temperature Gauge Gage New\",\"price\":\"$1.73\"},{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.07\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB18OuPKVXXXXcpXVXXq6xXFXXXl\\/THL-T7-Tempered-Glass-Film-Explosion-Proof-Screen-Protector-For-5-5-inches-THL-T7.jpg\",\"product_name\":\"THL T7 Tempered Glass Film Explosion Proof  Screen Protector For 5.5 inches THL T7\",\"price\":\"$1.8\"}]'),
(3020171224, 30, '2017-12-24', '[{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.07\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB1Ad8eSXXXXXboXpXXq6xXFXXXK\\/Tempered-Glass-For-Samsung-Galaxy-A3-A5-A7-2016-1-J3-J5-J7-Premium-Screen-Protector.jpg\",\"product_name\":\"Tempered Glass For Samsung Galaxy A3 A5 A7 2016 1 J3 J5 J7 Premium Screen Protector For Samsung S3 S4 S5 S6 Tough Film\",\"price\":\"$1.51\"},{\"shop_name\":\"Aliexpress INT\",\"cashback\":\"$0.28\",\"status\":\"pending\",\"currensy\":\"usd\",\"product_image\":\"https:\\/\\/ae01.alicdn.com\\/kf\\/HTB14nDyNXXXXXbDXVXXq6xXFXXXU\\/ORICO-2139U3-2-5-inch-Transparent-USB3-0-to-Sata-3-0-HDD-Case-Tool-Free.jpg\",\"product_name\":\"ORICO  2139U3 2.5 inch Transparent USB3.0 to Sata 3.0 HDD Case Tool Free 5 Gbps Support 2TB UASP Protocol Hard Drive Enclosure\",\"price\":\"$6.39\"}]');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region` (`region`),
  ADD KEY `category` (`category`),
  ADD KEY `date_start` (`date_start`),
  ADD KEY `date_end` (`date_end`),
  ADD KEY `available` (`available`);

--
-- Индексы таблицы `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `available` (`available`),
  ADD KEY `region` (`region`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_stat`
--
ALTER TABLE `users_stat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
