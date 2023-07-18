-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2023 a las 18:12:28
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
  `rol` set('E','J','D','A') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `user`, `password`, `rol`) VALUES
(1, 'Pedro', '12345', 'J'),
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
(17, 'GonzaloG', '12345', 'E');

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
(1, 'GonzaloG', 'Gonzalo', 'García', 'Gómez');

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
  `letra` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `id_equipo`, `categoria`, `nombre_equipo`, `seccion`, `letra`) VALUES
(1, 'NacionalMasculino', 'Nacional', 'Liceo Frances Nacional Masculino', 'Masculino', NULL);

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
  `RBO` int(5) NOT NULL,
  `RBD` int(5) NOT NULL,
  `ROB` int(5) NOT NULL,
  `TAP` int(5) NOT NULL,
  `PRD` int(5) NOT NULL,
  `AST` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `user`, `nombre`, `apellido1`, `apellido2`, `numero`, `PJ`, `MT`, `TIT`, `SUP`, `MSMS`, `T2A`, `T2F`, `T3A`, `T3F`, `TLA`, `TLF`, `FLH`, `FLR`, `RBO`, `RBD`, `ROB`, `TAP`, `PRD`, `AST`) VALUES
(1, 'Pedro', 'Pedro', 'Martinez', 'Fernandez', 1, 2, 48, 6, 0, 12, 6, 5, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'JuanPe', 'Juan ', 'Pérez', 'García', 2, 2, 48, 6, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'PaGar3', 'Pablo ', 'Alonso ', 'García', 3, 2, 48, 6, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'JBruq', 'Javier', 'Bru', 'Querol', 4, 2, 48, 6, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'PaGCV', 'Pablo Gregorio', 'Carrasco', 'Villacastin', 5, 2, 48, 6, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'DavidC', 'David', 'Casillas', 'Pirajno', 6, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'PabEG', 'Pablo', 'Esteban', 'Gonzalez', 7, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Manull', 'Manuel', 'Martinez', 'Llimona', 8, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'Ikermc', 'Iker', 'Mateo', 'Castaño', 9, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'Linomf', 'Lino', 'Monteagudo', 'Fuentes', 10, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Beltmn', 'Beltrán', 'Moraleda', 'Navarro', 11, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 'AlbertoST', 'Alberto', 'Sanz', 'Toril', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 'JoacoY', 'Joaquín', 'Yañez', 'Saz', 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 'JoseluS', 'Juan Luis', 'Saez-Benito', 'Torquemada', 14, 2, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 'Jongil', 'Jaime', 'Ongil', 'Fernandez', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 'Mariogl', 'Mario', 'Gómez', 'López', 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int(11) NOT NULL,
  `local` varchar(50) NOT NULL,
  `visitante` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `local`, `visitante`, `fecha`, `hora`) VALUES
(20, 'NacMasc', 'TresCantosNacional', '2023-07-06', '18:42:00');

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
(17, 1, 17);

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
-- Indices de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`),
  ADD KEY `equipo_fk` (`equipo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
