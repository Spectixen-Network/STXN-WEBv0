-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 25. kvě 2022, 13:57
-- Verze serveru: 10.4.24-MariaDB
-- Verze PHP: 8.1.6

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
(4, 'test1', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa332359d6f1d83567014', 'test1@test1.test1', 'images/noavatar.png', 0),
(5, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '', 'images/noavatar.png', 1),
(7, 'testToBanAdmin', '1', '', 'images/noavatar.png', 1);

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
  ADD PRIMARY KEY (`address_id`);

--
-- Indexy pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD KEY `user_key` (`uid`);

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
-- AUTO_INCREMENT pro tabulku `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD CONSTRAINT `banneduser_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `banneduser_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `user_key` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);

--
-- Omezení pro tabulku `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `fk_address` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`),
  ADD CONSTRAINT `user_key_info` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
