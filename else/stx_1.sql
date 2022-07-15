-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 15. čec 2022, 14:43
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `stx_1`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `address`
--

CREATE TABLE `address` (
  `address_id` int(10) UNSIGNED NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `banneduser`
--

CREATE TABLE `banneduser` (
  `uid` int(10) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `calendar_event`
--

CREATE TABLE `calendar_event` (
  `uid` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_from` varchar(255) NOT NULL,
  `event_to` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `calendar_event`
--

INSERT INTO `calendar_event` (`uid`, `event_id`, `event_name`, `event_description`, `event_date`, `event_from`, `event_to`) VALUES
(2, 22, 'Dyk more prachy dojdu', 'U ARE BROKE HOE TILL THIS DAY', '2022-06-20', '00:00', '23:59'),
(1, 23, 'My Birthday', '', '2022-08-01', '00:00', '23:59'),
(1, 37, 'Mum&#039;s birthday', '', '2022-07-01', '00:00', '23:59');

-- --------------------------------------------------------

--
-- Struktura tabulky `calendar_tags`
--

CREATE TABLE `calendar_tags` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `tag_description` text DEFAULT NULL,
  `tag_color` varchar(255) DEFAULT '#ffff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `calendar_tags`
--

INSERT INTO `calendar_tags` (`user_id`, `tag_id`, `tag_name`, `tag_description`, `tag_color`) VALUES
(1, 1, 'TEST', NULL, '#fc03c6'),
(3, 2, 'Test', NULL, '#ffff'),
(1, 3, 'Testing', '', '#321ec8'),
(1, 4, 'Testing', '', '#321ec8'),
(1, 5, 'ts', '', '#d6e31c'),
(1, 6, 'sda', '', '#883a79'),
(1, 7, 'TestTAg', '', '#65d1ec'),
(2, 8, 'MONEH', 'The big $$$$$', '#3ee302'),
(1, 9, 'Birthdays', '', '#c81414');

-- --------------------------------------------------------

--
-- Struktura tabulky `event_tag`
--

CREATE TABLE `event_tag` (
  `uid` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `event_tag`
--

INSERT INTO `event_tag` (`uid`, `tag_id`, `event_id`) VALUES
(2, 8, 22),
(1, 9, 23),
(1, 9, 37);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `uid` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL DEFAULT 'images/noavatar.png',
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`uid`, `username`, `password`, `email`, `image_path`, `admin`) VALUES
(1, 'AppleJamp', 'f933ad3d093dc000bcf947b91d8e3c2b00088166820a531386069c39c504e4a7', 'd.pivka.st@spseiostrava.cz', 'images/avatar_red_zoomed.png', 2),
(2, 'Yura', '79b98a6be9e8e9b7492a8560b66dfe87ee8f162289d9c6bdb2cd4ec057e93e90', 'crazybrumikcz@gmail.com', 'images/SpectixenNetwork_logo.png', 2),
(3, 'test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@test.test', 'images/noavatar.png', 0),
(4, 'test1', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa332359d6f1d83567014', 'test1@test1.test1', 'images/noavatar.png', 1),
(5, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '', 'images/noavatar.png', 1),
(6, 'testToBan', 'e0670e55dbf2e1d06fbd1eabc6100b43f44c75857832c44f7d5c0034454fe98b', 'testToBan@test.com', 'images/noavatar.png', 0),
(7, 'testCssFile', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'testcss@test.cz', 'images/noavatar.png', 0),
(8, 'csstest', '5e772cdfa81655670dfce8b2941c35dadc6a61289d75b339ce2791b2f037616c', 'csstest@test.cz', 'images/noavatar.png', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `userinfo`
--

CREATE TABLE `userinfo` (
  `uid` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `address`
--
ALTER TABLE `address`
  ADD KEY `address_id` (`address_id`) USING BTREE;

--
-- Indexy pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD KEY `uid` (`uid`);

--
-- Indexy pro tabulku `calendar_event`
--
ALTER TABLE `calendar_event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `uid` (`uid`,`event_id`);

--
-- Indexy pro tabulku `calendar_tags`
--
ALTER TABLE `calendar_tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `event_tag`
--
ALTER TABLE `event_tag`
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `uid` (`uid`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexy pro tabulku `userinfo`
--
ALTER TABLE `userinfo`
  ADD KEY `user_key_info` (`uid`),
  ADD KEY `fk_address` (`address_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `calendar_event`
--
ALTER TABLE `calendar_event`
  MODIFY `event_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pro tabulku `calendar_tags`
--
ALTER TABLE `calendar_tags`
  MODIFY `tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `userinfo` (`address_id`);

--
-- Omezení pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD CONSTRAINT `banneduser_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Omezení pro tabulku `calendar_event`
--
ALTER TABLE `calendar_event`
  ADD CONSTRAINT `calendar_event_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Omezení pro tabulku `calendar_tags`
--
ALTER TABLE `calendar_tags`
  ADD CONSTRAINT `calendar_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`uid`);

--
-- Omezení pro tabulku `event_tag`
--
ALTER TABLE `event_tag`
  ADD CONSTRAINT `event_tag_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `calendar_tags` (`tag_id`),
  ADD CONSTRAINT `event_tag_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `calendar_event` (`event_id`),
  ADD CONSTRAINT `event_tag_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `calendar_tags` (`user_id`);

--
-- Omezení pro tabulku `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
