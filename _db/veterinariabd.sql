-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2025 a las 01:39:10
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
-- Estructura de tabla para la tabla `backup_mascotas`
--

CREATE TABLE `backup_mascotas` (
  `ID_Backup_Mascota` int(11) NOT NULL,
  `ID_Mascota` int(11) DEFAULT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `Nombre_Mascota` varchar(50) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `ID_Raza` int(11) DEFAULT NULL,
  `ID_Especie` int(11) DEFAULT NULL,
  `Fecha_Backup` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `backup_mascotas`
--

INSERT INTO `backup_mascotas` (`ID_Backup_Mascota`, `ID_Mascota`, `ID_Cliente`, `Nombre_Mascota`, `Fecha_Nacimiento`, `ID_Raza`, `ID_Especie`, `Fecha_Backup`) VALUES
(1, 16, 8, 'bet', '2022-02-20', 1, 1, '2025-07-04 21:47:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backup_usuarios`
--

CREATE TABLE `backup_usuarios` (
  `ID_Backup` int(11) NOT NULL,
  `Tipo_Perfil` enum('Administrador','Empleado','Cliente','Usuario') NOT NULL,
  `ID_Original` int(11) NOT NULL COMMENT 'ID_Empleado o ID_Cliente',
  `ID_Usuario` int(11) NOT NULL COMMENT 'Clave foránea a usuario',
  `Nombre` varchar(50) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Apellido` varchar(50) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `DNI` varchar(20) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Fecha_Nacimiento` date DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Email` varchar(100) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Telefono` varchar(20) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Direccion` varchar(150) DEFAULT NULL COMMENT 'Datos del perfil tabla Empleado o Cliente',
  `Nombre_Usuario` varchar(50) DEFAULT NULL COMMENT 'Datos de login del usuario',
  `Password` varchar(255) DEFAULT NULL COMMENT 'Datos de login del usuario',
  `ID_Rol` int(11) DEFAULT NULL COMMENT 'Datos de login del usuario',
  `Fecha_Backup` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `backup_usuarios`
--

INSERT INTO `backup_usuarios` (`ID_Backup`, `Tipo_Perfil`, `ID_Original`, `ID_Usuario`, `Nombre`, `Apellido`, `DNI`, `Fecha_Nacimiento`, `Email`, `Telefono`, `Direccion`, `Nombre_Usuario`, `Password`, `ID_Rol`, `Fecha_Backup`) VALUES
(3, 'Cliente', 8, 16, 'Cliente3', 'Cliente3', '13678987', '2000-01-01', 'cliente3@cliente.com', '1112345678', 'cliente3', 'cliente3', '123', 3, '2025-07-04 21:47:57'),
(4, 'Cliente', 9, 18, 'cliente5', 'cliente5', '13679213', '0000-00-00', 'cliente5@cliente.com', '', 'asdfasddasda', 'tcliente5', '123', 3, '2025-07-15 19:12:45');

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
(4, 'Test_cliente-2', 'Cliente2', '0916729482', '01578946538', 'cliente2@cliente2.com', 'Ayacucho 449', '1984-02-20', 10),
(7, 'cliente4', 'cliente4', '4697354355', '', 'cliente4@cliente.com', '', '2015-01-14', 14),
(10, 'cliente6', 'cliente6', '11111111', '', 'cliente6@cliente.com', '', '0000-00-00', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `ID_Compra` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `ID_Proveedor` int(11) NOT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Tipo_Comprobante` varchar(50) NOT NULL,
  `Numero_Comprobante` varchar(100) NOT NULL,
  `Estado_Compra` varchar(50) NOT NULL DEFAULT 'Pendiente',
  `Fecha_Pago` date DEFAULT NULL,
  `Metodo_Pago` varchar(50) DEFAULT NULL,
  `Observaciones` text DEFAULT NULL,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `ID_Detalle_Compra` int(11) NOT NULL,
  `ID_Compra` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL DEFAULT 1,
  `Precio_Unitario` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Subtotal` decimal(10,2) GENERATED ALWAYS AS (`Cantidad` * `Precio_Unitario`) STORED
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
(1, 'Luis', 'Morocho', '94429778', '1982-05-29', 'lmorocho@gmail.com', '1160082041', 1, 'SD'),
(2, 'Mariano País', 'Garay', '29567456', '1980-11-25', 'mpgaray@gmail.com', '1133445566', 2, 'SD'),
(3, 'Ariel', 'Toneguzzi', '28456123', '1970-03-14', 'atoneguzzi@gmail.com', '1144556677', 3, 'SD'),
(4, 'Agustín', 'Arufe', '27894561', '1990-09-09', 'aarufe@gmail.com', '1155667788', 4, 'SD'),
(5, 'admin', 'admin_append', '13579135', '0000-00-00', 'admin@admin.com', '', 9, 'SD'),
(9, 'Test_empleado', 'Empleado', '12345678', '2025-05-01', 'empleado@empleado.com', '43534775456', 7, 'SD'),
(10, 'Juanito', 'Alimaña', '2468135', '1980-05-29', 'juanitoa@empleado.com', '', 11, 'SD'),
(11, 'Empleado3', 'Empleado3', '54654898', '1980-03-15', 'empleado3@empleado.com', '', 15, 'SD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_especialidad`
--

CREATE TABLE `empleado_especialidad` (
  `ID_ESP_EMP` int(11) NOT NULL,
  `ID_Empleado` int(11) NOT NULL,
  `ID_Especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado_especialidad`
--

INSERT INTO `empleado_especialidad` (`ID_ESP_EMP`, `ID_Empleado`, `ID_Especialidad`) VALUES
(1, 9, 1),
(2, 10, 2),
(3, 11, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `ID_Especialidad` int(11) NOT NULL,
  `Nombre_Especialidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`ID_Especialidad`, `Nombre_Especialidad`) VALUES
(1, 'Revisión General de Mascota'),
(2, 'Vacunas Mascota'),
(3, 'Spa para Mascota');

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
(5, 'pippo', '2022-01-02', 3, 4),
(6, 'blacky', '2020-01-10', 1, 2),
(9, 'bet', '2023-12-11', 9, 2),
(10, 'blacky', '2023-01-01', 2, 2),
(11, 'pippo', '2020-02-10', 4, 2),
(12, 'bet2', '2021-12-25', 8, 2),
(13, 'bet', '2022-10-01', 8, 4),
(15, 'dan', '2024-12-05', 4, 7);

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
  `ID_Tipo_Producto` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL DEFAULT 1,
  `Precio_Venta` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Stock_Actual` int(11) NOT NULL DEFAULT 0,
  `Stock_Minimo` int(11) NOT NULL DEFAULT 0,
  `ID_Proveedor` int(11) NOT NULL
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

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`ID_Proveedor`, `Nombre`, `Apellido`, `Empresa`, `Telefono`, `Email`, `Direccion`, `ID_Usuario`, `DNI`) VALUES
(1, 'Proveedor1', 'Proveedor1', 'Proveedor1', '4839739932', 'proveerdor1@proveedor.com', 'Buenos Aires', 17, '987654321'),
(2, 'Proveedor2', 'Proveedor2', 'ALFA SA', '1145001111', 'info@alfa.com', 'Av. Corrientes 1000,CABA', 20, '45454545'),
(3, 'proveedor3', 'proveedor3', 'BET NET', '3414500222', 'ventas@beta.net', 'Calle Ficticia 500, Buenos Aires', 21, '1212121212'),
(4, 'proveedor4', 'proveedor4', 'GAMMA', '11469922222', 'contacto@gamma.org', 'Av. Colón 2000, Buenos Aires', 22, '27272727');

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
  `ID_Precio` int(11) NOT NULL,
  `ID_Detalle_Compra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `ID_Tipo_Producto` int(11) NOT NULL,
  `Nombre_Tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`ID_Tipo_Producto`, `Nombre_Tipo`) VALUES
(1, 'Clínica'),
(2, 'Alimento'),
(3, 'Peluquería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_turno`
--

CREATE TABLE `tipo_turno` (
  `ID_Tipo_Turno` int(11) NOT NULL,
  `Nombre_Tipo_Turno` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_turno`
--

INSERT INTO `tipo_turno` (`ID_Tipo_Turno`, `Nombre_Tipo_Turno`) VALUES
(1, 'Revisión General de Mascota'),
(2, 'Vacunas Mascota'),
(3, 'Spa para Mascota');

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

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`ID_Turno`, `Fecha`, `Hora`, `ID_Mascota`, `ID_Empleado`, `ID_Tipo_Turno`) VALUES
(4, '2025-06-16', '09:00:00', 15, 5, 1),
(5, '2025-06-16', '11:00:00', 5, 5, 1),
(6, '2025-06-16', '13:00:00', 11, 5, 1),
(7, '2025-06-16', '10:00:00', 15, 5, 2),
(9, '2025-06-16', '12:00:00', 15, 5, 2),
(10, '2025-06-16', '10:00:00', 9, 5, 1),
(13, '2025-06-16', '12:00:00', 6, 5, 1),
(14, '2025-06-23', '09:00:00', 13, 5, 3),
(16, '2025-06-24', '09:00:00', 5, 5, 2);

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
(10, 't2cliente', '123', 3),
(11, 'jaempleado', '123', 2),
(14, 'cliente4', '123', 3),
(15, 'empleado3', '123', 2),
(17, 'tproveedor', '123', 4),
(19, 'cliente6', '123', 3),
(20, 'proveedor2', '123', 4),
(21, 'proveedor3', '123', 4),
(22, 'proveedor4', '123', 4);

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
-- Indices de la tabla `backup_mascotas`
--
ALTER TABLE `backup_mascotas`
  ADD PRIMARY KEY (`ID_Backup_Mascota`);

--
-- Indices de la tabla `backup_usuarios`
--
ALTER TABLE `backup_usuarios`
  ADD PRIMARY KEY (`ID_Backup`);

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
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`ID_Compra`),
  ADD UNIQUE KEY `unique_numero_comprobante` (`Numero_Comprobante`),
  ADD KEY `ID_Proveedor` (`ID_Proveedor`),
  ADD KEY `fk_compra_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`ID_Detalle_Compra`),
  ADD KEY `FK_DetalleCompra_Compra` (`ID_Compra`),
  ADD KEY `FK_DetalleCompra_Producto` (`ID_Producto`),
  ADD KEY `FK_DetalleCompra_TipoProducto` (`ID_Tipo_Producto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`ID_Detalle_Venta`),
  ADD KEY `FK_DetalleVenta_Venta` (`ID_Venta`),
  ADD KEY `FK_DetalleVenta_Producto` (`ID_Producto`),
  ADD KEY `FK_DetalleVenta_TipoProducto` (`ID_Tipo_Producto`);

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
  ADD PRIMARY KEY (`ID_Precio`),
  ADD KEY `FK_Precio_Producto` (`ID_Producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `FK_Producto_Tipo` (`ID_Tipo_Producto`),
  ADD KEY `idx_producto_proveedor` (`ID_Proveedor`);

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
  ADD PRIMARY KEY (`ID_Stock`),
  ADD KEY `FK_Stock_Producto` (`ID_Producto`),
  ADD KEY `FK_Stock_Proveedor` (`ID_Proveedor`),
  ADD KEY `FK_Stock_Precio` (`ID_Precio`),
  ADD KEY `FK_Stock_DetalleCompra` (`ID_Detalle_Compra`);

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
  ADD PRIMARY KEY (`ID_Turno`),
  ADD KEY `FK_Turno_Mascota` (`ID_Mascota`),
  ADD KEY `FK_Turno_Empleado` (`ID_Empleado`),
  ADD KEY `FK_Turno_Tipo` (`ID_Tipo_Turno`);

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
  ADD PRIMARY KEY (`ID_Venta`),
  ADD KEY `FK_Venta_Cliente` (`ID_Cliente`),
  ADD KEY `FK_Venta_Precio` (`ID_Precio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `backup_mascotas`
--
ALTER TABLE `backup_mascotas`
  MODIFY `ID_Backup_Mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `backup_usuarios`
--
ALTER TABLE `backup_usuarios`
  MODIFY `ID_Backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `ID_Compra` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `ID_Empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `empleado_especialidad`
--
ALTER TABLE `empleado_especialidad`
  MODIFY `ID_ESP_EMP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `ID_Especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `especie`
--
ALTER TABLE `especie`
  MODIFY `ID_Especie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `ID_Mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `ID_Proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `ID_Tipo_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_turno`
--
ALTER TABLE `tipo_turno`
  MODIFY `ID_Tipo_Turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `ID_Turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`),
  ADD CONSTRAINT `fk_compra_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `FK_DetalleCompra_Compra` FOREIGN KEY (`ID_Compra`) REFERENCES `compra` (`ID_Compra`),
  ADD CONSTRAINT `FK_DetalleCompra_Producto` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`),
  ADD CONSTRAINT `FK_DetalleCompra_TipoProducto` FOREIGN KEY (`ID_Tipo_Producto`) REFERENCES `tipo_producto` (`ID_Tipo_Producto`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `FK_DetalleVenta_Producto` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`),
  ADD CONSTRAINT `FK_DetalleVenta_TipoProducto` FOREIGN KEY (`ID_Tipo_Producto`) REFERENCES `tipo_producto` (`ID_Tipo_Producto`),
  ADD CONSTRAINT `FK_DetalleVenta_Venta` FOREIGN KEY (`ID_Venta`) REFERENCES `venta` (`ID_Venta`);

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
-- Filtros para la tabla `precio`
--
ALTER TABLE `precio`
  ADD CONSTRAINT `FK_Precio_Producto` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_Producto_Tipo` FOREIGN KEY (`ID_Tipo_Producto`) REFERENCES `tipo_producto` (`ID_Tipo_Producto`),
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

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
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_Stock_DetalleCompra` FOREIGN KEY (`ID_Detalle_Compra`) REFERENCES `detalle_compra` (`ID_Detalle_Compra`),
  ADD CONSTRAINT `FK_Stock_Precio` FOREIGN KEY (`ID_Precio`) REFERENCES `precio` (`ID_Precio`),
  ADD CONSTRAINT `FK_Stock_Producto` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`),
  ADD CONSTRAINT `FK_Stock_Proveedor` FOREIGN KEY (`ID_Proveedor`) REFERENCES `proveedor` (`ID_Proveedor`);

--
-- Filtros para la tabla `turno`
--
ALTER TABLE `turno`
  ADD CONSTRAINT `FK_Turno_Empleado` FOREIGN KEY (`ID_Empleado`) REFERENCES `empleado` (`ID_Empleado`),
  ADD CONSTRAINT `FK_Turno_Mascota` FOREIGN KEY (`ID_Mascota`) REFERENCES `mascota` (`ID_Mascota`),
  ADD CONSTRAINT `FK_Turno_Tipo` FOREIGN KEY (`ID_Tipo_Turno`) REFERENCES `tipo_turno` (`ID_Tipo_Turno`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol_usuario` (`ID_Rol`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_Venta_Cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `cliente` (`ID_Cliente`),
  ADD CONSTRAINT `FK_Venta_Precio` FOREIGN KEY (`ID_Precio`) REFERENCES `precio` (`ID_Precio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
