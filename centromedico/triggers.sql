----------TRIGGERS--------------

--TRIGGER INSERTAR COMPRAS | COMPRASDETALLE  - ACTUALIZAR EXISTENCIAS ARTICULOS--

    --SQL-SERVER
    CREATE TRIGGER trgInsertarCompraDetalle on comprasDetalle FOR INSERT
    AS
        DECLARE @articuloid INT, @cantidad FLOAT

        SELECT @articuloid = IDarticulo, @cantidad = cantidad FROM inserted


        UPDATE Articulos
            SET existencias = @cantidad + existencias
            WHERE IDarticulo = @articuloid
    go

    --MYSQL--
    CREATE TRIGGER `trgInsertarCompraDetalle` BEFORE INSERT ON `comprasdetalle` 
    FOR EACH ROW 
    UPDATE Articulos 
    SET existencias = NEW.cantidad + existencias WHERE IDarticulo = NEW.IDarticulo


--TRIGGER BORRAR COMPRAS | COMPRASDETALLE  - ACTUALIZAR EXISTENCIAS ARTICULOS--
CREATE TRIGGER `trgBorrarCompraDetalle` 
BEFORE DELETE ON `comprasdetalle` 
FOR EACH ROW 
CALL spcantcompra(OLD.IDarticulo, OLD.cantidad)


--TRIGGER INSERTAR COMPRAS | COMPRASDETALLE  - ACTUALIZAR SALDO PROVEEDORES--
CREATE TRIGGER `trgsaldoprov` BEFORE INSERT ON `compras` 
FOR EACH ROW 
UPDATE proveedores 
SET saldoCrediticio = saldoCrediticio -(NEW.total-NEW.saldoPagado) 
WHERE IDproveedor = NEW.IDproveedor