-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2023 a las 19:59:22
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

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
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `user`, `password`) VALUES
(1, 'Pedro', '12345'),
(2, 'JuanPe', '12345'),
(3, 'PaGar3', '12345'),
(4, 'JBruq', '12345'),
(5, 'PaGCV', '12345'),
(6, 'DavidC', '12345'),
(7, 'PabEG', '12345'),
(8, 'Manull', '12345'),
(9, 'Ikermc', '12345'),
(10, 'Linomf', '12345'),
(11, 'Beltmn', '12345'),
(12, 'AlbertoST', '12345'),
(13, 'JoacoY', '12345'),
(14, 'JoseluS', '12345'),
(15, 'Jongil', '12345'),
(16, 'Mariogl', '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(10) NOT NULL,
  `id_equipo` varchar(50) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  `seccion` enum('Masculino','Femenino') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `id_equipo`, `categoria`, `nombre_equipo`, `seccion`) VALUES
(1, 'NacMasc', 'Nacional', 'Liceo Nacional Masculino', 'Masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `numero` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `nombre`, `apellido1`, `apellido2`, `numero`) VALUES
(1, 'Pedro', 'Pedro', 'Martinez', 'Fernandez', 1),
(2, 'JuanPe', 'Juan ', 'Pérez', 'García', 2),
(3, 'PaGar3', 'Pablo ', 'Alonso ', 'García', 3),
(4, 'JBruq', 'Javier', 'Bru', 'Querol', 4),
(5, 'PaGCV', 'Pablo Gregorio', 'Carrasco', 'Villacastin', 5),
(6, 'DavidC', 'David', 'Casillas', 'Pirajno', 6),
(7, 'PabEG', 'Pablo', 'Esteban', 'Gonzalez', 7),
(8, 'Manull', 'Manuel', 'Martinez', 'Llimona', 8),
(9, 'Ikermc', 'Iker', 'Mateo', 'Castaño', 9),
(10, 'Linomf', 'Lino', 'Monteagudo', 'Fuentes', 10),
(11, 'Beltmn', 'Beltrán', 'Moraleda', 'Navarro', 11),
(12, 'AlbertoST', 'Alberto', 'Sanz', 'Toril', 12),
(13, 'JoacoY', 'Joaquín', 'Yañez', 'Saz', 13),
(14, 'JoseluS', 'Juan Luis', 'Saez-Benito', 'Torquemada', 14),
(15, 'Jongil', 'Jaime', 'Ongil', 'Fernandez', 15),
(16, 'Mariogl', 'Mario', 'Gómez', 'López', 16);

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
(16, 1, 16);

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
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_equipo` (`id_equipo`),
  ADD UNIQUE KEY `nombre_equipo` (`nombre_equipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`user`) REFERENCES `credenciales` (`user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_equipos`
--
ALTER TABLE `usuarios_equipos`
  ADD CONSTRAINT `equipo_fk` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
