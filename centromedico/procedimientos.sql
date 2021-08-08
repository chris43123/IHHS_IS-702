--------------PROCEDIMEIENTOS ALMACENADOS----------------

--PROCEDIMIENTO ALMACENADO ARTICULOS--
CREATE PROCEDURE `sparticulos`() NOT DETERMINISTIC CONTAINS 
SQL SQL SECURITY DEFINER 
SELECT * FROM articulos

--PROCEDIMIENTO ALMACENADO ARTICULO INDIVIDUAL--
CREATE PROCEDURE `sparticulo`(IN `id` INT) 
NOT DETERMINISTIC CONTAINS 
SQL SQL SECURITY DEFINER 
select * from articulos where IDarticulo = id

--PROCEDIMIENTO ALMACENADO COMPRAS--
--SQL SERVER
CREATE PROCEDURE spcompras 
AS 
SELECT c.IDcompra as id, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
FROM compras as c 
INNER JOIN comprasdetalle as cd on cd.IDcompra = c.IDcompra 
INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo 
INNER JOIN proveedores as p on p.IDproveedor = a.IDproveedor
GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque

--MYSQL
	--ALL--
	CREATE PROCEDURE `spcompras`() NOT DETERMINISTIC CONTAINS 
	SQL SQL SECURITY DEFINER 
	SELECT c.IDcompra as id, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
	FROM compras as c 
	INNER JOIN comprasdetalle as cd on cd.IDcompra = c.IDcompra 
	INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo 
	INNER JOIN proveedores as p on p.IDproveedor = a.IDproveedor 
	GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque

	--ONE--
	CREATE PROCEDURE `spcompra`(IN `id` INT) NOT DETERMINISTIC CONTAINS 
	SQL SQL SECURITY DEFINER 
	SELECT c.IDcompra as id, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
	FROM compras as c 
	INNER JOIN comprasdetalle as cd on cd.IDcompra = c.IDcompra 
	INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo 
	INNER JOIN proveedores as p on p.IDproveedor = a.IDproveedor 
	WHERE c.IDcompra = id 
	GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque


--PROCEDIMIENTO ALMACENADO EXISTENCIA ARTICULO--
CREATE PROCEDURE `spcantcompra`(IN `id` INT, IN `cantidad` INT) 
NOT DETERMINISTIC CONTAINS 
SQL SQL SECURITY DEFINER 
UPDATE articulos SET existencias = existencias - cantidad 
WHERE IDarticulo = id

--PROCEDIMIENTO ALMACENADO VENTAS--
	--ALL--
	CREATE PROCEDURE `spventas`() NOT DETERMINISTIC CONTAINS 
	SQL SQL SECURITY DEFINER 
	SELECT v.IDventa as id, c.Nombre as nombreC, v.Fecha as fecha, sum(v.total) as total, sum(v.saldoPagado) as saldo 
	FROM ventas as v 
	INNER JOIN clientes as c on c.IDcliente = v.IDcliente
	GROUP BY v.IDventa, c.Nombre, v.Fecha

	--ONE--
	CREATE PROCEDURE `spventa`(IN `id` INT) NOT DETERMINISTIC CONTAINS 
	SQL SQL SECURITY DEFINER 
	SELECT v.IDventa as id, v.Fecha as fecha,sum(v.saldoPagado) as saldo 
	FROM ventas as v 
	WHERE v.IDventa = id
	GROUP BY v.IDventa, c.Nombre, v.Fecha

--PROCEDIMIENTO ALMACENADO CLIENTES--
	--ALL--
	CREATE PROCEDURE `spclientes`() 
	NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER 
	SELECT * FROM clientes

	--ONE--
	CREATE PROCEDURE `spcliente`(IN `id` INT) 
	NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER 
	SELECT * FROM clientes WHERE IDcliente = id

--PROCEDIMIENTO ALMACENADO COMPRAS DETALLE--
	--ALL--
	CREATE PROCEDURE `spcomprasdetalle`() 
	NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER 
	select cd.IDcompra as compra, a.Nombre as articulo, a.precio as precio, cd.cantidad as cantidad, (a.precio * cd.cantidad) as total 
	from comprasdetalle as cd 
	INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo

	--ONE--
	CREATE PROCEDURE `spcompradetalle`(IN `id` INT) 
	NOT DETERMINISTIC NO SQL SQL SECURITY DEFINER 
	select cd.IDcompra as compra, a.Nombre as articulo, a.precio as precio, cd.cantidad as cantidad, (a.precio * cd.cantidad) as total 
	from comprasdetalle as cd INNER JOIN articulos as a on a.IDarticulo = cd.IDarticulo WHERE cd.IDcompra = id