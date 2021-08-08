-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2021 a las 19:05:25
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `centromedico`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sparticulo` (IN `codigo` VARCHAR(10))  select * from articulos where codArticulo = codigo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sparticulos` ()  SELECT * FROM articulos$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcantcompra` (IN `id` INT, IN `cantidad` INT)  UPDATE articulos SET existencias = existencias - cantidad WHERE IDarticulo = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcliente` (IN `id` INT)  select * from clientes where IDcliente = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spclientes` ()  select * from clientes$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcompra` (IN `id` INT)  SELECT c.IDcompra as id, c.IDproveedor as IDproveedor, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
	FROM compras as c  
	INNER JOIN proveedores as p on p.IDproveedor = c.IDproveedor 
	WHERE c.IDcompra = id 
	GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcompradetalle` (IN `id` INT)  NO SQL
select cd.IDcompra as compra, a.IDarticulo as idart, a.Nombre as articulo, a.precio as precio, cd.cantidad as cantidad, (a.precio * cd.cantidad) as total
from comprasdetalle as cd
INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo
WHERE cd.IDcompra = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcompras` ()  SELECT c.IDcompra as id, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
	FROM compras as c  
	INNER JOIN proveedores as p on p.IDproveedor = c.IDproveedor 
	GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spcomprasdetalle` ()  NO SQL
select cd.IDcompra as compra, a.IDarticulo as idart, a.Nombre as articulo, a.precio as precio, cd.cantidad as cantidad, (a.precio * cd.cantidad) as total
from comprasdetalle as cd
INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spprecio` (IN `id` INT)  NO SQL
select precio from articulos where IDarticulo = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spventa` (IN `id` INT)  SELECT v.IDventa as id, c.Nombre as nombreC, v.Fecha as fecha, sum(v.total) as total, sum(v.saldoPagado) as saldo 
	FROM ventas as v 
	INNER JOIN clientes as c on c.IDcliente = v.IDcliente
    WHERE v.IDventa = id
	GROUP BY v.IDventa, c.Nombre, v.Fecha$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spventadetalle` (IN `id` INT)  select vd.IDventa as venta, a.IDarticulo as idart, a.Nombre as articulo, a.precio as precio, vd.cantidad as cantidad, (a.precio * vd.cantidad) as total
from ventasdetalle as vd
INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo
WHERE vd.IDcompra = id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spventas` ()  SELECT v.IDventa as id, c.Nombre as nombreC, v.Fecha as fecha, sum(v.total) as total, sum(v.saldoPagado) as saldo 
	FROM ventas as v 
	INNER JOIN clientes as c on c.IDcliente = v.IDcliente
	GROUP BY v.IDventa, c.Nombre, v.Fecha$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spventasdetalle` ()  select vd.IDventa as venta, a.IDarticulo as idart, a.Nombre as articulo, a.precio as precio, vd.cantidad as cantidad, (a.precio * vd.cantidad) as total
from ventasdetalle as vd
INNER JOIN articulos as a on a.IDarticulo = vd.IDarticulo$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `IDarticulo` int(11) NOT NULL,
  `codArticulo` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `IDproveedor` int(11) NOT NULL,
  `precio` float NOT NULL,
  `impuesto` float NOT NULL,
  `existencias` int(11) NOT NULL,
  `limite` int(11) NOT NULL,
  `caducidad` date NOT NULL,
  `estante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`IDarticulo`, `codArticulo`, `Nombre`, `IDproveedor`, `precio`, `impuesto`, `existencias`, `limite`, `caducidad`, `estante`) VALUES
(25, 'ABC01', 'Pastilla', 1, 120, 15, 218, 100, '2021-04-21', 1),
(26, 'ABC02', 'Lorem Ipsum', 1, 200, 15, 127, 120, '2021-04-22', 1),
(27, 'ABC03', 'Ipsum', 1, 500, 15, 0, 10, '2021-05-09', 1),
(28, 'ABC04', 'Pastilla-1', 1, 120, 15, 0, 25, '2021-05-08', 1),
(29, 'ABC05', 'Pastilla-34', 1, 45, 15, 0, 150, '2021-04-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `IDcliente` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `tipoCliente` int(11) NOT NULL,
  `saldoCrediticio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`IDcliente`, `Nombre`, `Direccion`, `tipoCliente`, `saldoCrediticio`) VALUES
