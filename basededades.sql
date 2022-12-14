-- SQLBook: Code
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2022 a las 20:21:58
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projecte2`
--

DROP DATABASE IF EXISTS projecte2;

CREATE DATABASE IF NOT EXISTS projecte2;

USE projecte2;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `continents`
--

CREATE TABLE `continents` (
  `id` int(11) NOT NULL,
  `continent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinacions`
--

CREATE TABLE `destinacions` (
  `id` int(11) NOT NULL COMMENT 'Clau Primària',
  `continent` int(11) NOT NULL COMMENT 'Continent',
  `pais` varchar(255) NOT NULL COMMENT 'Pais',
  `imatges` varchar(255) NOT NULL COMMENT 'Imatges de la destinació'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Taula de destinacions';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertes`
--

CREATE TABLE `ofertes` (
  `id` int(11) NOT NULL COMMENT 'Clau Primària',
  `iddesti` int(11) NOT NULL COMMENT 'Clau forana de destins',
  `preupersona` float NOT NULL COMMENT 'Preu per persona',
  `datainici` date NOT NULL COMMENT 'Data d''inici',
  `datafi` date NOT NULL COMMENT 'Data fi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ofertes de viatges';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserves`
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
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `continents`
--
ALTER TABLE `continents`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `destinacions`
--
ALTER TABLE `destinacions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ofertes`
--
ALTER TABLE `ofertes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddesti` (`iddesti`);

--
-- Indices de la tabla `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idoferta` (`idoferta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `continents`
--
ALTER TABLE `continents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinacions`
--
ALTER TABLE `destinacions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clau Primària';

--
-- AUTO_INCREMENT de la tabla `ofertes`
--
ALTER TABLE `ofertes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clau Primària';

--
-- AUTO_INCREMENT de la tabla `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ofertes`
--
ALTER TABLE `ofertes`
  ADD CONSTRAINT `ofertes_ibfk_1` FOREIGN KEY (`iddesti`) REFERENCES `destinacions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserves`
--
ALTER TABLE `reserves`
  ADD CONSTRAINT `reserves_ibfk_1` FOREIGN KEY (`idoferta`) REFERENCES `ofertes` (`id`);


ALTER TABLE `destinacions`
  ADD CONSTRAINT `destinacions_ibfk_1` FOREIGN KEY (`continent`) REFERENCES `continents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
