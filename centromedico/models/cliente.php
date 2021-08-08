<?php

class Cliente {
    private $id;
    private $nombre;
    private $direccion;
    private $tipo;
    private $saldoCrediticio;

    //Funcion DATABASE
    public function __construct(){
        $this->db = Database::connect();
    }


    //Getter
    function getID(){
        return $this->id;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getDireccion(){
        return $this->direccion;
    }
    function getTipo(){
        return $this->tipo;
    }
    function getSaldoCrediticio(){
        return $this->saldoCrediticio;
    }

    //Setter
    function setID($id){
        $this->id = $this->db->real_escape_string($id);
    }
    function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }
    function setDireccion($direccion){
        $this->direccion = $this->db->real_escape_string($direccion);
    }
    function setTipo($tipo){
        $this->tipo = $this->db->real_escape_string($tipo);
    }
    function setSaldoCrediticio($saldoCrediticio){
        $this->saldoCrediticio = $this->db->real_escape_string($saldoCrediticio);
    }

    public function guardarCliente(){
        $sql = "INSERT INTO clientes VALUES ({$this->getID()}, '{$this->getNombre()}','{$this->getDireccion()}', {$this->getTipo()}, 0)";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function editarCliente(){
        $sql = "UPDATE clientes SET IDcliente = {$this->getID()}, nombre='{$this->getNombre()}', direccion = '{$this->getDireccion()}', tipo={$this->getTipo()}, saldoCrediticio={$this->getSaldoCrediticio()} WHERE IDcliente={$this->getID()};";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function deleteCompra(){
        $sql = "DELETE FROM clientes WHERE IDcliente= '{$this->id}'";
        $delete = $this->db->query($sql);

        $result = false;
        if($delete){
            $result = true;
        }

        return $result;
    }

    public function getAll(){
        $clientes = $this->db->query("CALL spclientes();");
        return $clientes;
    }

    public function getOne(){
        $cliente = $this->db->query("CALL spcliente({$this->id});");
        return $cliente->fetch_object();
    }

    public function getOneIndex(){
        $cliente = $this->db->query("CALL spcliente({$this->id});");
        return $cliente;
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