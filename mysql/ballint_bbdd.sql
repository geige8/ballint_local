-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2023 a las 22:23:02
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
-- Estructura de tabla para la tabla `credenciales`
--

CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol` set('E','J','DT','A') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `user`, `password`, `rol`) VALUES
(1, 'Pedro', '$2y$10$0Zwrb1SEMkk2tJDRwbUK1O2dVJcJjQTvUrJHHguJu3.KZ.0WzrYAy', 'J'),
(2, 'JuanPe', '12345', 'J'),
(3, 'PaGar3', '12345', 'J'),
(4, 'JBruq', '12345', 'J'),
(5, 'PaGCV', '12345', 'J'),
(6, 'DavidC', '12345', 'J'),
(7, 'PabEG', '12345', 'J'),
(8, 'Manull', '12345', 'J'),
(9, 'Ikermc', '12345', 'J'),
(10, 'Linomf', '12345', 'J'),
(11, 'Beltmn', '12345', 'J'),
(12, 'AlbertoST', '12345', 'J'),
(13, 'JoacoY', '$2y$10$0Zwrb1SEMkk2tJDRwbUK1O2dVJcJjQTvUrJHHguJu3.KZ.0WzrYAy', 'J'),
(14, 'JoseluS', '12345', 'J'),
(18, 'admin', '$2y$10$agS4H2gHlgMS9In9sO9oNudEYnndmCssEQXIOt2lUtBc3croIn5M.', 'A'),
(19, 'GonzaloGaezE8', '$2y$10$xhAyK5xNr42DUH.TUVMAXOGIkFVtJPCGwQBbGToD862mGgaBbvzc.', 'E'),
(24, 'MarioGoezJ', '$2y$10$XZvFs2j6Il6HS8ZfGv1WCetVzmUNDvn851HIWkibUIPDY6TV0Pv.C', 'J'),
(25, 'JuanPeezDT', '$2y$10$RmCVZe0TIHM09NHVURvNdekBdRU6k0Zeyltfk3DFRdouKk85VvUOm', 'DT'),
(26, 'LolalinGainE', '$2y$10$cdlG2R6TYhRE4BT.CmKhW.ub1W5Bu/SKtviroQYmsUeJwAV7V4nvy', 'E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directorestecnicos`
--

CREATE TABLE `directorestecnicos` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `directorestecnicos`
--

