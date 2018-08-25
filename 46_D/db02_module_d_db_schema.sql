-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-08-01 09:45:12
-- 伺服器版本: 10.1.10-MariaDB
-- PHP 版本： 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db02_module_d_db_schema`
--

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `unique` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `order_time` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `cancel` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `orders`
--

INSERT INTO `orders` (`id`, `unique`, `code`, `phone`, `order_date`, `order_time`, `start_date`, `start_time`, `from`, `to`, `count`, `money`, `cancel`, `created_at`, `updated_at`) VALUES
(1, 'KImM4qkSvP', '12359', '0912345678', '2016-07-29', '13:25', '2016-08-11', '01:12', '台北', '桃園', 1, 100, '', '2016-07-29 05:25:39', '2016-07-29 05:25:39'),
(2, '265ZKbO0Yr', '12359', '0912345678', '2016-07-29', '13:27', '2016-08-11', '01:12', '台北', '桃園', 1, 100, '1', '2016-08-01 03:35:30', '2016-07-31 19:35:30'),
(3, '526L2DmQIc', '12359', '0912345678', '2016-07-29', '13:27', '2016-08-11', '01:12', '台北', '桃園', 1, 100, '1', '2016-08-01 03:36:29', '2016-07-31 19:36:29'),
(4, 'VPCDe00qLo', '12359', '0912345678', '2016-07-29', '13:27', '2016-08-11', '01:12', '台北', '桃園', 1, 100, '1', '2016-08-01 03:38:27', '2016-08-01 03:38:27'),
(5, '14uN6L5s9j', '12359', '0912345678', '2016-07-29', '13:28', '2016-08-11', '01:12', '台北', '桃園', 1, 100, '', '2016-07-29 05:28:17', '2016-07-29 05:28:17'),
(6, '56B4u0dC60', '12359', '09789456123', '2016-07-29', '13:42', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:42:50'),
(7, 'w9K7f9Z5U7', '12359', '09789456123', '2016-07-29', '13:43', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:43:03'),
(8, '9XdoK0s0gw', '12359', '09789456123', '2016-07-29', '13:47', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:47:40'),
(9, '1266ZE890h', '12359', '09789456123', '2016-07-29', '13:47', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '1', '2016-08-01 07:16:36', '2016-08-01 07:16:36'),
(10, 'ck36s92F23', '12359', '09789456123', '2016-07-29', '13:48', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:48:07'),
(11, '13byrvz69l', '12359', '09789456123', '2016-07-29', '13:48', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:48:28'),
(12, 'L1g23Xjh5Z', '12359', '09789456123', '2016-07-29', '13:49', '2016-08-11', '01:12', '台北', '新竹', 1, 200, '', '2016-07-29 14:47:48', '2016-07-29 05:49:14'),
(45, 'w570b7912f', '12359', '09124568', '2016-08-01', '02:34', '2016-08-02', '01:12', '台北', '桃園', 1, 100, '', '2016-07-31 18:34:32', '2016-07-31 18:34:32'),
(53, '1YH09atPbQ', '12359', '0912345678', '2016-08-01', '02:49', '2016-08-02', '01:12', '台北', '桃園', 7, 700, '', '2016-07-31 18:49:42', '2016-07-31 18:49:42'),
(54, '5eF65BChWQ', '12359', '0912345678', '2016-08-01', '02:50', '2016-08-11', '01:12', '台北', '桃園', 6, 600, '', '2016-07-31 18:50:28', '2016-07-31 18:50:28'),
(55, 'rwKYngHz4k', '12359', '0912345678', '2016-08-01', '02:51', '2016-08-02', '02:23', '桃園', '新竹', 1, 100, '', '2016-07-31 18:51:02', '2016-07-31 18:51:02'),
(56, 'Q54vm6M1G1', '12359', '0912345678', '2016-08-01', '03:11', '2016-08-02', '01:12', '台北', '桃園', 1, 100, '', '2016-07-31 19:11:08', '2016-07-31 19:11:08'),
(57, 'LVTs0fUN3P', '12359', '0912345678', '2016-08-01', '03:12', '2016-08-02', '01:12', '台北', '桃園', 1, 100, '', '2016-07-31 19:12:33', '2016-07-31 19:12:33'),
(58, 'NH3cw08b64', '12359', '0912345678', '2016-08-01', '03:12', '2016-08-02', '01:12', '台北', '桃園', 1, 100, '', '2016-07-31 19:12:50', '2016-07-31 19:12:50');

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
  `code` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `week` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `car_count` int(11) NOT NULL,
  `per_car` int(11) NOT NULL,
  `station` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `trains`
--

INSERT INTO `trains` (`code`, `type`, `week`, `car_count`, `per_car`, `station`, `start_time`, `created_at`, `updated_at`) VALUES
('12359', '1', '一,二,三,四,五', 2, 9, '台北,桃園,新竹,苗栗,台中,彰化,雲林,嘉義,台南', '01:12,02:23,03:51,04:12,05:41,06:12,07:34,08:34,09:12', '2016-08-01 02:49:15', '2016-07-31 18:49:15'),
('12399', '3', '四,五,六', 7, 88, '嘉義,台南,桃園,彰化', '01:00,02:00,03:00,04:00', '2016-07-29 00:55:29', '2016-07-29 00:55:29'),
('6551', '7', '六,日', 1, 9, '宜蘭,花蓮,台東,屏東,新竹,桃園,台北', '06:45,07:12,08:35,09:25,14:54,16:51,17:21', '2016-07-29 04:13:37', '2016-07-29 04:13:37');

-- --------------------------------------------------------

--
-- 資料表結構 `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `speed` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `types`
--

INSERT INTO `types` (`id`, `name`, `speed`, `created_at`, `updated_at`) VALUES
(1, '區間列車', 50, '2016-07-29 03:06:33', '0000-00-00 00:00:00'),
(2, '快速列車', 100, '2016-07-29 03:06:33', '0000-00-00 00:00:00'),
(3, '磁浮列車', 300, '2016-07-29 03:06:33', '0000-00-00 00:00:00'),
(4, '區間', 129, '2016-07-29 06:06:11', '2016-07-28 22:06:11'),
(7, '高速衝', 789, '2016-07-28 21:54:27', '2016-07-28 21:54:27');

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
(1, 'admin', 'admin', '$2y$10$.8P0A.IfJXCmVqI5R4qGKu.xY7ndjUHfzSJqBwtPXhvVnxydjdwnG', 'aMfhp4zoxUqVkeobHmggXuzuqYfa9Abjm4tY12i2w0G0eA3di1Wkd87tMxbZ', '2016-07-28 18:29:37', '2016-07-31 23:17:18');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unique` (`unique`);

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
  ADD PRIMARY KEY (`code`);

--
-- 資料表索引 `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- 使用資料表 AUTO_INCREMENT `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
