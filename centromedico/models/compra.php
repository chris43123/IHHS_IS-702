<?php

class Compra {
    private $idProd;
    private $id;
    private $nombreProveedor;
    private $IDproveedor;
    private $fecha;
    private $cheque;
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
    function getNombreProveedor(){
        return $this->nombreProveedor;
    }
    function getIDproveedor(){
        return $this->IDproveedor;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getCheque(){
        return $this->cheque;
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
    function setNombreProveedor($nombreProveedor){
        $this->nombreProveedor = $this->db->real_escape_string($nombreProveedor);
    }
    function setIDproveedor($IDproveedor){
        $this->IDproveedor = $this->db->real_escape_string($IDproveedor);
    }
    function setFecha($fecha){
        $this->fecha = $this->db->real_escape_string($fecha);
    }
    function setCheque($cheque){
        $this->cheque = $this->db->real_escape_string($cheque);
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

    public function guardarCompra(){
        $sql1 = "INSERT INTO compras VALUES ({$this->getID()}, {$this->getIDproveedor()},'{$this->getFecha()}', {$this->getCheque()}, {$this->getTotal()}, {$this->getSaldoPagado()})";
        $guardar = $this->db->query($sql1);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function guardarCompraDetalle(){
        $sql2 = "INSERT INTO comprasdetalle VALUES ({$this->getID()}, {$this->getIDprod()}, {$this->getCantidad()})";
        $guardar = $this->db->query($sql2);

        $result = false;
        if($guardar){
            $result = true;
        }
        return $result;
    }

    public function editarCompra(){
        $sql = "UPDATE compras SET fecha='{$this->getFecha()}', IDproveedor = {$this->getIDproveedor()}, numeroCheque={$this->getCheque()}, saldoPagado={$this->getSaldoPagado()} WHERE IDcompra={$this->getID()};";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function deleteCompra(){
        $sql = "DELETE FROM compras WHERE IDcompra = '{$this->id}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }

    public function deleteCompraDetalle(){
        $sql = "DELETE FROM comprasDetalle WHERE IDcompra = '{$this->id}' AND IDarticulo = '{$this->IDprod}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }

    public function getAll(){
        $compras = $this->db->query("CALL spcompras();");
        return $compras;
    }

    public function getAllCD(){
        $compras = $this->db->query("CALL spcomprasdetalle();");
        return $compras;
    }

    public function getOne(){
        $compra = $this->db->query("CALL spcompra({$this->id});");
        return $compra->fetch_object();
    }

    public function getOneCD(){
        $compra = $this->db->query("CALL spcompradetalle({$this->id});");
        return $compra->fetch_object();
    }

    public function getOneIndex(){
        $compra = $this->db->query("CALL spcompra({$this->id});");
        return $compra;
    }

    public function getOneIndexCD(){
        $compra = $this->db->query("CALL spcompradetalle({$this->id});");
        return $compra;
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