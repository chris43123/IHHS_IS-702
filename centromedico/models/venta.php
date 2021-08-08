<?php

class Venta {
    private $idProd;
    private $id;
    private $nombreCliente;
    private $IDcliente;
    private $fecha;
    private $saldoPagado;
    private $total;
    private $saldoPendiente;
    private $cantidad;

    //Funcion DATABASE
    public function __construct(){
        $this->db = Database::connect();
    }

    //Getter
    function getIDprod(){
        return $this->IDprod;
    }
    function getID(){
        return $this->id;
    }
    function getNombreCliente(){
        return $this->nombreCliente;
    }
    function getIDcliente(){
        return $this->IDcliente;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getTotal(){
        return $this->total;
    }
    function getSaldoPagado(){
        return $this->saldoPagado;
    }
    function getSaldoPendiente(){
        return $this->saldoPendiente;
    }
    function getCantidad(){
        return $this->cantidad;
    }

    //Setter
    function setIDprod($idProd){
        $this->IDprod = $this->db->real_escape_string($idProd);
    }
    function setID($id){
        $this->id = $this->db->real_escape_string($id);
    }
    function setNombreCliente($nombreCliente){
        $this->nombreCliente = $this->db->real_escape_string($nombreCliente);
    }
    function setIDcliente($IDcliente){
        $this->IDcliente = $this->db->real_escape_string($IDcliente);
    }
    function setFecha($fecha){
        $this->fecha = $this->db->real_escape_string($fecha);
    }
    function setTotal($total){
        $this->total = $this->db->real_escape_string($total);
    }
    function setSaldoPagado($saldoPagado){
        $this->saldoPagado = $this->db->real_escape_string($saldoPagado);
    }

    function setCantidad($cantidad){
        $this->cantidad = $this->db->real_escape_string($cantidad);
    }

    public function guardarVenta(){
        $sql1 = "INSERT INTO ventas VALUES ({$this->getID()}, {$this->getIDcliente()},'{$this->getFecha()}', {$this->getSaldoPagado()}, {$this->getTotal()})";
        $guardar = $this->db->query($sql1);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function guardarVentaDetalle(){
        $sql2 = "INSERT INTO ventasdetalle VALUES ({$this->getID()}, {$this->getIDprod()}, {$this->getCantidad()})";
        $guardar = $this->db->query($sql2);

        $result = false;
        if($guardar){
            $result = true;
        }
        return $result;
    }

    public function editarVenta(){
        $sql = "UPDATE ventas SET fecha='{$this->getFecha()}', saldoPagado={$this->getSaldoPagado()} WHERE IDventa={$this->getID()};";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function deleteVenta(){
        $sql = "DELETE FROM ventas WHERE IDventa = '{$this->id}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }

    public function deleteVentaDetalle(){
        $sql = "DELETE FROM ventasDetalle WHERE IDventa = '{$this->id}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }

    public function getAll(){
        $ventas = $this->db->query("CALL spventas();");
        return $ventas;
    }

    public function getAllCD(){
        $ventas = $this->db->query("CALL spventasdetalle();");
        return $ventas;
    }

    public function getOne(){
        $venta = $this->db->query("CALL spventa({$this->id});");
        return $venta->fetch_object();
    }

    public function getOneCD(){
        $venta = $this->db->query("CALL spventadetalle({$this->id});");
        return $venta->fetch_object();
    }

    public function getOneIndex(){
        $venta = $this->db->query("CALL spventa({$this->id});");
        return $venta;
    }


    public function totalCompras(){
        $compras = $this->db->query("SELECT * FROM vtotalcompras;");
        return $compras->fetch_object();
    }

    public function totalPagos(){
        $compras = $this->db->query("SELECT * FROM vtotalpagos;");
        return $compras->fetch_object();
    }

    public function totalPendientes(){
        $compras = $this->db->query("SELECT * FROM vtotalpendientes;");
        return $compras->fetch_object();
    }

    public function totalComprasMes(){
        $compras = $this->db->query("SELECT * FROM vtotalcomprasmes;");
        return $compras->fetch_object();
    }

    public function delete(){
        $sql = "DELETE FROM articulos WHERE codArticulo = '{$this->codigo}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }
}

?>