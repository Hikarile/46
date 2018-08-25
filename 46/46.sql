-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-03-29 18:24:59
-- 伺服器版本: 10.1.10-MariaDB
-- PHP 版本： 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `46`
--

-- --------------------------------------------------------

--
-- 資料表結構 `one`
--

CREATE TABLE `one` (
  `id` int(11) NOT NULL,
  `ac` text COLLATE utf8_unicode_ci NOT NULL,
  `ps` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `one`
--

INSERT INTO `one` (`id`, `ac`, `ps`) VALUES
(1, 'admin', '1234');

-- --------------------------------------------------------

--
-- 資料表結構 `qa`
--

CREATE TABLE `qa` (
  `id` int(11) NOT NULL,
  `w-id` int(11) NOT NULL,
  `q` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `be` int(11) NOT NULL,
  `ta` int(11) NOT NULL,
  `a` text COLLATE utf8_unicode_ci NOT NULL,
  `h` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `qa`
--

INSERT INTO `qa` (`id`, `w-id`, `q`, `type`, `be`, `ta`, `a`, `h`) VALUES
(193, 103, 'aaa', 3, 1, 0, '111,222,333,444,', 4),
(210, 105, '111', 1, 1, 0, '', 4),
(211, 105, '222', 2, 1, 0, 'qqq,wwww,eee,rrrr,iiii,', 5),
(212, 105, '333', 3, 1, 0, 'ttt,yyy,uuu,', 3),
(213, 105, '444', 4, 1, 0, '', 4),
(214, 106, '你好嗎', 1, 1, 0, '', 4),
(215, 106, '我很好', 4, 1, 0, '', 4),
(229, 111, 'qqqqq', 1, 1, 0, '', 4),
(230, 111, 'wwww', 3, 1, 1, '111,', 1),
(231, 111, 'eeee', 3, 1, 0, '222,333,444,', 3),
(232, 111, 'yyyyy', 3, 1, 0, '99999,101010101,', 2),
(233, 112, 'qqqqqqqqqqq', 1, 1, 0, '', 4),
(234, 112, 'wwwwwwwwwww', 2, 1, 0, '111,222,333,', 3),
(235, 112, 'eeeeeeeeeee', 3, 1, 0, '555,666,777,888,', 4),
(236, 113, 'qqqqq', 1, 1, 0, '', 4),
(237, 113, 'qqq', 1, 1, 0, '', 4),
(238, 113, 'qqq', 1, 1, 0, '', 4),
(239, 113, 'qqqqq', 1, 1, 0, '', 4),
(240, 113, 'qqqq', 1, 1, 0, '', 4),
(241, 113, 'qqqq', 1, 1, 0, '', 4);

-- --------------------------------------------------------

--
-- 資料表結構 `see`
--

CREATE TABLE `see` (
  `id` int(11) NOT NULL,
  `d-id` int(11) NOT NULL,
  `d` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `see`
--

INSERT INTO `see` (`id`, `d-id`, `d`) VALUES
(132, 193, '444'),
(133, 198, '是'),
(134, 199, '11'),
(135, 200, '55'),
(136, 201, 'aaa'),
(137, 198, '是'),
(138, 199, '11'),
(139, 200, '55'),
(140, 201, 'aa'),
(141, 193, '444'),
(142, 193, '444'),
(143, 193, '444'),
(144, 193, '444'),
(145, 193, '444'),
(146, 193, '333'),
(147, 193, '444'),
(148, 193, '333'),
(149, 193, '444'),
(150, 229, '是'),
(151, 193, '444'),
(152, 229, '否'),
(153, 230, '111'),
(154, 231, '222'),
(155, 232, '99999'),
(156, 229, '否'),
(157, 230, '111'),
(158, 231, '222'),
(159, 232, '99999'),
(160, 236, '是'),
(161, 237, '是'),
(162, 238, '是'),
(163, 239, '是'),
(164, 240, '是'),
(165, 241, '是');

-- --------------------------------------------------------

--
-- 資料表結構 `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `number` text COLLATE utf8_unicode_ci NOT NULL,
  `pp` text COLLATE utf8_unicode_ci NOT NULL,
  `page` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 資料表的匯出資料 `work`
--

INSERT INTO `work` (`id`, `name`, `number`, `pp`, `page`) VALUES
(103, 'a', 'L45URW8CBP', '1', '0'),
(105, 'qqqqqqqqq', 'AXTR8CVBF1', '4', '0'),
(106, '陳冠融', 'PXFBI7U9EV', '2', '0'),
(110, 'yy', '16H5R4BXPA', '2', '不分頁'),
(111, '5', '4TKFVWR8QC', '5', '0'),
(112, 'ffffff', 'EPG7VSIZXU', '3', '1'),
(113, '6', 'XUZS5O4RYW', '6', '0');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `one`
--
ALTER TABLE `one`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `qa`
--
ALTER TABLE `qa`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `see`
--
ALTER TABLE `see`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `one`
--
ALTER TABLE `one`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用資料表 AUTO_INCREMENT `qa`
--
ALTER TABLE `qa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;
--
-- 使用資料表 AUTO_INCREMENT `see`
--
ALTER TABLE `see`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
--
-- 使用資料表 AUTO_INCREMENT `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
