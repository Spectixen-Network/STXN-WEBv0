-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 09. čen 2022, 21:47
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
  `skupina` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `autor_smer`
--

CREATE TABLE `autor_smer` (
  `autor_id` int(255) NOT NULL,
  `smer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `autor_zanr`
--

CREATE TABLE `autor_zanr` (
  `autor_id` int(255) NOT NULL,
  `zanr_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `dilo`
--

CREATE TABLE `dilo` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL,
  `literarni_druh` varchar(255) NOT NULL,
  `casoprostor` varchar(255) NOT NULL,
  `struktura` varchar(2555) NOT NULL,
  `obsah` text NOT NULL,
  `forma` varchar(255) NOT NULL,
  `jmena_postav` varchar(2555) DEFAULT NULL,
  `typy` varchar(255) DEFAULT NULL,
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
-- Struktura tabulky `smer`
--

CREATE TABLE `smer` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabulky `zanr`
--

CREATE TABLE `zanr` (
  `id` int(255) NOT NULL,
  `nazev` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexy pro tabulku `autor_zanr`
--
ALTER TABLE `autor_zanr`
  ADD UNIQUE KEY `autor_id` (`autor_id`,`zanr_id`),
  ADD KEY `zanr_id` (`zanr_id`);

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `dilo`
--
ALTER TABLE `dilo`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `smer`
--
ALTER TABLE `smer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `zanr`
--
ALTER TABLE `zanr`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Omezení pro tabulku `autor_zanr`
--
ALTER TABLE `autor_zanr`
  ADD CONSTRAINT `autor_zanr_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`),
  ADD CONSTRAINT `autor_zanr_ibfk_2` FOREIGN KEY (`zanr_id`) REFERENCES `zanr` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
