-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2023 a las 14:58:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ballint_bbdd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_21`
--

CREATE TABLE `tmp_partidoe_21` (
  `id` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `timeouts` int(11) DEFAULT 0,
  `faltasbanquillo` int(11) DEFAULT 0,
  `puntos` int(11) DEFAULT 0,
  `lider` tinyint(1) NOT NULL,
  `empate` tinyint(1) NOT NULL DEFAULT 1,
  `alternancias` int(11) DEFAULT 0,
  `vecesempatados` int(11) DEFAULT 0,
  `veceslider` int(11) DEFAULT 0,
  `q1` int(11) DEFAULT 0,
  `q2` int(11) DEFAULT 0,
  `q3` int(11) DEFAULT 0,
  `q4` int(11) DEFAULT 0,
  `extra` int(11) DEFAULT 0,
  `parcial_lastto` int(11) NOT NULL DEFAULT 0,
  `parcial_lastchange` int(11) NOT NULL DEFAULT 0,
  `parcial` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partidoe_21`
--

INSERT INTO `tmp_partidoe_21` (`id`, `equipo`, `timeouts`, `faltasbanquillo`, `puntos`, `lider`, `empate`, `alternancias`, `vecesempatados`, `veceslider`, `q1`, `q2`, `q3`, `q4`, `extra`, `parcial_lastto`, `parcial_lastchange`, `parcial`) VALUES
(1, 'NacionalMasculino', 0, 0, 2, 1, 0, 1, 0, 1, 2, 0, 0, 0, 0, 0, 0, 0),
(2, 'TresCantosNacional', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tmp_partidoe_21`
--
ALTER TABLE `tmp_partidoe_21`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_21`
--
ALTER TABLE `tmp_partidoe_21`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
