--------------VISTAS----------------

--VISTA TOTAL COMPRAS--
CREATE VIEW vtotalcompras 
AS 
SELECT SUM(total) AS total 
FROM compras

--VISTA TOTAL PAGOS--
CREATE VIEW vtotalpagos
AS 
SELECT SUM(saldoPagado) AS pagos 
FROM compras

--VISTA TOTAL PENDIENTES--
CREATE VIEW vtotalpendientes
AS 
SELECT (SUM(total)-SUM(saldoPagado)) AS pendiente
FROM compras

--VISTA TOTAL COMPRAS MES--
CREATE VIEW vtotalcomprasmes 
AS 
SELECT SUM(total) AS total 
FROM compras
WHERE MONTH(fecha) = MONTH(CURRENT_DATE())
AND YEAR(fecha) = YEAR(CURRENT_DATE())

--VISTA TOTAL ARTICULOS--
CREATE VIEW vtotalarticulos 
AS SELECT COUNT(*) AS totalArticulos 
FROM articulos

--VISTA TOTAL ARTICULOS AGOTADOS--
CREATE VIEW varticulosagotados
AS SELECT COUNT(*) AS articulosagotados
FROM articulos WHERE existencias = 0

--VISTA TOTAL ARTICULOS EXISTENCIAS BAJAS--
CREATE VIEW varticulosbajas
AS SELECT COUNT(*) AS articulosbajas
FROM articulos WHERE existencias <= 20

--VISTA TOTAL EXISTENCIAS-
CREATE VIEW vexistencias
AS SELECT SUM(existencias) AS existencias
FROM articulos

--VISTA INVENTARIO--
CREATE VIEW vArticulos
as
SELECT * FROM articulos

--VISTA COMPRAS--
CREATE VIEW vcompras 
AS 
SELECT c.IDcompra as id, p.Nombre as nombreP, c.Fecha as fecha, c.numeroCheque as cheque, sum(c.total) as total, sum(c.saldoPagado) as saldo 
FROM compras as c 
INNER JOIN comprasdetalle as cd on cd.IDcompra = c.IDcompra 
LEFT JOIN articulos as a on a.IDarticulo = cd.IDarticulo 
INNER JOIN proveedores as p on p.IDproveedor = a.IDproveedor
GROUP BY c.IDcompra, p.Nombre, c.Fecha, c.numeroCheque