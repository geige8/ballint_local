-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2023 a las 22:45:57
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
(1, 'admin', '$2y$10$agS4H2gHlgMS9In9sO9oNudEYnndmCssEQXIOt2lUtBc3croIn5M.', 'A'),
(2, 'AlbertoGzE737', '$2y$10$Qv1hiUbjoiKNUOQNALPLc.l7Wg4jtuAFKkiE9aTLAiMZWc.1A9mte', 'E'),
(3, 'SergioNzE1200', '$2y$10$1WVRQxjNmDN7Z6sWbN44w.LoUOlDWRuiCopW69y8K9u23F3rJ234O', 'E'),
(4, 'VictorGeE267', '$2y$10$w8NNhMlzzM..gIoFOk9eOunRQdrg2ZMxZoIxE70Ksb36rlfo7TFDC', 'E'),
(5, 'MartaCzE285', '$2y$10$2LB/Ug9huWrOs1BPC8kSe.fvnu0XVZN53dx.ymqxVcgpJr0RJoyq.', 'E'),
(6, 'GonzaloGzE488', '$2y$10$JVoKmATFs/HJx.vMl1B2sO.KBC0ncHx0/1piIO/vofwEfw2Wfwwqu', 'E'),
(7, 'AlejandraMzE11', '$2y$10$ocERRVYTmy0VtMmJ5bmI7.vcrUMH5kes4jUdUW9TMm39LuF0KF4kG', 'E'),
(8, 'RafaelNnDT225', '$2y$10$6iux.Dc1.eztc9FmFWO0YuaF1gNNBDql8Dt03pz5cH6SpjDyyZLDe', 'DT'),
(9, 'PabloEzDT546', '$2y$10$iowUvqra/si3fOW0xZcRPOqI8BIqkJYWND1/u16WycJTKsPt.BGKG', 'DT'),
(10, 'JavierBlJ399', '$2y$10$7s9IAjZp3umbGM0Tgnpjou5AZxY0cgf4FRcH7tJx04blviIwKgMNq', 'J'),
(11, 'ManuelMaJ704', '$2y$10$e4yliopyhmw88KiR04DFfObQaYR/5Beo560epMh/YrexAPd1Bqhoi', 'J'),
(12, 'PabloEzJ650', '$2y$10$DnaW7ddVo0UerwBREYKnDe8xGSzZgn5ycK.4M0RB1sRSLrBujgGXe', 'J'),
(13, 'DavidCoJ1763', '$2y$10$DnSQvY2QevwWP8O.Mvn8gerYf02hyXeU7jHt8RCXj55HRNaVFbpkm', 'J'),
(14, 'JoaquinYzJ3432', '$2y$10$uzN0lDbxKi/MNplGKDZMU.TvUjbOZ.1BUPJ7l44TncRsqTkQSI4RG', 'J'),
(15, 'BeltranMoJ700', '$2y$10$4HWyL44K8S/J19wlYGN6SubBTNO35oap4uCG00sqQcNE7V7ITfLj.', 'J'),
(16, 'AlvaroSlJ5208', '$2y$10$IdOs54j98gCBo5fsJoB/yurkzwGxCvWbM1RYb45RPIAzVgiZa.4UW', 'J'),
(17, 'PabloCoJ4118', '$2y$10$r89PbGq.ld4Sw4I9DWSDY.hz6N29GmfLbZ78FAPINPID.9GYyWTAq', 'J'),
(18, 'IkerMoJ4774', '$2y$10$JT1W1R7fDHJ/lKwh0XEVDuySkUpaah2EeNHL3cKOSwT0HhXbT5zue', 'J'),
(19, 'PabloAaJ2184', '$2y$10$hxZ.cm/YK0gLCwQO/ET..eyJj.lqETbBPYZgHRoU4ZLAMAPTUyg3i', 'J'),
(20, 'RobertoSaJ28', '$2y$10$B99dp0WaQXqi2d8Ezk9HXeFyRxF9g4AiqoBxDaaoQka3kEov8lqYK', 'J'),
(21, 'JavierLoJ128', '$2y$10$JL6uXZNw1R9irZIkr3CC7e8y1wcW8itc10jSSFAvQBifgD6JMWnD2', 'J'),
(22, 'CarlosDnJ60', '$2y$10$5VInytNcdn4aVZLWlPNXG.Hl9oFiv9GVHDYpAaQeXMKP.j5FBCEkW', 'J'),
(23, 'JoseRaJ406', '$2y$10$fBNvMu0VhvJ6VMpLKGB94ebwVzSiVYaUujrWtAif/hSTCnmP3VqhW', 'J'),
(24, 'MarioBsJ442', '$2y$10$rvCvFBMltjM3ePnARtq2dOMydoKdsaBiekpzTF53QR/ksA3AUgwEK', 'J'),
(25, 'AlvaroMzJ660', '$2y$10$kVWw4bZgA1ZtBdBeketTNu7KcdcYubHtiD.Y87FSqhfu71yqIFG0m', 'J'),
(26, 'MarioGzJ1344', '$2y$10$sDx6hNnxQYuhB3L8l7KNnehiu0dIc9m/SwKS7mlFbYgLv7QMvrTVm', 'J'),
(27, 'JosueRzJ1140', '$2y$10$KNcSUprXy3hNeyS5Z02DOekDSjjYiYt7pr5yyL1GIF2SbwbJpkIkG', 'J'),
(28, 'JesusAzJ5472', '$2y$10$w86Mf7s1E5UUZVT8sJhMY.i7JYml4z/fQdek/C63yElRbjafLY0cm', 'J'),
(29, 'JaimeOzJ1860', '$2y$10$Q.FEziKjjtQ8fMdAw9o.puvbStn2t473/OUuRi/kbDDKfD5VHPLNC', 'J'),
(30, 'PaulaCaJ5', '$2y$10$08/ENNMcXHFojrQp.bfdZ.LEtyMrVL73xqH/AiduA8QhVPtQSK4Q2', 'J'),
(31, 'RocioSoJ248', '$2y$10$uqmIGvcZW.gCtOMC19i6uenVfFnc67odXBOkUHcwzI0UzU8vKo1PG', 'J'),
(32, 'LauraOaJ80', '$2y$10$8NWkO3vSFt3V7dQauHNq9uwnnYMZfzu4gYPLmrwy2t5dTX2ReNR/K', 'J'),
(33, 'ElenaSaJ792', '$2y$10$pdER5fMtYH1OES4F23.1Ve3h9nv1a3UUNjgRSkVGeje0NKTIsKVTi', 'J'),
(34, 'BlancaZeJ1066', '$2y$10$z9vd8Gcz9rWdWS2mvN0dM.WUebqn1128lIpZ4O9ug6yWtPIIAJcny', 'J'),
(35, 'BelenSoJ60', '$2y$10$yswcVFbIqrOXShhtuf9cS..9x2HVIKeHxBwhkwyL7OEji8IIjNTrO', 'J'),
(36, 'LuciaOzJ220', '$2y$10$g6iPwHk0QME6G3GAfV91iuiR4gnD3Qgia3HoSjsHl5wlFARPcQNvq', 'J'),
(37, 'SilviaCoJ858', '$2y$10$5pid89jn64D2dWcJV8WYNevA8MDxzmtPioRGaWmpFORzrvIhRKKZq', 'J'),
(38, 'EsterRzJ2700', '$2y$10$UFKMfKXeoHRFyEJBdJq0T.4iAA3MsbKPsMYcmuGA48ZdH3xyi85uW', 'J'),
(39, 'AlbaJsJ7296', '$2y$10$xN/Iq5rflfpnI/nSps63N.Q6ZdwvJoPlg/07R7bMURBjRvU.i8FOK', 'J'),
(40, 'AlejandraMoJ84', '$2y$10$ic.zk8cbtVv0Kishft4..OmyraxMUAqrucT37zu.jxmb7wtknzMy6', 'J'),
(41, 'LunaVzJ485', '$2y$10$LFXEkwoHmZ8tRsSrlCsAKOVdaXhqcn83DmAVZCfaXNF3FT.YaZRa2', 'J'),
(42, 'SofiaMlJ476', '$2y$10$iUmeR6ieA5wdY5T5utveeOQLYjaua/7SYNIDTRzvvNQzxyVc8/zg.', 'J'),
(43, 'AnaMoJ240', '$2y$10$9ruDnQN5cHuTsw3rmfmuaOLqc9zeJ8jzGJhaK.KKA/r3nYMJIdOja', 'J'),
(44, 'AnaGzJ279', '$2y$10$E8f5lY7tWZQsJPnO5tHwQ.iXTu5qAFN0EX8PGVhW/e7VIHCQHwVVm', 'J'),
(45, 'AlejandraBoJ1330', '$2y$10$uoKgY7aOwrv4UffZ0aXiDudIuxResYd3wJU4kTdA5rnMavso1Rh3.', 'J'),
(46, 'MargotMlJ1463', '$2y$10$oCsqj3XGMEtwspYQ5LZkU.x7wefWPfQCWKFWzBEYjP2kbAl40mgjW', 'J'),
(47, 'CarlotaVlJ1953', '$2y$10$eUNUNSmi8vTx.ENZ1l/W2OKFmlHVrRS2TlZh/Vfz99Ur9UtyX95NW', 'J'),
(48, 'CamilleCnJ220', '$2y$10$dCsx0fFoMy3vl9Migg7tteWro4/qjg8sdWeazFjuk7Mhhy/asrUYO', 'J'),
(49, 'ClaudiaAaJ2340', '$2y$10$CKGtMk6FDkTxIRdUkkqA3eExsxp2hAkEAbQlnMAZ4iTnK3QwTa98u', 'J');

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
(1, 'RafaelNnDT225', 'Rafael', 'Navarro', 'Barragan'),
(2, 'PabloEzDT546', 'Pablo', 'Esteban', 'Fernandez');

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
(1, 'AlbertoGzE737', 'Alberto', 'Garrido', 'Alvarez'),
(2, 'SergioNzE1200', 'Sergio', 'Navas', 'Lopez'),
(3, 'VictorGeE267', 'Victor', 'Gomez', 'Marchate'),
(4, 'MartaCzE285', 'Marta', 'Calvo', 'Fernandez'),
(5, 'GonzaloGzE488', 'Gonzalo', 'Garcia', 'Gomez'),
(6, 'AlejandraMzE11', 'Alejandra', 'Moraes', 'Gomez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(10) NOT NULL,
  `id_equipo` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
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

INSERT INTO `equipos` (`id`, `id_equipo`, `categoria`, `seccion`, `letra`, `PJ`, `W`, `L`, `PPP`, `PPR`, `MT`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `TEC`, `FLR`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`, `PTQ1`, `PTQ2`, `PTQ3`, `PTQ4`, `PTQE`) VALUES
(1, 'NacionalMasculinoA', 'Nacional', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'NacionalFemeninoA', 'Nacional', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'PrimeraAutonomicaMasculinoA', 'PrimeraAutonomica', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'PrimeraAutonomicaFemeninoA', 'PrimeraAutonomica', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'SegundaAutonomicaFemeninoA', 'SegundaAutonomica', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Sub22FemeninoA', 'Sub22', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'Sub22MasculinoA', 'Sub22', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Sub22MasculinoB', 'Sub22', 'Masculino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'Sub22MasculinoC', 'Sub22', 'Masculino', 'C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'JuniorFemeninoA', 'Junior', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'JuniorFemeninoB', 'Junior', 'Femenino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'JuniorMasculinoA', 'Junior', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'JuniorMasculinoB', 'Junior', 'Masculino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'CadeteFemeninoA', 'Cadete', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'CadeteFemeninoB', 'Cadete', 'Femenino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'CadeteFemeninoC', 'Cadete', 'Femenino', 'C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'CadeteMasculinoA', 'Cadete', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'CadeteMasculinoB', 'Cadete', 'Masculino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'CadeteMasculinoC', 'Cadete', 'Masculino', 'C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'CadeteMasculinoD', 'Cadete', 'Masculino', 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'InfantilMasculinoA', 'Infantil', 'Masculino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'InfantilMasculinoB', 'Infantil', 'Masculino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'InfantilMasculinoC', 'Infantil', 'Masculino', 'C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'InfantilMasculinoD', 'Infantil', 'Masculino', 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(25, 'InfantilFemeninoA', 'Infantil', 'Femenino', 'A', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 'InfantilFemeninoB', 'Infantil', 'Femenino', 'B', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, 'InfantilFemeninoC', 'Infantil', 'Femenino', 'C', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 'JavierBlJ399', 'Javier', 'Bru', 'Querol', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'ManuelMaJ704', 'Manuel', 'Martinez', 'Llimona', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'PabloEzJ650', 'Pablo', 'Esteban', 'Gonzalez', 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'DavidCoJ1763', 'David', 'Casillas', 'Pirajno', 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'JoaquinYzJ3432', 'Joaquin', 'Yañez', 'Saz', 44, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'BeltranMoJ700', 'Beltran', 'Moraleda', 'Navarro', 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'AlvaroSlJ5208', 'Alvaro', 'Sanz', 'Toril', 62, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'PabloCoJ4118', 'Pablo', 'Carrasco', 'Villano', 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'IkerMoJ4774', 'Iker', 'Mateo', 'Castaño', 77, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'PabloAaJ2184', 'Pablo', 'Alonso', 'Garcia', 84, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'RobertoSaJ28', 'Roberto', 'Suarez', 'Moreda', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'JavierLoJ128', 'Javier', 'Lopez', 'Prieto', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'CarlosDnJ60', 'Carlos', 'Diez', 'Martin', 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'JoseRaJ406', 'Jose', 'Rojas', 'Padilla', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'MarioBsJ442', 'Mario', 'Ballesteros', 'Campos', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'AlvaroMzJ660', 'Alvaro', 'Moran', 'Lopez', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 'MarioGzJ1344', 'Mario', 'Gomez', 'Lopez', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'JosueRzJ1140', 'Josue', 'Reyes', 'Gonzalez', 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'JesusAzJ5472', 'Jesus', 'Alvarez', 'Fernandez', 57, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 'JaimeOzJ1860', 'Jaime', 'Ongil', 'Fernandez', 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 'PaulaCaJ5', 'Paula', 'Crecis', 'Molina', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 'RocioSoJ248', 'Rocio', 'Sanchez', 'Orduño', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 'LauraOaJ80', 'Laura', 'Ortea', 'Valera', 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 'ElenaSaJ792', 'Elena', 'Sesma', 'Garcia', 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(25, 'BlancaZeJ1066', 'Blanca', 'Zumarraga', 'Argente', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 'BelenSoJ60', 'Belen', 'Sanchez', 'Campillo', 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, 'LuciaOzJ220', 'Lucia', 'Ongil', 'Fernandez', 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(28, 'SilviaCoJ858', 'Silvia', 'Cortes', 'Blanco', 38, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(29, 'EsterRzJ2700', 'Ester', 'Redondo', 'Sanchez', 74, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(30, 'AlbaJsJ7296', 'Alba', 'Jimenez', 'Visus', 95, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(31, 'AlejandraMoJ84', 'Alejandra', 'Moraes', 'Barrio', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 'LunaVzJ485', 'Luna', 'Valero', 'Fernandez', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(33, 'SofiaMlJ476', 'Sofia', 'Muñoz', 'Gazengel', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 'AnaMoJ240', 'Ana', 'Mica', 'Calvo', 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 'AnaGzJ279', 'Ana', 'Garcia', 'Hernangomez', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 'AlejandraBoJ1330', 'Alejandra', 'Ballester', 'Arnao', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 'MargotMlJ1463', 'Margot', 'Muñoz', 'Gazengel', 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 'CarlotaVlJ1953', 'Carlota', 'Vaquero', 'Real', 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(39, 'CamilleCnJ220', 'Camille', 'Cebrian', 'Roldan', 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(40, 'ClaudiaAaJ2340', 'Claudia', 'Antona', 'Presa', 35, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 1, 2),
(5, 2, 3),
(2, 4, 3),
(3, 2, 4),
(6, 1, 5),
(4, 3, 5),
(7, 3, 6),
(8, 4, 7),
(9, 1, 8),
(10, 2, 8),
(11, 3, 8),
(12, 4, 8),
(13, 5, 8),
(14, 6, 8),
(15, 7, 8),
(16, 8, 8),
(17, 9, 8),
(18, 10, 8),
(19, 11, 8),
(20, 12, 8),
(21, 13, 8),
(22, 14, 8),
(23, 15, 8),
(24, 16, 8),
(25, 17, 8),
(26, 18, 8),
(27, 19, 8),
(28, 20, 8),
(29, 21, 8),
(30, 22, 8),
(31, 23, 8),
(32, 24, 8),
(33, 25, 8),
(34, 26, 8),
(35, 27, 8),
(36, 1, 9),
(37, 2, 9),
(38, 3, 9),
(39, 4, 9),
(40, 5, 9),
(41, 6, 9),
(42, 7, 9),
(43, 8, 9),
(44, 9, 9),
(45, 10, 9),
(46, 11, 9),
(47, 12, 9),
(48, 13, 9),
(49, 14, 9),
(50, 15, 9),
(51, 16, 9),
(52, 17, 9),
(53, 18, 9),
(54, 19, 9),
(55, 20, 9),
(56, 21, 9),
(57, 22, 9),
(58, 23, 9),
(59, 24, 9),
(60, 25, 9),
(61, 26, 9),
(62, 27, 9),
(63, 1, 10),
(64, 1, 11),
(65, 1, 12),
(66, 1, 13),
(67, 1, 14),
(68, 1, 15),
(69, 1, 16),
(70, 1, 17),
(71, 1, 18),
(72, 1, 19),
(73, 3, 20),
(75, 1, 21),
(74, 3, 21),
(76, 3, 22),
(77, 3, 23),
(78, 3, 24),
(79, 3, 25),
(82, 1, 26),
(80, 3, 26),
(81, 3, 27),
(83, 3, 28),
(84, 3, 29),
(85, 2, 30),
(86, 2, 31),
(87, 2, 32),
(88, 2, 33),
(89, 2, 34),
(90, 2, 35),
(91, 2, 36),
(92, 2, 37),
(93, 2, 38),
(94, 2, 39),
(96, 2, 40),
(95, 4, 40),
(97, 4, 41),
(99, 2, 42),
(98, 4, 42),
(100, 4, 43),
(101, 4, 44),
(102, 4, 45),
(103, 4, 46),
(104, 4, 47),
(105, 4, 48),
(106, 4, 49);

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
  ADD UNIQUE KEY `id_equipo` (`id_equipo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `directorestecnicos`
--
ALTER TABLE `directorestecnicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

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
  ADD CONSTRAINT `equipo_id_fk` FOREIGN KEY (`local`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE;

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
