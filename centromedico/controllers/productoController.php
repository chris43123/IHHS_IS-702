<?php
require_once 'models/inventario.php';

class productoController{

    //Funcion Index-Inventario
    public function index(){ 
        require_once 'views/inventario/view-consultar-producto.php'; 
    }

    public function consultarProducto(){

        //VERIFICAR SI EXISTE VALOR EN POST
        if(isset($_POST['IDProd']) && $_POST['IDProd'] != ''){
            //var_dump($_SESSION['Idprod']);
            $codigo = $_POST['IDProd'];
            //CONSULTAR PRODUCTO
            $producto = new Producto();
            $producto->setCodigo($codigo);
            $producto = $producto->getOne();

            if(is_object($producto)){
                $producto = array(
                    "id" => $producto->IDarticulo,
                    "codigo" => $producto->codArticulo,
                    "nombre" => $producto->Nombre,
                    "proveedor" => $producto->IDproveedor,
                    "existencias" => $producto->existencias,
                    "estante" => $producto->estante,
                    "precio" => $producto->precio,
                    "cantidad" => 1,
                    "total" => $producto->precio
                );
                $_SESSION['mensaje'] = "Busqueda realizada con éxito.";
                $_SESSION['clase'] = "success";
            } else {
                var_dump($_SESSION['Idprod']);
                $_SESSION['mensaje'] = "No existe el producto.";
                $_SESSION['clase'] = "danger";
            }

            if(isset($_SESSION['producto'])){
                unset($_SESSION['producto']);
                $_SESSION['producto'] =  $producto;
            } else {
                $_SESSION['producto'] =  $producto;
            }
            header("Location:".base_url."producto/index");

        } else {
            $_SESSION['mensaje'] = "No se ha ingresado el código del producto.";
            $_SESSION['clase'] = "danger";
            header("Location:".base_url.'producto/index');
        }

         
    }   

    public function obtenerProductos(){
                //VERIFICAR SI EXISTE VALOR EN POST
                if(isset($_POST['cantidad']) && $_POST['cantidad'] != 0){
                    $cantidad = $_POST['cantidad'];

                    
                    if(isset($_SESSION['producto'])){
                        $precio = $_SESSION['producto']['precio'];
                    } else {
                        $precio = 0;
                    }


                    //VERIFICAR SI LA SESSION DE LISTADO EXISTE
                    if(isset($_SESSION['listado'])){
        
                        $num = count($_SESSION['listado']); //CONTADOR DEL ARREGLO    
                        $_SESSION['listado'][$num] =  $_SESSION['producto'];
                        $_SESSION['listado'][$num]['cantidad'] = $cantidad;
                        $_SESSION['listado'][$num]['total'] = $cantidad*$precio;
                        unset($_SESSION['producto']);
            
                    } else {
                        $_SESSION['listado'][0] =  $_SESSION['producto'];
                        $_SESSION['listado'][0]['cantidad'] = $cantidad;
                        $_SESSION['listado'][0]['total'] = $cantidad * $precio;
                        unset($_SESSION['producto']);
                    }
                
                    header("Location:".base_url."producto/index");
                    //require_once 'views/inventario/view-consultar-producto.php'; 
                } else {
                    $_SESSION['mensaje'] = "Inserte una cantidad mayor a cero.";
                    $_SESSION['clase'] = "warning";
                    header("Location:".base_url.'producto/index');
                }

    }

    public function deleteAll(){
        session_destroy();
        header("Location:".base_url."principal/index");
    }
}
?>