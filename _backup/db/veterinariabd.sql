-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2025 a las 17:00:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `veterinariabd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_Cliente` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Direccion` varchar(150) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Apellido`, `DNI`, `Telefono`, `Email`, `Direccion`, `Fecha_Nacimiento`, `ID_Usuario`) VALUES
(2, 'Test_cliente', 'Cliente', '12255688', '1578946538', 'cliente@cliente.com', 'Ayacucho 449', '2010-02-01', 8),
(4, 'Test_cliente-2', 'Cliente2', '0916729482', '01578946538', 'cliente2@cliente2.com', 'Ayacucho 449', '1984-02-20', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `ID_Detalle_Compra` int(11) NOT NULL,
  `ID_Compra` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `ID_Detalle_Venta` int(11) NOT NULL,
  `ID_Venta` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `ID_Empleado` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `Fecha_Nacimiento` date NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `Direccion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`ID_Empleado`, `Nombre`, `Apellido`, `DNI`, `Fecha_Nacimiento`, `Email`, `Telefono`, `ID_Usuario`, `Direccion`) VALUES
(1, 'Luis', 'Morocho', '94429778', '1982-05-29', 'lmorocho@gmail.com', '1160082041', 1, NULL),
(2, 'Mariano País', 'Garay', '29567456', '1980-11-25', 'mpgaray@gmail.com', '1133445566', 2, NULL),
(3, 'Ariel', 'Toneguzzi', '28456123', '1970-03-14', 'atoneguzzi@gmail.com', '1144556677', 3, NULL),
(4, 'Agustín', 'Arufe', '27894561', '1990-09-09', 'aarufe@gmail.com', '1155667788', 4, NULL),
(5, 'admin', 'admin_append', '13579135', '0000-00-00', 'admin@admin.com', '', 9, ''),
(9, 'Test_empleado', 'Empleado', '12345678', '2025-05-01', 'empleado@empleado.com', '43534775456', 7, 'Ayacucho 447');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_especialidad`
--

CREATE TABLE `empleado_especialidad` (
  `ID_ESP_EMP` int(11) NOT NULL,
  `ID_Empleado` int(11) NOT NULL,
  `ID_Especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `ID_Especialidad` int(11) NOT NULL,
  `Nombre_Especialidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie`
--

CREATE TABLE `especie` (
  `ID_Especie` int(11) NOT NULL,
  `Nombre_Especie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especie`
--

INSERT INTO `especie` (`ID_Especie`, `Nombre_Especie`) VALUES
(1, 'Perro'),
(2, 'Gato');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `ID_Mascota` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `ID_Raza` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`ID_Mascota`, `Nombre`, `Fecha_Nacimiento`, `ID_Raza`, `ID_Cliente`) VALUES
(5, 'pippo', '2022-01-02', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--

CREATE TABLE `precio` (
  `ID_Precio` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `ID_Proveedor` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) DEFAULT NULL,
  `Empresa` varchar(100) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `DNI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--

CREATE TABLE `raza` (
  `ID_Raza` int(11) NOT NULL,
  `Nombre_Raza` varchar(50) NOT NULL,
  `ID_Especie` int(11) NOT NULL,
  `Color` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `raza`
--

INSERT INTO `raza` (`ID_Raza`, `Nombre_Raza`, `ID_Especie`, `Color`) VALUES
(1, 'Labrador Retriever', 1, 'Dorado'),
(2, 'Bulldog Francés', 1, 'Blanco con negro'),
(3, 'Golden Retriever', 1, 'Dorado claro'),
(4, 'Pastor Alemán', 1, 'Negro y marrón'),
(5, 'Poodle', 1, 'Blanco'),
(6, 'Persa', 2, 'Blanco'),
(7, 'Siamés', 2, 'Beige con marrón'),
(8, 'Maine Coon', 2, 'Gris atigrado'),
(9, 'Bengala', 2, 'Moteado marrón y dorado'),
(10, 'Ragdoll', 2, 'Blanco con gris');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`ID_Rol`, `Nombre_Rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Cliente'),
(4, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `ID_Stock` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ID_Proveedor` int(11) NOT NULL,
  `ID_Precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `ID_Tipo_Producto` int(11) NOT NULL,
  `Nombre_Tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_turno`
--

CREATE TABLE `tipo_turno` (
  `ID_Tipo_Turno` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `ID_Turno` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `ID_Mascota` int(11) NOT NULL,
  `ID_Empleado` int(11) NOT NULL,
  `ID_Tipo_Turno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Password`, `ID_Rol`) VALUES
(1, 'lmorocho', '123', 1),
(2, 'mpgaray', '123', 1),
(3, 'atoneguzzi', '123', 1),
(4, 'aarufe', '123', 1),
(7, 'templeado', '123', 2),
(8, 'tcliente', '123', 3),
(9, 'admin', '123', 1),
(10, 't2cliente', '123', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `ID_Venta` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ID_Precio` int(11) NOT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_Cliente`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`),
  ADD UNIQUE KEY `DNI_2` (`DNI`),
  ADD KEY `Email` (`Email`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`ID_Detalle_Compra`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`ID_Detalle_Venta`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`ID_Empleado`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `Email` (`Email`);

--
-- Indices de la tabla `empleado_especialidad`
--
ALTER TABLE `empleado_especialidad`
  ADD PRIMARY KEY (`ID_ESP_EMP`),
  ADD KEY `ID_Empleado` (`ID_Empleado`),
  ADD KEY `ID_Especialidad` (`ID_Especialidad`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`ID_Especialidad`);

--
-- Indices de la tabla `especie`
--
ALTER TABLE `especie`
  ADD PRIMARY KEY (`ID_Especie`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`ID_Mascota`),
  ADD KEY `ID_Raza` (`ID_Raza`),
  ADD KEY `FK_Mascota_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `precio`
--
ALTER TABLE `precio`
  ADD PRIMARY KEY (`ID_Precio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`ID_Proveedor`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `Email` (`Email`);

--
-- Indices de la tabla `raza`
--
ALTER TABLE `raza`
  ADD PRIMARY KEY (`ID_Raza`),
  ADD KEY `ID_Especie` (`ID_Especie`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`ID_Rol`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ID_Stock`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`ID_Tipo_Producto`);

--
-- Indices de la tabla `tipo_turno`
--
ALTER TABLE `tipo_turno`
  ADD PRIMARY KEY (`ID_Tipo_Turno`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`ID_Turno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  ADD KEY `ID_Rol` (`ID_Rol`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`ID_Venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `ID_Detalle_Compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `ID_Detalle_Venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `ID_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empleado_especialidad`
--
ALTER TABLE `empleado_especialidad`
  MODIFY `ID_ESP_EMP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `ID_Especialidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especie`
--
ALTER TABLE `especie`
  MODIFY `ID_Especie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `ID_Mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `precio`
--
ALTER TABLE `precio`
  MODIFY `ID_Precio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `raza`
--
ALTER TABLE `raza`
  MODIFY `ID_Raza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `ID_Stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `ID_Tipo_Producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_turno`
--
ALTER TABLE `tipo_turno`
  MODIFY `ID_Tipo_Turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `ID_Turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `ID_Venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_Cliente_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_Empleado_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `empleado_especialidad`
--
ALTER TABLE `empleado_especialidad`
  ADD CONSTRAINT `empleado_especialidad_ibfk_1` FOREIGN KEY (`ID_Empleado`) REFERENCES `empleado` (`ID_Empleado`),
  ADD CONSTRAINT `empleado_especialidad_ibfk_2` FOREIGN KEY (`ID_Especialidad`) REFERENCES `especialidad` (`ID_Especialidad`);

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `FK_Mascota_Cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `mascota_ibfk_1` FOREIGN KEY (`ID_Raza`) REFERENCES `raza` (`ID_Raza`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `FK_Proveedor_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `raza`
--
ALTER TABLE `raza`
  ADD CONSTRAINT `raza_ibfk_1` FOREIGN KEY (`ID_Especie`) REFERENCES `especie` (`ID_Especie`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol_usuario` (`ID_Rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
