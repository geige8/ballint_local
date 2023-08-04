-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2023 a las 12:33:31
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
(13, 'JoacoY', '12345', 'J'),
(14, 'JoseluS', '12345', 'J'),
(15, 'Jongil', '12345', 'J'),
(16, 'Mariogl', '12345', 'J'),
(18, 'admin', '$2y$10$agS4H2gHlgMS9In9sO9oNudEYnndmCssEQXIOt2lUtBc3croIn5M.', 'A'),
(19, 'GonzaloGaezE', '$2y$10$xhAyK5xNr42DUH.TUVMAXOGIkFVtJPCGwQBbGToD862mGgaBbvzc.', 'E'),
(22, 'JuanGaezDT', '$2y$10$N8kl4RUH1rg3q/Ljf3RuMeTRROYw1CJR7RNTuVapmWCT1rswFoXzO', 'DT');

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
(3, 'GonzaloGaezE', 'Gonzalo', 'Garcia', 'Gomez'),
(4, 'JuanGaezDT', 'Juan', 'Garcia', 'Pomez');

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
  `MT` int(11) NOT NULL,
  `MSMS` int(11) NOT NULL,
  `T2A` int(11) NOT NULL,
  `T2F` int(11) NOT NULL,
  `T3A` int(11) NOT NULL,
  `T3F` int(11) NOT NULL,
  `TLA` int(11) NOT NULL,
  `TLF` int(11) NOT NULL,
  `FLH` int(11) NOT NULL,
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

