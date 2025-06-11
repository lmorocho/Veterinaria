-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 19:45:05
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

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_Cliente`, `Nombre`, `Apellido`, `DNI`, `Telefono`, `Email`, `Direccion`, `Fecha_Nacimiento`, `ID_Usuario`) VALUES
(2, 'Test_cliente', 'Cliente', '12255688', '1578946538', 'cliente@cliente.com', 'Ayacucho 449', '2010-02-01', 8),
(4, 'Test_cliente-2', 'Cliente2', '0916729482', '01578946538', 'cliente2@cliente2.com', 'Ayacucho 449', '1984-02-20', 10);

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`ID_Empleado`, `Nombre`, `Apellido`, `DNI`, `Fecha_Nacimiento`, `Email`, `Telefono`, `ID_Usuario`, `Direccion`) VALUES
(1, 'Luis', 'Morocho', '94429778', '1982-05-29', 'lmorocho@gmail.com', '1160082041', 1, NULL),
(2, 'Mariano País', 'Garay', '29567456', '1980-11-25', 'mpgaray@gmail.com', '1133445566', 2, NULL),
(3, 'Ariel', 'Toneguzzi', '28456123', '1970-03-14', 'atoneguzzi@gmail.com', '1144556677', 3, NULL),
(4, 'Agustín', 'Arufe', '27894561', '1990-09-09', 'aarufe@gmail.com', '1155667788', 4, NULL),
(5, 'admin', 'admin_append', '13579135', '0000-00-00', 'admin@admin.com', '', 9, ''),
(9, 'Test_empleado', 'Empleado', '12345678', '2025-05-01', 'empleado@empleado.com', '43534775456', 7, 'Ayacucho 447'),
(10, 'Juanito', 'Alimaña', '2468135', '1980-05-29', 'juanitoa@empleado.com', '', 11, '');

--
-- Volcado de datos para la tabla `especie`
--

INSERT INTO `especie` (`ID_Especie`, `Nombre_Especie`) VALUES
(1, 'Perro'),
(2, 'Gato');

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
(13, 'bet', '2022-10-01', 8, 4);

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

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`ID_Rol`, `Nombre_Rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Cliente'),
(4, 'Proveedor');

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
(11, 'jaempleado', '123', 2);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
