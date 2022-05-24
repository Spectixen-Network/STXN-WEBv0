-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 24. kvě 2022, 21:19
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
-- Struktura tabulky `banneduser`
--

CREATE TABLE `banneduser` (
  `uid` int(10) UNSIGNED NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `banneduser`
--

INSERT INTO `banneduser` (`uid`, `from_date`, `to_date`, `reason`) VALUES
(6, '2022-05-23', '2022-05-25', NULL);

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
(6, 'testToBan', 'e0670e55dbf2e1d06fbd1eabc6100b43f44c75857832c44f7d5c0034454fe98b', 'testToBan@test.com', 'images/noavatar.png', 0);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD KEY `uid` (`uid`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `banneduser`
--
ALTER TABLE `banneduser`
  ADD CONSTRAINT `banneduser_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
