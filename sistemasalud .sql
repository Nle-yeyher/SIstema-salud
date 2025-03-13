-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-03-2025 a las 02:37:34
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
-- Base de datos: `sistemasalud`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarMedico` (IN `p_id_medico` INT, IN `p_nombre` VARCHAR(100), IN `p_apellido` VARCHAR(100), IN `p_especialidad` VARCHAR(100), IN `p_telefono` VARCHAR(15), IN `p_correo` VARCHAR(100))   BEGIN
    UPDATE medicos 
    SET nombre = p_nombre, 
        apellido = p_apellido, 
        especialidad = p_especialidad, 
        telefono = p_telefono, 
        correo = p_correo
    WHERE id_medico = p_id_medico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPaciente` (IN `p_id_paciente` INT, IN `p_nombre` VARCHAR(100), IN `p_apellido` VARCHAR(100), IN `p_fecha_nacimiento` DATE, IN `p_genero` VARCHAR(20), IN `p_direccion` VARCHAR(255), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(100))   BEGIN
    UPDATE pacientes 
    SET nombre = p_nombre,
        apellido = p_apellido,
        fecha_nacimiento = p_fecha_nacimiento,
        genero = p_genero,
        direccion = p_direccion,
        telefono = p_telefono,
        correo = p_correo
    WHERE id_paciente = p_id_paciente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AsignarTratamiento` (IN `p_id_paciente` INT, IN `p_id_medico` INT, IN `p_tratamiento` TEXT, IN `p_fecha` DATE)   BEGIN
    INSERT INTO tratamientos (id_paciente, id_medico, descripcion, fecha)
    VALUES (p_id_paciente, p_id_medico, p_tratamiento, p_fecha);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelarCita` (IN `p_id_cita` INT)   BEGIN
    DECLARE cita_existente INT;

    -- Verificar si la cita existe
    SELECT COUNT(*) INTO cita_existente FROM citas WHERE id_cita = p_id_cita;

    IF cita_existente > 0 THEN
        -- Si la cita existe, eliminarla
        DELETE FROM citas WHERE id_cita = p_id_cita;
    ELSE
        -- Si la cita no existe, generar un error
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No se encontró la cita con el ID proporcionado';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCita` (IN `p_id_cita` INT)   BEGIN
    DELETE FROM citas WHERE id_cita = p_id_cita;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarMedico` (IN `p_id_medico` INT)   BEGIN
    DELETE FROM medicos WHERE id_medico = p_id_medico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarPaciente` (IN `p_id_paciente` INT)   BEGIN
    DELETE FROM pacientes WHERE id_paciente = p_id_paciente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerarFactura` (IN `p_id_paciente` INT, IN `p_id_medico` INT, IN `p_detalles` TEXT, IN `p_total` DECIMAL(10,2), IN `p_fecha` DATE, OUT `p_id_factura` INT)   BEGIN
    INSERT INTO facturas (id_paciente, id_medico, detalles, total, fecha)
    VALUES (p_id_paciente, p_id_medico, p_detalles, p_total, p_fecha);
    
    -- Retornar el ID de la factura generada
    SET p_id_factura = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCita` (IN `c_id_paciente` INT, IN `c_id_medico` INT, IN `c_fecha` DATE, IN `c_hora` TIME, IN `c_motivo` TEXT)   BEGIN
    INSERT INTO citas (id_paciente, id_medico, fecha, hora, motivo)
    VALUES (c_id_paciente, c_id_medico, c_fecha, c_hora, c_motivo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarMedico` (IN `p_nombre` VARCHAR(100), IN `p_apellido` VARCHAR(100), IN `p_especialidad` VARCHAR(100), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(100), IN `p_contraseña` VARCHAR(255))   BEGIN
    INSERT INTO medicos (nombre, apellido, especialidad, telefono, correo, contraseña)
    VALUES (p_nombre, p_apellido, p_especialidad, p_telefono, p_correo, p_contraseña);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarPaciente` (IN `p_nombre` VARCHAR(50), IN `p_apellido` VARCHAR(50), IN `p_fecha_nacimiento` DATE, IN `p_genero` ENUM('M','F'), IN `p_direccion` VARCHAR(100), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(100), IN `p_contrasena` VARCHAR(255))   BEGIN
    INSERT INTO pacientes (nombre, apellido, fecha_nacimiento, genero, direccion, telefono, correo, contrasena)
    VALUES (p_nombre, p_apellido, p_fecha_nacimiento, p_genero, p_direccion, p_telefono, p_correo, p_contrasena);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarMedicos` ()   BEGIN
    SELECT id_medico, nombre, apellido, especialidad, telefono, correo FROM medicos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ListarPacientes` ()   BEGIN
    SELECT id_paciente, nombre, apellido, correo, telefono FROM pacientes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerCitas` ()   BEGIN
    SELECT c.id_cita, 
           p.nombre AS paciente, 
           m.nombre AS medico, 
           c.fecha, 
           c.hora
    FROM citas c
    JOIN pacientes p ON c.id_paciente = p.id_paciente
    JOIN medicos m ON c.id_medico = m.id_medico;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerMedicos` ()   BEGIN
    SELECT * FROM medicos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPacientes` (IN `idPaciente` INT)   BEGIN
    SELECT * FROM pacientes WHERE id_paciente = idPaciente;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_paciente`, `id_medico`, `fecha`, `hora`, `motivo`) VALUES
