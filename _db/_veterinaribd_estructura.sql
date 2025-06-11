-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 19:36:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
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
-- Creación: 28-05-2025 a las 20:30:31
-- Última actualización: 10-06-2025 a las 18:44:15
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
-- RELACIONES PARA LA TABLA `cliente`:
--   `ID_Usuario`
--       `usuario` -> `ID_Usuario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--
-- Creación: 09-06-2025 a las 18:28:49
--

CREATE TABLE `compra` (
  `ID_Compra` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `ID_Proveedor` int(11) NOT NULL,
  `Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `compra`:
--   `ID_Proveedor`
--       `proveedor` -> `ID_Proveedor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--
-- Creación: 09-06-2025 a las 18:19:03
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

--
-- RELACIONES PARA LA TABLA `detalle_compra`:
--   `ID_Compra`
--       `compra` -> `ID_Compra`
--   `ID_Producto`
--       `producto` -> `ID_Producto`
--   `ID_Tipo_Producto`
--       `tipo_producto` -> `ID_Tipo_Producto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--
-- Creación: 25-05-2025 a las 03:49:58
--

CREATE TABLE `detalle_venta` (
  `ID_Detalle_Venta` int(11) NOT NULL,
  `ID_Venta` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `detalle_venta`:
--   `ID_Producto`
--       `producto` -> `ID_Producto`
--   `ID_Tipo_Producto`
--       `tipo_producto` -> `ID_Tipo_Producto`
--   `ID_Venta`
--       `venta` -> `ID_Venta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--
-- Creación: 28-05-2025 a las 19:24:29
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
-- RELACIONES PARA LA TABLA `empleado`:
--   `ID_Usuario`
--       `usuario` -> `ID_Usuario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_especialidad`
--
-- Creación: 24-05-2025 a las 00:12:31
--

CREATE TABLE `empleado_especialidad` (
  `ID_ESP_EMP` int(11) NOT NULL,
  `ID_Empleado` int(11) NOT NULL,
  `ID_Especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `empleado_especialidad`:
--   `ID_Empleado`
--       `empleado` -> `ID_Empleado`
--   `ID_Especialidad`
--       `especialidad` -> `ID_Especialidad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--
-- Creación: 24-05-2025 a las 00:11:57
--

CREATE TABLE `especialidad` (
  `ID_Especialidad` int(11) NOT NULL,
  `Nombre_Especialidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `especialidad`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especie`
--
-- Creación: 24-05-2025 a las 00:10:06
--

CREATE TABLE `especie` (
  `ID_Especie` int(11) NOT NULL,
  `Nombre_Especie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `especie`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--
-- Creación: 28-05-2025 a las 20:35:57
-- Última actualización: 10-06-2025 a las 18:44:01
--

CREATE TABLE `mascota` (
  `ID_Mascota` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `ID_Raza` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `mascota`:
--   `ID_Cliente`
--       `cliente` -> `ID_Cliente`
--   `ID_Raza`
--       `raza` -> `ID_Raza`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio`
--
-- Creación: 25-05-2025 a las 03:50:42
--

CREATE TABLE `precio` (
  `ID_Precio` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Fecha_Inicio` date NOT NULL,
  `Fecha_Fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `precio`:
--   `ID_Producto`
--       `producto` -> `ID_Producto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--
-- Creación: 25-05-2025 a las 03:30:05
--

CREATE TABLE `producto` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `ID_Tipo_Producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `producto`:
--   `ID_Tipo_Producto`
--       `tipo_producto` -> `ID_Tipo_Producto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--
-- Creación: 28-05-2025 a las 19:28:09
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
-- RELACIONES PARA LA TABLA `proveedor`:
--   `ID_Usuario`
--       `usuario` -> `ID_Usuario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `raza`
--
-- Creación: 24-05-2025 a las 00:10:14
--

CREATE TABLE `raza` (
  `ID_Raza` int(11) NOT NULL,
  `Nombre_Raza` varchar(50) NOT NULL,
  `ID_Especie` int(11) NOT NULL,
  `Color` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `raza`:
--   `ID_Especie`
--       `especie` -> `ID_Especie`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--
-- Creación: 24-05-2025 a las 00:07:39
--

CREATE TABLE `rol_usuario` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `rol_usuario`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--
-- Creación: 25-05-2025 a las 03:51:12
--

CREATE TABLE `stock` (
  `ID_Stock` int(11) NOT NULL,
  `ID_Producto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `ID_Proveedor` int(11) NOT NULL,
  `ID_Precio` int(11) NOT NULL,
  `ID_Detalle_Compra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `stock`:
--   `ID_Detalle_Compra`
--       `detalle_compra` -> `ID_Detalle_Compra`
--   `ID_Precio`
--       `precio` -> `ID_Precio`
--   `ID_Producto`
--       `producto` -> `ID_Producto`
--   `ID_Proveedor`
--       `proveedor` -> `ID_Proveedor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--
-- Creación: 25-05-2025 a las 03:30:05
--

CREATE TABLE `tipo_producto` (
  `ID_Tipo_Producto` int(11) NOT NULL,
  `Nombre_Tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `tipo_producto`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_turno`
--
-- Creación: 25-05-2025 a las 03:28:55
--

CREATE TABLE `tipo_turno` (
  `ID_Tipo_Turno` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `tipo_turno`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--
-- Creación: 25-05-2025 a las 03:28:55
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
-- RELACIONES PARA LA TABLA `turno`:
--   `ID_Empleado`
--       `empleado` -> `ID_Empleado`
--   `ID_Mascota`
--       `mascota` -> `ID_Mascota`
--   `ID_Tipo_Turno`
--       `tipo_turno` -> `ID_Tipo_Turno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--
-- Creación: 28-05-2025 a las 02:14:58
-- Última actualización: 10-06-2025 a las 18:44:26
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `usuario`:
--   `ID_Rol`
--       `rol_usuario` -> `ID_Rol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--
-- Creación: 25-05-2025 a las 03:49:29
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
