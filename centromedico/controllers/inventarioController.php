<?php
require_once 'models/inventario.php';

class inventarioController{

    //Funcion Index-Inventario
    public function index(){

        $producto = new Producto();
        $productos = $producto->getAll();

        $totalArticulo = new Producto();
        $totalArticulos = $totalArticulo->totalArticulos();

        $existencia = new Producto();
        $existencias = $existencia->existencias();

        $articulosBaja= new Producto();
        $articulosBajas = $articulosBaja->articulosBajas();

        $articulosAgotado= new Producto();
        $articulosAgotados = $articulosAgotado->articulosAgotados();

        //Vista Inventario
        require_once 'views/inventario/view-inventarios.php';
    }

    public function consultarUno(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];         
            $producto = new Producto();
            $producto->setCodigo($id);
            $productos = $producto->getOneIndex();
        }

        
        $totalArticulo = new Producto();
        $totalArticulos = $totalArticulo->totalArticulos();
        
        $existencia = new Producto();
        $existencias = $existencia->existencias();

        $articulosBaja= new Producto();
        $articulosBajas = $articulosBaja->articulosBajas();

        $articulosAgotado= new Producto();
        $articulosAgotados = $articulosAgotado->articulosAgotados();
        
        require_once 'views/inventario/view-inventarios.php';
    }

    //Funcion Ingreso - Inventario 
    public function ingresoDatos(){
        //Vista ingreso de producto
        require_once 'views/inventario/view-ingreso-inventario.php';
    }

    public function guardarDatos(){
        if(isset($_POST)){

            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $impuesto = $_POST['impuesto'];
            $caducidad = $_POST['caducidad'];
            $limite = $_POST['limite'];
            $estante = $_POST['estante'];
            $proveedor = $_POST['proveedor'];


            if($codigo && $nombre && $precio && $impuesto && $caducidad && $limite && $estante && $proveedor){
                $producto = new Producto();
                $producto->setCodigo($codigo);
                $producto->setNombre($nombre);
                $producto->setPrecio($precio);
                $producto->setImpuesto($impuesto);
                $producto->setCaducidad($caducidad);
                $producto->setLimite($limite);
                $producto->setEstante($estante);
                $producto->setIDproveedor($proveedor);
                
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $producto->setCodigo($id);
                    $guardar = $producto->editar();

                    if($guardar){
                        $_SESSION['mensaje'] = "Producto Actualizado Correctamente.";
                        $_SESSION['clase'] = "success";
                    } else {
                        $_SESSION['mensaje'] = "Error al actualizar el a producto.";
                        $_SESSION['clase'] = "danger";
                    } 
                } else {
                    $guardar = $producto->guardar();

                    if($guardar){
                        $_SESSION['mensaje'] = "Producto Registrado Correctamente.";
                        $_SESSION['clase'] = "success";
                    } else {
                        $_SESSION['mensaje'] = "Error al registrar el a producto.";
                        $_SESSION['clase'] = "danger";
                    } 
                }
                
                
                
            } else {
                    $_SESSION['mensaje'] = "Por favor ingrese los datos correctamente.";
                    $_SESSION['clase'] = "danger";
            }
        } else {
            $_SESSION['mensaje'] = "Error al registrar el b producto.";
            $_SESSION['mensaje'] = "danger";
        }
        header("Location:".base_url.'inventario/ingresoDatos');
    }


    public function editarDatos(){
       
        if(isset($_GET['id'])){
            $codigo = $_GET['id'];
            $edit = true;
            
            $productos = new Producto();
            $productos->setCodigo($codigo);
            
            $producto = $productos->getOne();

            require_once 'views/inventario/view-ingreso-inventario.php';

        } else {
            header('Location:'.base_url.'inventario/index');
        }

        
    }


    public function eliminarDatos(){
        if(isset($_GET['id'])){
            $codigo = $_GET['id'];
            $producto = new Producto();
            $producto->setCodigo($codigo);
            $delete = $producto->delete();
            if($delete) {
                $_SESSION['mensaje'] = 'Producto eliminado correctamente.';
                $_SESSION['clase'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó el producto.';
                $_SESSION['clase'] = 'danger';
            }
        } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó el producto.';
                $_SESSION['clase'] = 'danger';
        }
        header('Location:'.base_url.'inventario/index');
    }

}

?>