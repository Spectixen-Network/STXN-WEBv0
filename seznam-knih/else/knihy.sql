-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 13. čen 2022, 01:35
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
-- Databáze: `knihy`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `autor`
--

CREATE TABLE `autor` (
  `id` int(255) NOT NULL,
  `jmeno` varchar(255) NOT NULL,
  `prijmeni` varchar(255) NOT NULL,
  `skupina` varchar(255) DEFAULT NULL,
  `info` varchar(2555) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `autor`
--

INSERT INTO `autor` (`id`, `jmeno`, `prijmeni`, `skupina`, `info`) VALUES
(7, 'Dominik', 'Pivka', 'IDK', NULL),
(8, 'Karel', 'Poláček', '', ''),
(9, 'William', 'Shakespeare', '', ''),
(10, 'Daniel', 'Defoe', '', ''),
(11, 'Karel Jaromír', 'Erben', '', ''),
(12, 'Božena', 'Němcová', '', ''),
(13, 'Jan', 'Neruda', 'Májovci', ''),
(14, 'Jaroslav (Emil)', 'Vrchlický (Frýda)', 'Lumírovci', ''),
(15, 'Sir Arthur Conan', 'Doyle', '', ''),
(16, 'George Bernard', 'Shaw', '', ''),
(17, 'Ernest', 'Hemingway', '', ''),
(18, 'Erich Maria', 'Remarque', '', ''),
(19, 'Romain', 'Rolland', '1. Světová válka', ''),
(20, 'Petr; Vladimír', 'Bezruč; Vašek', 'Anarchističtí buřiči', ''),
(21, 'Karel', 'Čapek', '', ''),
(22, 'Jaroslav', 'Hašek', '', ''),
(23, 'Bohumil', 'Hrabal', '', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `autor_smer`
--

CREATE TABLE `autor_smer` (
  `autor_id` int(255) NOT NULL,
  `smer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `autor_smer`
--

INSERT INTO `autor_smer` (`autor_id`, `smer_id`) VALUES
(8, 10),
(8, 11),
(9, 7),
(10, 6),
(11, 12),
(12, 7),
(13, 8),
(14, 13),
(15, 8),
(16, 14),
(17, 9),
(18, 8),
(19, 8),
(20, 5),
(20, 15),
(20, 16),
(21, 10),
(22, 11),
(23, 17);

-- --------------------------------------------------------

--
-- Struktura tabulky `dilo`
--

CREATE TABLE `dilo` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL,
  `literarni_druh` varchar(255) NOT NULL,
  `literarni_forma` varchar(255) NOT NULL,
  `casoprostor` varchar(255) NOT NULL,
  `kompozice` varchar(255) NOT NULL,
  `struktura` varchar(2555) NOT NULL,
  `obsah` text NOT NULL,
  `forma` varchar(255) NOT NULL,
  `figury_a_tropy` varchar(2555) DEFAULT NULL,
  `rymy` varchar(255) DEFAULT NULL,
  `rytmus` varchar(255) DEFAULT NULL,
  `druhy_postav` varchar(255) DEFAULT NULL,
  `charakteristika` text DEFAULT NULL,
  `tema` varchar(255) NOT NULL,
  `vysvetleni_nazvu` varchar(2555) NOT NULL,
  `jazykove_prostredky` varchar(255) NOT NULL,
  `autor_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `dilo_zanr`
--

CREATE TABLE `dilo_zanr` (
  `dilo_id` int(255) NOT NULL,
  `zanr_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `postava`
--

CREATE TABLE `postava` (
  `dilo_id` int(255) NOT NULL,
  `jmeno` varchar(255) NOT NULL,
  `typ_postavy` varchar(255) NOT NULL,
  `vlastnost` varchar(255) NOT NULL,
  `literarni_typ` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `smer`
--

CREATE TABLE `smer` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `smer`
--

INSERT INTO `smer` (`id`, `nazev`) VALUES
(5, 'Renesance'),
(6, 'Osvícenství'),
(7, 'Anglická renesance'),
(8, 'Realismus'),
(9, 'Moderní světová literatura'),
(10, 'Demokratický proud'),
(11, 'Česká meziválečná literatura'),
(12, 'Český romantismus'),
(13, 'Kosmopolitní proud'),
(14, 'Fabiánská společnost'),
(15, 'Symbolismus'),
(16, 'Impresionismus'),
(17, 'Česká próza');

-- --------------------------------------------------------

--
-- Struktura tabulky `zanr`
--

CREATE TABLE `zanr` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `zanr`
--

INSERT INTO `zanr` (`id`, `nazev`) VALUES
(7, 'Román (Humoristický)'),
(8, 'Novela'),
(9, 'Tragédie'),
(10, 'Román (Dobrodružný)'),
(11, 'Balada'),
(12, 'Povídka'),
(13, 'Komedie'),
(14, 'Román (Detektivní)'),
(15, 'Román (Protiválečný)'),
(16, 'Novela (Protiválečná)'),
(17, 'Různorodá sbírka');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jmeno` (`jmeno`,`prijmeni`);

--
-- Indexy pro tabulku `autor_smer`
--
ALTER TABLE `autor_smer`
  ADD UNIQUE KEY `autor_id` (`autor_id`,`smer_id`),
  ADD KEY `smer_id` (`smer_id`);

--
-- Indexy pro tabulku `dilo`
--
ALTER TABLE `dilo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Indexy pro tabulku `dilo_zanr`
--
ALTER TABLE `dilo_zanr`
  ADD UNIQUE KEY `dilo_id` (`dilo_id`,`zanr_id`),
  ADD KEY `zanr_id` (`zanr_id`);

--
-- Indexy pro tabulku `postava`
--
ALTER TABLE `postava`
  ADD KEY `dilo_id` (`dilo_id`);

--
-- Indexy pro tabulku `smer`
--
ALTER TABLE `smer`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `zanr`
--
ALTER TABLE `zanr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pro tabulku `dilo`
--
ALTER TABLE `dilo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pro tabulku `smer`
--
ALTER TABLE `smer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pro tabulku `zanr`
--
ALTER TABLE `zanr`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `autor_smer`
--
ALTER TABLE `autor_smer`
  ADD CONSTRAINT `autor_smer_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`),
  ADD CONSTRAINT `autor_smer_ibfk_2` FOREIGN KEY (`smer_id`) REFERENCES `smer` (`id`);

--
-- Omezení pro tabulku `dilo`
--
ALTER TABLE `dilo`
  ADD CONSTRAINT `dilo_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`);

--
-- Omezení pro tabulku `dilo_zanr`
--
ALTER TABLE `dilo_zanr`
  ADD CONSTRAINT `dilo_zanr_ibfk_1` FOREIGN KEY (`dilo_id`) REFERENCES `dilo` (`id`),
  ADD CONSTRAINT `dilo_zanr_ibfk_2` FOREIGN KEY (`zanr_id`) REFERENCES `zanr` (`id`);

--
-- Omezení pro tabulku `postava`
--
ALTER TABLE `postava`
  ADD CONSTRAINT `postava_ibfk_1` FOREIGN KEY (`dilo_id`) REFERENCES `dilo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