INSERT INTO `equipos` (`id`, `id_equipo`, `categoria`, `nombre_equipo`, `seccion`, `letra`, `PJ`, `W`, `L`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Nacional', 'Liceo Frances Nacional Masculino', 'Masculino', NULL, 5, 0, 4, 0, 0, 90, 10, 10, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Sub22Femenino', 'Sub22', 'Liceo Frances Sub22 Femenino', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 'Pedro', 'Pedro', 'Martinez', 'Fernandez', 1, 7, 66, 11, 0, 26, 9, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0),
(2, 'JuanPe', 'Juan ', 'Pérez', 'García', 2, 7, 66, 11, 0, 26, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0),
(3, 'PaGar3', 'Pablo ', 'Alonso ', 'García', 3, 7, 66, 11, 0, 26, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0),
(4, 'JBruq', 'Javier', 'Bru', 'Querol', 4, 7, 66, 11, 0, 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'PaGCV', 'Pablo Gregorio', 'Carrasco', 'Villacastin', 5, 7, 66, 11, 0, 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'DavidC', 'David', 'Casillas', 'Pirajno', 6, 7, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'PabEG', 'Pablo', 'Esteban', 'Gonzalez', 7, 7, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Manull', 'Manuel', 'Martinez', 'Llimona', 8, 7, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'Ikermc', 'Iker', 'Mateo', 'Castaño', 9, 7, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'Linomf', 'Lino', 'Monteagudo', 'Fuentes', 10, 5, 0, 0, 9, 0, 5, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Beltmn', 'Beltrán', 'Moraleda', 'Navarro', 11, 5, 0, 0, 9, 0, 4, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'AlbertoST', 'Alberto', 'Sanz', 'Toril', 12, 2, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'JoacoY', 'Joaquín', 'Yañez', 'Saz', 13, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'JoseluS', 'Juan Luis', 'Saez-Benito', 'Torquemada', 14, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'Jongil', 'Jaime', 'Ongil', 'Fernandez', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'Mariogl', 'Mario', 'Gómez', 'López', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(21, 'NacionalMasculino', 'TresCantosNacional', '2023-07-25', '11:05:00', NULL),
(24, 'NacionalMasculino', 'VeritasPozuelo', '2023-07-30', '12:53:00', NULL),
(25, 'NacionalMasculino', 'AlcorconBasket', '2023-07-06', '13:48:00', NULL),
(28, 'NacionalMasculino', 'UrosdeRivas', '2023-08-09', '10:16:00', NULL),
(29, 'NacionalMasculino', 'CBLR', '2023-08-04', '11:32:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido`
--

CREATE TABLE `tmp_partido` (
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
-- Volcado de datos para la tabla `tmp_partido`
--

INSERT INTO `tmp_partido` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'CBLR', 'LuisAngel', 'LuisAngel', 18, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'CBLR', 'Agustinio', 'Agustinio', 4, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'CBLR', 'Fernando', 'Fernando', 5, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'CBLR', 'Mariote', 'Mariote', 7, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'CBLR', 'JuanPablo', 'JuanPablo', 8, 1, 1, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'CBLR', 'Lucas', 'Lucas', 57, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'CBLR', 'Martín', 'Martín', 68, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'CBLR', 'Lolo', 'Lolo', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'CBLR', 'Martino', 'Martino', 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'CBLR', 'Diawara', 'Diawara', 67, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'CBLR', 'JuanPedrito', 'JuanPedrito', 95, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'CBLR', 'Guillermin', 'Guillermin', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe`
--

CREATE TABLE `tmp_partidoe` (
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
-- Volcado de datos para la tabla `tmp_partidoe`
--

INSERT INTO `tmp_partidoe` (`id`, `equipo`, `lider`, `empate`, `timeouts`, `faltasbanquillo`, `alternancias`, `vecesempatados`, `veceslider`, `parcial_lastto`, `parcial_lastchange`, `parcial`, `mayorventaja`, `tiempolider`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'CBLR', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_24`
--

CREATE TABLE `tmp_partidoe_24` (
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
  `parcial_lastto` int(11) DEFAULT 0,
  `parcial_lastchange` int(11) DEFAULT 0,
  `parcial` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partidoe_24`
--

INSERT INTO `tmp_partidoe_24` (`id`, `equipo`, `timeouts`, `faltasbanquillo`, `puntos`, `lider`, `empate`, `alternancias`, `vecesempatados`, `veceslider`, `q1`, `q2`, `q3`, `q4`, `extra`, `parcial_lastto`, `parcial_lastchange`, `parcial`) VALUES
(1, 'NacionalMasculino', 3, 0, 2, 1, 0, 1, 0, 1, 2, 0, 0, 0, 0, 0, 0, 4),
(2, 'VeritasPozuelo', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_25`
--

CREATE TABLE `tmp_partidoe_25` (
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
  `parcial_lastto` int(11) DEFAULT 0,
  `parcial_lastchange` int(11) DEFAULT 0,
  `parcial` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partidoe_25`
--

INSERT INTO `tmp_partidoe_25` (`id`, `equipo`, `timeouts`, `faltasbanquillo`, `puntos`, `lider`, `empate`, `alternancias`, `vecesempatados`, `veceslider`, `q1`, `q2`, `q3`, `q4`, `extra`, `parcial_lastto`, `parcial_lastchange`, `parcial`) VALUES
(1, 'NacionalMasculino', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'AlcorconBasket', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partidoe_28`
--

CREATE TABLE `tmp_partidoe_28` (
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
-- Volcado de datos para la tabla `tmp_partidoe_28`
--

INSERT INTO `tmp_partidoe_28` (`id`, `equipo`, `lider`, `empate`, `timeouts`, `faltasbanquillo`, `alternancias`, `vecesempatados`, `veceslider`, `parcial_lastto`, `parcial_lastchange`, `parcial`, `mayorventaja`, `tiempolider`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 1, 0, 1, 0, 1, 0, 1, 2, 2, 9, 9, 0, 9, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0),
(2, 'UrosdeRivas', 0, 0, 0, 0, 1, 0, 0, 0, 0, -9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_21`
--

CREATE TABLE `tmp_partido_21` (
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
  `PTQ1` int(11) NOT NULL,
  `PTQ2` int(11) NOT NULL,
  `PTQ3` int(11) NOT NULL,
  `PTQ4` int(11) NOT NULL,
  `PTQE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partido_21`
--

INSERT INTO `tmp_partido_21` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 18, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 18, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 18, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 18, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 18, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'NacionalMasculino', 'Linomf', 'Lino Monteagudo Fuentes', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'NacionalMasculino', 'Beltmn', 'Beltrán Moraleda Navarro', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'NacionalMasculino', 'JoacoY', 'Joaquín Yañez Saz', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'TresCantosNacional', 'Juanpedro', 'Juanpedro', 1, 1, 1, 18, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'TresCantosNacional', 'Pablo', 'Pablo', 2, 1, 1, 18, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'TresCantosNacional', 'Pedrote', 'Pedrote', 3, 1, 1, 18, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'TresCantosNacional', 'Juan', 'Juan', 4, 1, 1, 18, -2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'TresCantosNacional', 'Manolo', 'Manolo', 5, 1, 1, 18, -2, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'TresCantosNacional', 'Lucas', 'Lucas', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'TresCantosNacional', 'Martín', 'Martín', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'TresCantosNacional', 'Isaca', 'Isaca', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'TresCantosNacional', 'Webo', 'Webo', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'TresCantosNacional', 'Malin', 'Malin', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'TresCantosNacional', 'Pablote', 'Pablote', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'TresCantosNacional', 'Gonzalo', 'Gonzalo', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_24`
--

CREATE TABLE `tmp_partido_24` (
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
  `PTQ1` int(11) NOT NULL,
  `PTQ2` int(11) NOT NULL,
  `PTQ3` int(11) NOT NULL,
  `PTQ4` int(11) NOT NULL,
  `PTQE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partido_24`
--

INSERT INTO `tmp_partido_24` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 0, 14, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 0, 14, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 0, 14, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 0, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 0, 14, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'NacionalMasculino', 'Linomf', 'Lino Monteagudo Fuentes', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'NacionalMasculino', 'Beltmn', 'Beltrán Moraleda Navarro', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'NacionalMasculino', 'AlbertoST', 'Alberto Sanz Toril', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'VeritasPozuelo', 'LuisAngel', 'LuisAngel', 18, 1, 1, 0, -14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'VeritasPozuelo', 'Agustinio', 'Agustinio', 4, 1, 1, 0, -14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'VeritasPozuelo', 'Fernando', 'Fernando', 5, 1, 1, 0, -14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'VeritasPozuelo', 'Mariote', 'Mariote', 7, 1, 1, 0, -14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'VeritasPozuelo', 'JuanPablo', 'JuanPablo', 8, 1, 1, 0, -14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'VeritasPozuelo', 'Lucas', 'Lucas', 87, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'VeritasPozuelo', 'Martín', 'Martín', 68, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'VeritasPozuelo', 'Lolo', 'Lolo', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'VeritasPozuelo', 'Martino', 'Martino', 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'VeritasPozuelo', 'Diawara', 'Diawara', 67, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'VeritasPozuelo', 'JuanPedrito', 'JuanPedrito', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'VeritasPozuelo', 'Guillermin', 'Guillermin', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_25`
--

CREATE TABLE `tmp_partido_25` (
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
  `PTQ1` int(11) NOT NULL,
  `PTQ2` int(11) NOT NULL,
  `PTQ3` int(11) NOT NULL,
  `PTQ4` int(11) NOT NULL,
  `PTQE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmp_partido_25`
--

INSERT INTO `tmp_partido_25` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'AlcorconBasket', 'LuisAngel', 'LuisAngel', 18, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'AlcorconBasket', 'Federico', 'Federico', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'AlcorconBasket', 'Pedrote', 'Pedrote', 3, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'AlcorconBasket', 'Mariote', 'Mariote', 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'AlcorconBasket', 'JuanPablo', 'JuanPablo', 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'AlcorconBasket', 'Lucas', 'Lucas', 57, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'AlcorconBasket', 'Martín', 'Martín', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'AlcorconBasket', 'Lolo', 'Lolo', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'AlcorconBasket', 'Webo', 'Webo', 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp_partido_28`
--

CREATE TABLE `tmp_partido_28` (
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
-- Volcado de datos para la tabla `tmp_partido_28`
--

INSERT INTO `tmp_partido_28` (`id`, `equipo`, `jugador`, `nombrejugador`, `numero`, `titular`, `en_juego`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `TEC`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculino', 'Pedro', 'Pedro Martinez Fernandez', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0),
(2, 'NacionalMasculino', 'JuanPe', 'Juan  Pérez García', 2, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0, 0),
(3, 'NacionalMasculino', 'PaGar3', 'Pablo  Alonso  García', 3, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0),
(4, 'NacionalMasculino', 'JBruq', 'Javier Bru Querol', 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'NacionalMasculino', 'PaGCV', 'Pablo Gregorio Carrasco Villacastin', 5, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'NacionalMasculino', 'DavidC', 'David Casillas Pirajno', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'NacionalMasculino', 'PabEG', 'Pablo Esteban Gonzalez', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'NacionalMasculino', 'Manull', 'Manuel Martinez Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'NacionalMasculino', 'Ikermc', 'Iker Mateo Castaño', 9, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'NacionalMasculino', 'Linomf', 'Lino Monteagudo Fuentes', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'NacionalMasculino', 'Beltmn', 'Beltrán Moraleda Navarro', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'NacionalMasculino', 'AlbertoST', 'Alberto Sanz Toril', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'UrosdeRivas', 'LuisAngel', 'LuisAngel', 18, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'UrosdeRivas', 'Agustinio', 'Agustinio', 4, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'UrosdeRivas', 'Pedrote', 'Pedrote', 5, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'UrosdeRivas', 'Mariote', 'Mariote', 7, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'UrosdeRivas', 'JuanPablo', 'JuanPablo', 8, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'UrosdeRivas', 'Lucas', 'Lucas', 87, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'UrosdeRivas', 'Martín', 'Martín', 68, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'UrosdeRivas', 'Lolo', 'Lolo', 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'UrosdeRivas', 'Martino', 'Martino', 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'UrosdeRivas', 'Diawara', 'Diawara', 67, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'UrosdeRivas', 'JuanPedrito', 'JuanPedrito', 95, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'UrosdeRivas', 'Guillermin', 'Guillermin', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(18, 1, 19),
(21, 1, 22),
(22, 2, 22);

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
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido`
--
ALTER TABLE `tmp_partido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe`
--
ALTER TABLE `tmp_partidoe`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe_21`
--
ALTER TABLE `tmp_partidoe_21`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe_24`
--
ALTER TABLE `tmp_partidoe_24`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe_25`
--
ALTER TABLE `tmp_partidoe_25`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partidoe_28`
--
ALTER TABLE `tmp_partidoe_28`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_21`
--
ALTER TABLE `tmp_partido_21`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_24`
--
ALTER TABLE `tmp_partido_24`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_25`
--
ALTER TABLE `tmp_partido_25`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tmp_partido_28`
--
ALTER TABLE `tmp_partido_28`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_fk` (`equipo_id`),
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tmp_partido`
--
ALTER TABLE `tmp_partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe`
--
ALTER TABLE `tmp_partidoe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_21`
--
ALTER TABLE `tmp_partidoe_21`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_24`
--
ALTER TABLE `tmp_partidoe_24`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_25`
--
ALTER TABLE `tmp_partidoe_25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partidoe_28`
--
ALTER TABLE `tmp_partidoe_28`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_21`
--
ALTER TABLE `tmp_partido_21`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_24`
--
ALTER TABLE `tmp_partido_24`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_25`
--
ALTER TABLE `tmp_partido_25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tmp_partido_28`
--
ALTER TABLE `tmp_partido_28`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD CONSTRAINT `equipo_fk` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`usuario_id`) REFERENCES `credenciales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