(1, 'Dalton Ramos', 'Barrio El Centro', 1, 5000),
(2, 'Joel Mata', 'Barrio El Centro', 1, 9100),
(3, 'Julian Casablanca', 'Barrio El Centro', 1, 10000),
(4, 'Maria Ramos', 'Barrio El Centro', 1, 10000),
(5, 'Jill Valentine', 'Barrio El Centro', 1, 10000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `IDcompra` int(11) NOT NULL,
  `IDproveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numeroCheque` int(11) NOT NULL,
  `total` float NOT NULL,
  `saldoPagado` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`IDcompra`, `IDproveedor`, `fecha`, `numeroCheque`, `total`, `saldoPagado`) VALUES
(1, 1, '2021-05-01', 1, 2400, 2000),
(2, 1, '2021-04-29', 2, 0, 0);

--
-- Disparadores `compras`
--
DELIMITER $$
CREATE TRIGGER `trgborrarcompra` BEFORE DELETE ON `compras` FOR EACH ROW delete from comprasdetalle
where IDcompra = OLD.IDcompra
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgsaldoprov` BEFORE INSERT ON `compras` FOR EACH ROW UPDATE proveedores
SET saldoCrediticio = saldoCrediticio -(NEW.total-NEW.saldoPagado)
WHERE IDproveedor = NEW.IDproveedor
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprasdetalle`
--

