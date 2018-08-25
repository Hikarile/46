-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-07-11 16:22:13
-- 伺服器版本: 10.1.10-MariaDB
-- PHP 版本： 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `md_d`
--

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `id` smallint(6) NOT NULL,
  `n` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` smallint(6) NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `count` tinyint(4) NOT NULL,
  `money` smallint(6) NOT NULL,
  `cancel` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `orders`
--

INSERT INTO `orders` (`id`, `n`, `phone`, `code`, `date`, `start_time`, `order_date`, `order_time`, `from`, `to`, `count`, `money`, `cancel`, `created_at`, `updated_at`) VALUES
(31, 'HQug2cCb0F', '0912345678', 1551, '2016-07-07', '19:00', '2016-07-07', '16:28', '0', '2', 2, 200, '1', '2016-07-11 08:33:45', '2016-07-11 08:33:45'),
(32, 'cyo1Ad3PDM', '0912345678', 1551, '2016-07-07', '19:00', '2016-07-08', '16:29', '0', '2', 2, 200, '1', '2016-07-09 01:37:23', '2016-07-09 01:37:23'),
(33, 'HCTZoV4Ag1', '0912345678', 1551, '2016-07-08', '19:00', '2016-07-09', '00:51', '0', '2', 2, 200, '0', '2016-07-09 08:23:07', '2016-07-09 08:22:41'),
(34, 'JXpithcPGL', '0912345678', 1551, '2016-07-08', '19:00', '2016-07-09', '00:51', '0', '2', 32, 200, '0', '2016-07-08 16:51:33', '2016-07-08 16:51:33'),
(35, '0GOTXLEvBR', '0912345678', 1551, '2016-07-11', '13:20', '2016-07-11', '13:14', '0', '1', 1, 100, '1', '2016-07-10 12:05:51', '2016-07-10 12:05:51'),
(36, 'sD4bSwzkln', '0912345687', 1551, '2016-07-11', '19:00', '2016-07-11', '13:41', '0', '7', 96, 700, '0', '2016-07-11 05:41:53', '2016-07-11 05:41:53'),
(37, 'nOpk8Yu6qP', '0912345675', 1551, '2016-07-11', '19:50', '2016-07-11', '13:42', '1', '3', 3, 200, '0', '2016-07-11 05:42:48', '2016-07-11 05:42:48'),
(38, 'PS7OsK3Qry', '0912345675', 1551, '2016-07-11', '20:20', '2016-07-11', '13:43', '2', '4', 1, 200, '0', '2016-07-11 05:43:06', '2016-07-11 05:43:06'),
(39, 'rtBFZse2N8', '0912345675', 1551, '2016-07-11', '20:20', '2016-07-11', '13:43', '2', '3', 1, 100, '0', '2016-07-11 05:43:26', '2016-07-11 05:43:26'),
(40, 'VjsGeLzAX5', '0912345675', 1551, '2016-07-11', '20:20', '2016-07-11', '13:43', '2', '3', 3, 100, '0', '2016-07-11 05:43:41', '2016-07-11 05:43:41'),
(41, 'gy0E9cY8HU', '1234567890', 6024, '2016-07-11', '09:00', '2016-07-11', '01:37', '0', '2', 3, 200, '0', '2016-07-10 17:37:53', '2016-07-10 17:37:53'),
(42, 'INaqcF05WS', '0912345678', 1551, '2016-07-11', '19:00', '2016-07-11', '13:52', '0', '1', 1, 100, '0', '2016-07-11 05:52:23', '2016-07-11 05:52:23'),
(43, '7jbEdUND02', '0912345678', 1551, '2016-07-11', '19:00', '2016-07-11', '15:33', '0', '1', 1, 100, '0', '2016-07-11 07:33:44', '2016-07-11 07:33:44');

-- --------------------------------------------------------

--
-- 資料表結構 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `trains`
--

CREATE TABLE `trains` (
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `week` set('0','1','2','3','4','5','6') COLLATE utf8_unicode_ci NOT NULL,
  `per_car` smallint(6) NOT NULL,
  `car_count` smallint(6) NOT NULL,
  `station` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `trains`
--

INSERT INTO `trains` (`code`, `type`, `week`, `per_car`, `car_count`, `station`, `start_time`, `created_at`, `updated_at`) VALUES
('1551', '1', '1,2,3,4,5', 60, 8, '0,1,2,3,4,5,6,7,8,9', '1140,1190,1220,1250,1290,1310,1340,1370,1400,1438', '2016-07-11 05:33:44', '0000-00-00 00:00:00'),
('1611', '1', '0,2,3,6', 50, 8, '2,0,13', '1020,1110,1160', '2016-07-01 18:56:04', '0000-00-00 00:00:00'),
('6024', '2', '1,2,3,4,5', 60, 10, '0,1,2,3,4', '540,570,590', '2016-07-01 18:56:04', '0000-00-00 00:00:00'),
('6164', '2', '1,2,3,4,5', 40, 10, '4,5,6,7,8,9,10', '690,730,760,780,800,830,860', '2016-07-02 11:03:26', '0000-00-00 00:00:00'),
('8410', '3', '0,5', 52, 5, '10,12,13,0', '1080,1150,1180,1200', '2016-07-02 11:08:30', '0000-00-00 00:00:00'),
('8513', '3', '0,1,5,6', 52, 5, '0,4,9,12', '480,510,540,600', '2016-07-01 18:56:04', '0000-00-00 00:00:00'),
('8763', '3', '0,1,5,6', 52, 5, '0,13,12,11,9', '360,380,400,420,470', '2016-07-05 09:02:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `types`
--

CREATE TABLE `types` (
  `id` smallint(6) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `speed` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `types`
--

INSERT INTO `types` (`id`, `name`, `speed`, `created_at`, `updated_at`) VALUES
(1, '區間列車', '50', '2016-07-04 06:11:57', '0000-00-00 00:00:00'),
(2, '快速列車', '300', '2016-07-03 14:54:44', '0000-00-00 00:00:00'),
(3, '磁浮列車', '500', '2016-07-03 14:54:44', '0000-00-00 00:00:00'),
(6, '神風號', '4000', '2016-07-10 09:04:19', '2016-07-10 09:04:19'),
(7, '神風號-極', '60000', '2016-07-10 09:05:25', '2016-07-10 09:05:25');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'wu ', 'admin', '$2y$10$LQL6q7o2F5OavraA0kqo9Ob7VgoNrZEdQi0Ojh0rhoDeCwM5KXcJG', 'KBQtv21ODJBDtf5OZMHpHcXULPpY2l6dGSTnM0PlXNeIKlxH6T8PrfcX6WYu', '2016-06-24 08:20:05', '2016-07-11 04:55:17');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- 資料表索引 `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `code_2` (`code`),
  ADD KEY `code` (`code`),
  ADD KEY `code_3` (`code`);

--
-- 資料表索引 `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- 使用資料表 AUTO_INCREMENT `types`
--
ALTER TABLE `types`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
