-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 23-12-2022 a les 00:38:27
-- Versió del servidor: 10.4.24-MariaDB
-- Versió de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS projecte2;

CREATE DATABASE IF NOT EXISTS projecte2;

USE projecte2;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `projecte2`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `destinacions`
--

CREATE TABLE `destinacions` (
  `id` int(11) NOT NULL COMMENT 'Clau Primària',
  `continent` varchar(255) NOT NULL COMMENT 'Continent',
  `pais` varchar(255) NOT NULL COMMENT 'Pais',
  `imatges` varchar(255) NOT NULL COMMENT 'Imatges de la destinació'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Taula de destinacions';

--
-- Bolcament de dades per a la taula `destinacions`
--

INSERT INTO `destinacions` (`id`, `continent`, `pais`, `imatges`) VALUES
(1, 'Europa', 'França', ''),
(2, 'Europa', 'Espanya', ''),
(3, 'Àsia', 'Japo', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `ofertes`
--

CREATE TABLE `ofertes` (
  `id` int(11) NOT NULL COMMENT 'Clau Primària',
  `iddesti` int(11) NOT NULL COMMENT 'Clau forana de destins',
  `preupersona` float NOT NULL COMMENT 'Preu per persona',
  `datainici` date NOT NULL COMMENT 'Data d''inici',
  `datafi` date NOT NULL COMMENT 'Data fi',
  `titol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ofertes de viatges';

--
-- Bolcament de dades per a la taula `ofertes`
--

INSERT INTO `ofertes` (`id`, `iddesti`, `preupersona`, `datainici`, `datafi`, `titol`) VALUES
(2, 1, 240, '2022-12-26', '2022-12-31', 'Prova'),
(3, 2, 230, '2022-12-22', '2022-12-29', 'Prova 2');

-- --------------------------------------------------------

--
-- Estructura de la taula `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `idoferta` int(11) NOT NULL COMMENT 'Clau Forana oferta',
  `nomclient` varchar(50) NOT NULL COMMENT 'Nom del client',
  `telefon` varchar(9) NOT NULL COMMENT 'Telefon del client',
  `npersones` int(11) NOT NULL COMMENT 'Nombre de persones',
  `descompte` tinyint(1) NOT NULL COMMENT 'Descompte',
  `datareserva` date NOT NULL COMMENT 'Data de la reserva'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `reserves`
--

INSERT INTO `reserves` (`id`, `idoferta`, `nomclient`, `telefon`, `npersones`, `descompte`, `datareserva`) VALUES
(1, 2, 'Jordi', '555555555', 2, 0, '0000-00-00'),
(2, 2, 'Sergi', '123123123', 3, 0, '2022-12-20'),
(3, 2, 'Sergi', '123123123', 3, 0, '2022-12-20'),
(6, 2, 'sadsasd', '123123123', 2, 1, '2022-12-22');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `destinacions`
--
ALTER TABLE `destinacions`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `ofertes`
--
ALTER TABLE `ofertes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddesti` (`iddesti`);

--
-- Índexs per a la taula `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idoferta` (`idoferta`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `destinacions`
--
ALTER TABLE `destinacions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clau Primària', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `ofertes`
--
ALTER TABLE `ofertes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clau Primària', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=7;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `ofertes`
--
ALTER TABLE `ofertes`
  ADD CONSTRAINT `ofertes_ibfk_1` FOREIGN KEY (`iddesti`) REFERENCES `destinacions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`idoferta`) REFERENCES `ofertes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
