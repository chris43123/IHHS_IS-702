<?php

class Producto {
    private $id;
    private $codigo;
    private $nombre;
    private $IDproveedor;
    private $precio;
    private $impuesto;
    private $existencias;
    private $limite;
    private $caducidad;
    private $estante;
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }


    //Getter
    function getId(){
        return $this->id;
    }
    function getCodigo(){
        return $this->codigo;
    }
    function getNombre(){
        return $this->nombre;
    }
    function getIDproveedor(){
        return $this->IDproveedor;
    }
    function getPrecio(){
        return $this->precio;
    }
    function getImpuesto(){
        return $this->impuesto;
    }
    function getExistencias(){
        return $this->existencias;
    }
    function getLimite(){
        return $this->limite;
    }
    function getCaducidad(){
        return $this->caducidad;
    }
    function getEstante(){
        return $this->estante;
    }

    //Setter
    function setId($id){
        $this->id = $this->db->real_escape_string($id);
    }
    function setCodigo($codigo){
        $this->codigo = $this->db->real_escape_string($codigo);
    }
    function setNombre($nombre){
        $this->nombre = $this->db->real_escape_string($nombre);
    }
    function setIDproveedor($IDproveedor){
        $this->IDproveedor = $this->db->real_escape_string($IDproveedor);
    }
    function setPrecio($precio){
        $this->precio = $this->db->real_escape_string($precio);
    }
    function setImpuesto($impuesto){
        $this->impuesto = $this->db->real_escape_string($impuesto);
    }
    function setExistencias($existencias){
        $this->existencias = $this->db->real_escape_string($existencias);
    }
    function setLimite($limite){
        $this->limite = $this->db->real_escape_string($limite);
    }
    function setCaducidad($caducidad){
        $this->caducidad = $this->db->real_escape_string($caducidad);
    }
    function setEstante($estante){
        $this->estante = $this->db->real_escape_string($estante);
    }

    public function guardar(){
        $sql = "INSERT INTO articulos VALUES (NULL,'{$this->getCodigo()}', '{$this->getNombre()}', {$this->getIDproveedor()}, {$this->getPrecio()}, {$this->getImpuesto()}, 0, {$this->getLimite()}, '{$this->getCaducidad()}', {$this->getEstante()})";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function editar(){
        $sql = "UPDATE articulos SET codArticulo='{$this->getCodigo()}', Nombre='{$this->getNombre()}', IDproveedor={$this->getIDproveedor()}, precio={$this->getPrecio()}, impuesto={$this->getImpuesto()}, limite={$this->getLimite()}, caducidad='{$this->getCaducidad()}', estante={$this->getEstante()} WHERE codArticulo='{$this->getCodigo()}';";
        $guardar = $this->db->query($sql);

        $result = false;
        if($guardar){
            $result = true;
        }

        return $result;
    }

    public function getAll(){
        $productos = $this->db->query("CALL sparticulos();");
        return $productos;
    }

    public function getOneIndex(){
        $producto = $this->db->query("CALL sparticulo('{$this->codigo}');");
        return $producto;
    }

    public function getOne(){
        $producto = $this->db->query("CALL sparticulo('{$this->codigo}');");
        return $producto->fetch_object();
    }

    public function totalArticulos(){
        $productos = $this->db->query("SELECT * FROM vtotalarticulos;");
        return $productos->fetch_object();
    }

    public function existencias(){
        $productos = $this->db->query("SELECT * FROM vexistencias;");
        return $productos->fetch_object();
    }

    public function articulosBajas(){
        $productos = $this->db->query("SELECT * FROM varticulosbajas;");
        return $productos->fetch_object();
    }

    public function articulosAgotados(){
        $productos = $this->db->query("SELECT * FROM varticulosAgotados;");
        return $productos->fetch_object();
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