(5, 5, 4, '2025-03-24', '16:45:00', NULL),
(7, 2, 2, '2025-03-12', '17:37:00', 'molestias'),
(8, 2, 2, '2025-05-13', '10:31:00', 'revision');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `detalles` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_paciente`, `id_medico`, `detalles`, `total`, `fecha`) VALUES
(6, 2, 3, 'molestia', 50000.00, '2025-03-12'),
(7, 2, 3, 'consuta', 50000.00, '2025-03-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `id_medico` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `especialidad` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id_medico`, `nombre`, `apellido`, `especialidad`, `telefono`, `correo`, `contrasena`, `contraseña`) VALUES
(1, 'Dr. Luis', 'Fernández', 'Cardiología', '3129876543', 'luisfernandez@email.com', '', 'medico123'),
(2, 'Dra. Marta', 'Salazar', 'Pediatría', '3112345678', 'martasalazar@email.com', '', 'medico456'),
(3, 'Dr. Ricardo', 'Ortiz', 'Dermatología', '3104567891', 'ricardoortiz@email.com', '', 'medico789'),
(4, 'Dra. Beatriz', 'Ramírez', 'Neurología', '3136789123', 'beatrizramirez@email.com', '', 'medico321'),
(5, 'Dr. Sergio', 'Mendoza', 'Traumatología', '3149871234', 'sergiomendoza@email.com', '', 'medico654'),
(8, 'Yeyher', 'Jordan Moreno', 'formula', '3113874432', 'yeyherjordanmoreno@gmail.com', '', '$2y$10$5/sF8AerHGGBtBST1Ow5/uQ2T1l5Xod.efpdT.QTbBpdiOHhTuFkS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('M','F') NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre`, `apellido`, `fecha_nacimiento`, `genero`, `direccion`, `telefono`, `correo`, `contraseña`, `contrasena`) VALUES
(2, 'María', 'Gómez', '1985-08-22', 'F', 'Carrera 45', '3017654321', 'mariagomez@email.com', 'clave456', ''),
(4, 'Ana', 'Martínez', '1995-11-30', 'F', 'Calle 50', '3209876543', 'anamartinez@email.com', 'clave321', ''),
(5, 'Pedro', 'Rodríguez', '1988-07-15', 'M', 'Carrera 12', '3216549870', 'pedrorodriguez@email.com', 'clave654', ''),
(6, 'Sofía', 'Hernández', '1992-03-05', 'F', 'Avenida 76', '3221236548', 'sofiahernandez@email.com', 'clave987', ''),
(7, 'Andrés', 'García', '1983-09-25', 'M', 'Calle 20', '3237896541', 'andresgarcia@email.com', 'clave111', ''),
(8, 'Laura', 'Díaz', '1997-06-12', 'F', 'Carrera 56', '3249871236', 'lauradiaz@email.com', 'clave222', ''),
(9, 'Diego', 'Torres', '2001-12-01', 'M', 'Avenida 34', '3256549873', 'diegotorres@email.com', 'clave333', ''),
(10, 'Fernanda', 'Jiménez', '1994-04-18', 'F', 'Calle 11', '3263216549', 'fernandajimenez@email.com', 'clave444', ''),
(15, 'Yeyher', 'Jordan Moreno', '2004-08-27', '', 'valencia', '3113874432', 'yeynermakri@gmail.com', '', '$2y$10$a/4HzOY6GVabcivpcRItruiZd5m2h3cox7mit6BioKXRZgGNs8doS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id_tratamiento` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id_tratamiento`, `id_paciente`, `id_medico`, `descripcion`, `fecha`) VALUES
(43, 2, 2, 'molestia', '2025-03-12'),
(44, 2, 2, 'consulta', '2025-03-12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id_medico`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id_tratamiento`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id_tratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`) ON DELETE CASCADE,
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`),
  ADD CONSTRAINT `tratamientos_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