INSERT INTO `directorestecnicos` (`id`, `user`, `nombre`, `apellido1`, `apellido2`) VALUES
(1, 'JuanPeezDT', 'Juan', 'Perez', 'Pomez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrenadores`
--

INSERT INTO `entrenadores` (`id`, `user`, `nombre`, `apellido1`, `apellido2`) VALUES
(3, 'GonzaloGaezE8', 'Gonzalo', 'Garcia', 'Gomez'),
(5, 'LolalinGainE', 'Lolalin', 'Garcia', 'Martin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(10) NOT NULL,
  `id_equipo` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  `seccion` enum('Masculino','Femenino') NOT NULL,
  `letra` varchar(1) DEFAULT NULL,
  `PJ` int(11) NOT NULL,
  `W` int(11) NOT NULL,
  `L` int(11) NOT NULL,
  `PPP` int(11) NOT NULL,
  `PPR` int(11) NOT NULL,
  `MT` float NOT NULL,
  `MSMS` float NOT NULL,
  `T2A` int(11) NOT NULL,
  `T2F` int(11) NOT NULL,
  `T3A` int(11) NOT NULL,
  `T3F` int(11) NOT NULL,
  `TLA` int(11) NOT NULL,
  `TLF` int(11) NOT NULL,
  `FLH` int(11) NOT NULL,
  `TEC` int(11) NOT NULL,
  `FLR` int(11) NOT NULL,
  `RBO` int(11) NOT NULL,
  `RBD` int(11) NOT NULL,
  `ROB` int(11) NOT NULL,
  `TAP` int(11) NOT NULL,
  `PRD` int(11) NOT NULL,
  `AST` int(11) NOT NULL,
  `PTQ1` int(11) NOT NULL,
  `PTQ2` int(11) NOT NULL,
  `PTQ3` int(11) NOT NULL,
  `PTQ4` int(11) NOT NULL,
  `PTQE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `id_equipo`, `categoria`, `nombre_equipo`, `seccion`, `letra`, `PJ`, `W`, `L`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `TEC`, `FLR`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(4, 'Sub22Femenino', 'Sub22', 'Liceo Frances Sub22 Femenino', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'Nacional', 'Liceo Frances Nacional Masculino', 'Masculino', 'A', 2, 2, 0, 4, 0, 0, 326, 163, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `numero` int(2) DEFAULT NULL,
  `PJ` int(5) NOT NULL,
  `MT` int(10) NOT NULL,
  `TIT` int(5) NOT NULL,
  `SUP` int(5) NOT NULL,
  `MSMS` float NOT NULL,
  `T2A` int(5) NOT NULL,
  `T2F` int(5) NOT NULL,
  `T3A` int(5) NOT NULL,
  `T3F` int(5) NOT NULL,
  `TLA` int(5) NOT NULL,
  `TLF` int(5) NOT NULL,
  `FLH` int(5) NOT NULL,
  `FLR` int(5) NOT NULL,
  `TEC` int(11) NOT NULL,
  `RBO` int(5) NOT NULL,
  `RBD` int(5) NOT NULL,
  `ROB` int(5) NOT NULL,
  `TAP` int(5) NOT NULL,
  `PRD` int(5) NOT NULL,
  `AST` int(5) NOT NULL,
  `PTQ1` int(11) NOT NULL DEFAULT 0,
  `PTQ2` int(11) NOT NULL DEFAULT 0,
  `PTQ3` int(11) NOT NULL DEFAULT 0,
  `PTQ4` int(11) NOT NULL DEFAULT 0,
  `PTQE` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `user`, `nombre`, `apellido1`, `apellido2`, `numero`, `PJ`, `MT`, `TIT`, `SUP`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'Pedro', 'Pedro', 'Martinez', 'Fernandez', 1, 2, 0, 2, 0, 326, 163, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 326, 0, 0, 0, 0),
(2, 'JuanPe', 'Juan ', 'Pérez', 'García', 2, 2, 0, 2, 0, 326, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'PaGar3', 'Pablo ', 'Alonso ', 'García', 3, 2, 0, 2, 0, 326, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'JBruq', 'Javier', 'Bru', 'Querol', 4, 2, 0, 2, 0, 326, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'PaGCV', 'Pablo Gregorio', 'Carrasco', 'Villacastin', 5, 2, 0, 2, 0, 326, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'DavidC', 'David', 'Casillas', 'Pirajno', 6, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'PabEG', 'Pablo', 'Esteban', 'Gonzalez', 7, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Manull', 'Manuel', 'Martinez', 'Llimona', 8, 12, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'Ikermc', 'Iker', 'Mateo', 'Castaño', 9, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'Linomf', 'Lino', 'Monteagudo', 'Fuentes', 10, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Beltmn', 'Beltrán', 'Moraleda', 'Navarro', 11, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'AlbertoST', 'Alberto', 'Sanz', 'Toril', 12, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'JoacoY', 'Joaquín', 'Yañez', 'Saz', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'JoseluS', 'Juan Luis', 'Saez-Benito', 'Torquemada', 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'MarioGoezJ', 'Mario', 'Gomez', 'Lopez', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int(11) NOT NULL,
  `local` varchar(50) NOT NULL,
  `visitante` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `WL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `local`, `visitante`, `fecha`, `hora`, `WL`) VALUES
(37, 'NacionalMasculino', 'TresCantosNacional', '2023-08-06', '18:43:00', 1),
(38, 'NacionalMasculino', 'CBLR', '2023-08-08', '13:41:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_37`
--

CREATE TABLE `tmp_partidoe_37` (
  `id` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `lider` tinyint(1) NOT NULL,
  `empate` tinyint(1) NOT NULL DEFAULT 1,
  `timeouts` int(11) DEFAULT 0,
  `faltasbanquillo` int(11) DEFAULT 0,
  `alternancias` int(11) DEFAULT 0,
  `vecesempatados` int(11) DEFAULT 0,
  `veceslider` int(11) DEFAULT 0,
  `parcial_lastto` int(11) DEFAULT 0,
  `parcial_lastchange` int(11) DEFAULT 0,
  `parcial` int(11) DEFAULT 0,
  `mayorventaja` int(11) DEFAULT 0,
  `tiempolider` int(11) DEFAULT 0,
  `PPP` int(11) DEFAULT 0,
  `PPR` int(11) DEFAULT 0,
  `MT` int(11) DEFAULT 0,
  `MSMS` int(11) DEFAULT 0,
  `T2A` int(11) DEFAULT 0,
  `T2F` int(11) DEFAULT 0,
  `T3A` int(11) DEFAULT 0,
  `T3F` int(11) DEFAULT 0,
  `TLA` int(11) DEFAULT 0,
  `TLF` int(11) DEFAULT 0,
  `FLH` int(11) DEFAULT 0,
  `FLR` int(11) DEFAULT 0,
  `RBO` int(11) DEFAULT 0,
  `RBD` int(11) DEFAULT 0,
  `TEC` int(11) DEFAULT 0,
  `ROB` int(11) DEFAULT 0,
  `TAP` int(11) DEFAULT 0,
  `PRD` int(11) DEFAULT 0,
  `AST` int(11) DEFAULT 0,
  `PTQ1` int(11) DEFAULT 0,
  `PTQ2` int(11) DEFAULT 0,
  `PTQ3` int(11) DEFAULT 0,
  `PTQ4` int(11) DEFAULT 0,
  `PTQE` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partidoe_37`
--

INSERT INTO `tmp_partidoe_37` (`id`, `equipo`, `lider`, `empate`, `timeouts`, `faltasbanquillo`, `alternancias`, `vecesempatados`, `veceslider`, `parcial_lastto`, `parcial_lastchange`, `parcial`, `mayorventaja`, `tiempolider`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `RBO`, `RBD`, `TEC`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 1, 0, 0, 0, 1, 0, 1, 304, 304, 304, 304, 0, 2, 0, 0, 304, 152, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0),
(2, 'TresCantosNacional', 0, 0, 0, 0, 1, 0, 0, 0, 0, -304, 0, 0, 0, 2, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_38`
--

CREATE TABLE `tmp_partidoe_38` (
  `id` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `lider` tinyint(1) NOT NULL,
  `empate` tinyint(1) NOT NULL DEFAULT 1,
  `timeouts` int(11) DEFAULT 0,
  `faltasbanquillo` int(11) DEFAULT 0,
  `alternancias` int(11) DEFAULT 0,
  `vecesempatados` int(11) DEFAULT 0,
  `veceslider` int(11) DEFAULT 0,
  `parcial_lastto` int(11) DEFAULT 0,
  `parcial_lastchange` int(11) DEFAULT 0,
  `parcial` int(11) DEFAULT 0,
  `mayorventaja` int(11) DEFAULT 0,
  `tiempolider` int(11) DEFAULT 0,
  `PPP` int(11) DEFAULT 0,
  `PPR` int(11) DEFAULT 0,
  `MT` int(11) DEFAULT 0,
  `MSMS` int(11) DEFAULT 0,
  `T2A` int(11) DEFAULT 0,
  `T2F` int(11) DEFAULT 0,
  `T3A` int(11) DEFAULT 0,
  `T3F` int(11) DEFAULT 0,
  `TLA` int(11) DEFAULT 0,
  `TLF` int(11) DEFAULT 0,
  `FLH` int(11) DEFAULT 0,
  `FLR` int(11) DEFAULT 0,
  `RBO` int(11) DEFAULT 0,
  `RBD` int(11) DEFAULT 0,
  `TEC` int(11) DEFAULT 0,
  `ROB` int(11) DEFAULT 0,
  `TAP` int(11) DEFAULT 0,
  `PRD` int(11) DEFAULT 0,
  `AST` int(11) DEFAULT 0,
  `PTQ1` int(11) DEFAULT 0,
  `PTQ2` int(11) DEFAULT 0,
  `PTQ3` int(11) DEFAULT 0,
  `PTQ4` int(11) DEFAULT 0,
  `PTQE` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partidoe_38`
--

INSERT INTO `tmp_partidoe_38` (`id`, `equipo`, `lider`, `empate`, `timeouts`, `faltasbanquillo`, `alternancias`, `vecesempatados`, `veceslider`, `parcial_lastto`, `parcial_lastchange`, `parcial`, `mayorventaja`, `tiempolider`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `RBO`, `RBD`, `TEC`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 1, 0, 0, 0, 1, 0, 1, 22, 22, 22, 22, 0, 2, 0, 0, 22, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0),
(2, 'CBLR', 0, 0, 0, 0, 1, 0, 0, 0, 0, -22, 0, 0, 0, 2, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_37`
--

CREATE TABLE `tmp_partido_37` (
  `id` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `jugador` varchar(50) NOT NULL,
  `nombrejugador` varchar(50) NOT NULL,
  `numero` int(2) DEFAULT NULL,
  `titular` tinyint(1) NOT NULL,
  `en_juego` tinyint(1) NOT NULL,
  `MT` int(11) DEFAULT 0,
  `MSMS` int(11) DEFAULT 0,
  `T2A` int(11) DEFAULT 0,
  `T2F` int(11) DEFAULT 0,
  `T3A` int(11) DEFAULT 0,
  `T3F` int(11) DEFAULT 0,
  `TLA` int(11) DEFAULT 0,
  `TLF` int(11) DEFAULT 0,
  `FLH` int(11) DEFAULT 0,
  `FLR` int(11) DEFAULT 0,
  `TEC` int(11) DEFAULT 0,
  `RBO` int(11) DEFAULT 0,
  `RBD` int(11) DEFAULT 0,
  `ROB` int(11) DEFAULT 0,
  `TAP` int(11) DEFAULT 0,
  `PRD` int(11) DEFAULT 0,
  `AST` int(11) DEFAULT 0,
  `PTQ1` int(11) DEFAULT 0,
  `PTQ2` int(11) DEFAULT 0,
  `PTQ3` int(11) DEFAULT 0,
  `PTQ4` int(11) DEFAULT 0,
  `PTQE` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partido_37`
--

INSERT INTO `tmp_partido_37` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 0, 304, 152, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 304, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 0, 304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 0, 304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 0, 304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 0, 304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'NacionalMasculino', 'Linomf', 'Lino Monteagudo Fuentes', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'NacionalMasculino', 'Beltmn', 'Beltrán Moraleda Navarro', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'NacionalMasculino', 'AlbertoST', 'Alberto Sanz Toril', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'TresCantosNacional', 'Juanpedro', 'Juanpedro', 1, 1, 1, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'TresCantosNacional', 'Agustinio', 'Agustinio', 2, 1, 1, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'TresCantosNacional', 'Fernando', 'Fernando', 3, 1, 1, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'TresCantosNacional', 'Mariote', 'Mariote', 4, 1, 1, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'TresCantosNacional', 'JuanPablo', 'JuanPablo', 5, 1, 1, 0, -304, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'TresCantosNacional', 'Lucas', 'Lucas', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'TresCantosNacional', 'Martín', 'Martín', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'TresCantosNacional', 'Lolo', 'Lolo', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'TresCantosNacional', 'Martino', 'Martino', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'TresCantosNacional', 'Diawara', 'Diawara', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'TresCantosNacional', 'JuanPedrito', 'JuanPedrito', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'TresCantosNacional', 'Guillermin', 'Guillermin', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_38`
--

CREATE TABLE `tmp_partido_38` (
  `id` int(11) NOT NULL,
  `equipo` varchar(50) NOT NULL,
  `jugador` varchar(50) NOT NULL,
  `nombrejugador` varchar(50) NOT NULL,
  `numero` int(2) DEFAULT NULL,
  `titular` tinyint(1) NOT NULL,
  `en_juego` tinyint(1) NOT NULL,
  `MT` int(11) DEFAULT 0,
  `MSMS` int(11) DEFAULT 0,
  `T2A` int(11) DEFAULT 0,
  `T2F` int(11) DEFAULT 0,
  `T3A` int(11) DEFAULT 0,
  `T3F` int(11) DEFAULT 0,
  `TLA` int(11) DEFAULT 0,
  `TLF` int(11) DEFAULT 0,
  `FLH` int(11) DEFAULT 0,
  `FLR` int(11) DEFAULT 0,
  `TEC` int(11) DEFAULT 0,
  `RBO` int(11) DEFAULT 0,
  `RBD` int(11) DEFAULT 0,
  `ROB` int(11) DEFAULT 0,
  `TAP` int(11) DEFAULT 0,
  `PRD` int(11) DEFAULT 0,
  `AST` int(11) DEFAULT 0,
  `PTQ1` int(11) DEFAULT 0,
  `PTQ2` int(11) DEFAULT 0,
  `PTQ3` int(11) DEFAULT 0,
  `PTQ4` int(11) DEFAULT 0,
  `PTQE` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partido_38`
--

INSERT INTO `tmp_partido_38` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 0, 22, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 22, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 0, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 0, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 0, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 0, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'NacionalMasculino', 'Linomf', 'Lino Monteagudo Fuentes', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'NacionalMasculino', 'Beltmn', 'Beltrán Moraleda Navarro', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'NacionalMasculino', 'AlbertoST', 'Alberto Sanz Toril', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'CBLR', 'Juanpedro', 'Juanpedro', 1, 1, 1, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'CBLR', 'Agustinio', 'Agustinio', 2, 1, 1, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'CBLR', 'Fernando', 'Fernando', 3, 1, 1, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'CBLR', 'Mariote', 'Mariote', 4, 1, 1, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'CBLR', 'JuanPablo', 'JuanPablo', 5, 1, 1, 0, -22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'CBLR', 'Lucas', 'Lucas', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'CBLR', 'Martín', 'Martín', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'CBLR', 'Lolo', 'Lolo', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'CBLR', 'Martino', 'Martino', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'CBLR', 'Diawara', 'Diawara', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'CBLR', 'JuanPedrito', 'JuanPedrito', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'CBLR', 'Guillermin', 'Guillermin', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_equipos`
--

CREATE TABLE `usuarios_equipos` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_equipos`
--

INSERT INTO `usuarios_equipos` (`id`, `equipo_id`, `usuario_id`) VALUES
(29, 5, 1),
(30, 5, 2),
(31, 5, 3),
(32, 5, 4),
(33, 5, 5),
(34, 5, 6),
(35, 5, 7),
(36, 5, 8),
(37, 5, 9),
(38, 5, 10),
(39, 5, 11),
(40, 5, 12),
(41, 5, 13),
(42, 5, 14),
(44, 5, 19),
(43, 5, 24),
(45, 5, 26);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indices de la tabla `directorestecnicos`
--
ALTER TABLE `directorestecnicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indices de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioEnt_fk` (`user`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_equipo` (`id_equipo`),
  ADD UNIQUE KEY `nombre_equipo` (`nombre_equipo`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_id_fk` (`local`);

--
-- Indices de la tabla `tmp_partidoe_37`
--
ALTER TABLE `tmp_partidoe_37`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe_38`
--
ALTER TABLE `tmp_partidoe_38`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_37`
--
ALTER TABLE `tmp_partido_37`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_38`
--
ALTER TABLE `tmp_partido_38`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ENTRADA_UNICA` (`usuario_id`,`equipo_id`) USING BTREE,
  ADD KEY `equipo_fk` (`equipo_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `directorestecnicos`
--
ALTER TABLE `directorestecnicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_37`
--
ALTER TABLE `tmp_partidoe_37`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_38`
--
ALTER TABLE `tmp_partidoe_38`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_37`
--
ALTER TABLE `tmp_partido_37`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_38`
--
ALTER TABLE `tmp_partido_38`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `directorestecnicos`
--
ALTER TABLE `directorestecnicos`
  ADD CONSTRAINT `directortecnico_fk` FOREIGN KEY (`user`) REFERENCES `credenciales` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD CONSTRAINT `usuarioEnt_fk` FOREIGN KEY (`user`) REFERENCES `credenciales` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`user`) REFERENCES `credenciales` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `equipo_id_fk` FOREIGN KEY (`local`) REFERENCES `equipos` (`id_equipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD CONSTRAINT `equipo_fk` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`usuario_id`) REFERENCES `credenciales` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