CREATE TABLE `comprasdetalle` (
  `IDcompra` int(11) NOT NULL,
  `IDarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comprasdetalle`
--

INSERT INTO `comprasdetalle` (`IDcompra`, `IDarticulo`, `cantidad`) VALUES
(1, 25, 20);

--
-- Disparadores `comprasdetalle`
--
DELIMITER $$
CREATE TRIGGER `trgBorrarCompraDetalle` BEFORE DELETE ON `comprasdetalle` FOR EACH ROW CALL spcantcompra(OLD.IDarticulo, OLD.cantidad)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgInsertarCompraDetalle` BEFORE INSERT ON `comprasdetalle` FOR EACH ROW UPDATE Articulos
		SET existencias = NEW.cantidad + existencias
		WHERE IDarticulo = NEW.IDarticulo
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgborrarsdetalletotal` BEFORE DELETE ON `comprasdetalle` FOR EACH ROW update compras
set total = (total - ((select precio from articulos where articulos.IDarticulo = OLD.IDarticulo) * OLD.cantidad)) WHERE IDcompra = OLD.IDcompra
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estantes`
--

CREATE TABLE `estantes` (
  `IDestante` int(11) NOT NULL,
  `estante` varchar(5) NOT NULL,
  `almacen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estantes`
--

INSERT INTO `estantes` (`IDestante`, `estante`, `almacen`) VALUES
(1, '1A', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `IDproveedor` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `saldoCrediticio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`IDproveedor`, `Nombre`, `Direccion`, `Telefono`, `Correo`, `saldoCrediticio`) VALUES
(1, 'Drogueria Nacional', 'Barrio El Centro', 99987324, 'correo@correo.com', 8400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoclientes`
--

CREATE TABLE `tipoclientes` (
  `IDtipo` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descuento` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipoclientes`
--

INSERT INTO `tipoclientes` (`IDtipo`, `Nombre`, `Descuento`) VALUES
(1, 'a', 12);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `varticulos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `varticulos` (
`IDarticulo` int(11)
,`codArticulo` varchar(50)
,`Nombre` varchar(50)
,`IDproveedor` int(11)
,`precio` float
,`impuesto` float
,`existencias` int(11)
,`limite` int(11)
,`caducidad` date
,`estante` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `varticulosagotados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `varticulosagotados` (
`articulosagotados` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `varticulosbajas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `varticulosbajas` (
`articulosbajas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcompras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcompras` (
`id` int(11)
,`nombreP` varchar(100)
,`fecha` date
,`cheque` int(11)
,`total` float
,`saldo` float
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `IDventa` int(11) NOT NULL,
  `IDcliente` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `saldoPagado` float NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`IDventa`, `IDcliente`, `Fecha`, `saldoPagado`, `total`) VALUES
(1, 4, '2021-04-30', 2000, 6000),
(2, 1, '2021-04-26', 6000, 6900);

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `trgborrarventa` BEFORE DELETE ON `ventas` FOR EACH ROW delete from ventasdetalle
where IDventa = OLD.IDventa
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgsaldoclientes` BEFORE INSERT ON `ventas` FOR EACH ROW UPDATE clientes
SET saldoCrediticio = saldoCrediticio -(NEW.total-NEW.saldoPagado)
WHERE IDcliente = NEW.IDcliente
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventasdetalle`
--

CREATE TABLE `ventasdetalle` (
  `IDventa` int(11) NOT NULL,
  `IDarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventasdetalle`
--

INSERT INTO `ventasdetalle` (`IDventa`, `IDarticulo`, `cantidad`) VALUES
(1, 26, 30),
(2, 26, 30),
(2, 29, 20);

--
-- Disparadores `ventasdetalle`
--
DELIMITER $$
CREATE TRIGGER `trgBorrarVentaDetalle` BEFORE INSERT ON `ventasdetalle` FOR EACH ROW UPDATE Articulos
		SET existencias = NEW.cantidad + existencias
		WHERE IDarticulo = NEW.IDarticulo
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgInsertarVentaDetalle` BEFORE INSERT ON `ventasdetalle` FOR EACH ROW UPDATE Articulos
		SET existencias = existencias - NEW.cantidad
		WHERE IDarticulo = NEW.IDarticulo
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trgborrardetalletotalventa` BEFORE DELETE ON `ventasdetalle` FOR EACH ROW update ventas
set total = (total - ((select precio from articulos where articulos.IDarticulo = OLD.IDarticulo) * OLD.cantidad)) WHERE IDventa = OLD.IDventa
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vexistencias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vexistencias` (
`existencias` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtotalarticulos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtotalarticulos` (
`totalArticulos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtotalcompras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtotalcompras` (
`total` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtotalcomprasmes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtotalcomprasmes` (
`total` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtotalpagos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtotalpagos` (
`pagos` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtotalpendientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtotalpendientes` (
`pendiente` double
);

-- --------------------------------------------------------

--
-- Estructura para la vista `varticulos`
--
DROP TABLE IF EXISTS `varticulos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `varticulos`  AS SELECT `articulos`.`IDarticulo` AS `IDarticulo`, `articulos`.`codArticulo` AS `codArticulo`, `articulos`.`Nombre` AS `Nombre`, `articulos`.`IDproveedor` AS `IDproveedor`, `articulos`.`precio` AS `precio`, `articulos`.`impuesto` AS `impuesto`, `articulos`.`existencias` AS `existencias`, `articulos`.`limite` AS `limite`, `articulos`.`caducidad` AS `caducidad`, `articulos`.`estante` AS `estante` FROM `articulos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `varticulosagotados`
--
DROP TABLE IF EXISTS `varticulosagotados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `varticulosagotados`  AS SELECT count(0) AS `articulosagotados` FROM `articulos` WHERE `articulos`.`existencias` = 0 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `varticulosbajas`
--
DROP TABLE IF EXISTS `varticulosbajas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `varticulosbajas`  AS SELECT count(0) AS `articulosbajas` FROM `articulos` WHERE `articulos`.`existencias` <= 20 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcompras`
--
DROP TABLE IF EXISTS `vcompras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vcompras`  AS SELECT `c`.`IDcompra` AS `id`, `p`.`Nombre` AS `nombreP`, `c`.`fecha` AS `fecha`, `c`.`numeroCheque` AS `cheque`, `c`.`total` AS `total`, `c`.`saldoPagado` AS `saldo` FROM (((`compras` `c` join `comprasdetalle` `cd` on(`cd`.`IDcompra` = `c`.`IDcompra`)) left join `articulos` `a` on(`a`.`IDarticulo` = `cd`.`IDarticulo`)) join `proveedores` `p` on(`p`.`IDproveedor` = `a`.`IDproveedor`)) GROUP BY `c`.`IDcompra`, `p`.`Nombre`, `c`.`fecha`, `c`.`numeroCheque`, `c`.`total`, `c`.`saldoPagado` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vexistencias`
--
DROP TABLE IF EXISTS `vexistencias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vexistencias`  AS SELECT sum(`articulos`.`existencias`) AS `existencias` FROM `articulos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtotalarticulos`
--
DROP TABLE IF EXISTS `vtotalarticulos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtotalarticulos`  AS SELECT count(0) AS `totalArticulos` FROM `articulos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtotalcompras`
--
DROP TABLE IF EXISTS `vtotalcompras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtotalcompras`  AS SELECT sum(`compras`.`total`) AS `total` FROM `compras` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtotalcomprasmes`
--
DROP TABLE IF EXISTS `vtotalcomprasmes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtotalcomprasmes`  AS SELECT sum(`compras`.`total`) AS `total` FROM `compras` WHERE month(`compras`.`fecha`) = month(curdate()) AND year(`compras`.`fecha`) = year(curdate()) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtotalpagos`
--
DROP TABLE IF EXISTS `vtotalpagos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtotalpagos`  AS SELECT sum(`compras`.`saldoPagado`) AS `pagos` FROM `compras` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtotalpendientes`
--
DROP TABLE IF EXISTS `vtotalpendientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vtotalpendientes`  AS SELECT sum(`compras`.`total`) - sum(`compras`.`saldoPagado`) AS `pendiente` FROM `compras` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`IDarticulo`),
  ADD KEY `fkArticulosEstantes` (`estante`),
  ADD KEY `fkArticulosProveedores` (`IDproveedor`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`IDcliente`),
  ADD KEY `fkClientes` (`tipoCliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`IDcompra`);

--
-- Indices de la tabla `comprasdetalle`
--
ALTER TABLE `comprasdetalle`
  ADD PRIMARY KEY (`IDcompra`,`IDarticulo`),
  ADD KEY `fkComprasDetalleArticulos` (`IDarticulo`);

--
-- Indices de la tabla `estantes`
--
ALTER TABLE `estantes`
  ADD PRIMARY KEY (`IDestante`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`IDproveedor`);

--
-- Indices de la tabla `tipoclientes`
--
ALTER TABLE `tipoclientes`
  ADD PRIMARY KEY (`IDtipo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`IDventa`),
  ADD KEY `fkVentasProveedor` (`IDcliente`);

--
-- Indices de la tabla `ventasdetalle`
--
ALTER TABLE `ventasdetalle`
  ADD PRIMARY KEY (`IDventa`,`IDarticulo`),
  ADD KEY `fkVentasDetalleArticulos` (`IDarticulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `IDarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `IDcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `IDcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `estantes`
--
ALTER TABLE `estantes`
  MODIFY `IDestante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `IDproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipoclientes`
--
ALTER TABLE `tipoclientes`
  MODIFY `IDtipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `IDventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `fkArticulosEstantes` FOREIGN KEY (`estante`) REFERENCES `estantes` (`IDestante`),
  ADD CONSTRAINT `fkArticulosProveedores` FOREIGN KEY (`IDproveedor`) REFERENCES `proveedores` (`IDproveedor`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fkClientes` FOREIGN KEY (`tipoCliente`) REFERENCES `tipoclientes` (`IDtipo`);

--
-- Filtros para la tabla `comprasdetalle`
--
ALTER TABLE `comprasdetalle`
  ADD CONSTRAINT `fkComprasDetalleArticulos` FOREIGN KEY (`IDarticulo`) REFERENCES `articulos` (`IDarticulo`),
  ADD CONSTRAINT `fkComprasDetalleCompras` FOREIGN KEY (`IDcompra`) REFERENCES `compras` (`IDcompra`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fkVentasProveedor` FOREIGN KEY (`IDcliente`) REFERENCES `clientes` (`IDcliente`);

--
-- Filtros para la tabla `ventasdetalle`
--
ALTER TABLE `ventasdetalle`
  ADD CONSTRAINT `fkVentasDetalleArticulos` FOREIGN KEY (`IDarticulo`) REFERENCES `articulos` (`IDarticulo`),
  ADD CONSTRAINT `fkVentasDetalleVentas` FOREIGN KEY (`IDventa`) REFERENCES `ventas` (`IDventa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
