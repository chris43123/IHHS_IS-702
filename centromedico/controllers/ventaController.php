<?php
require_once 'models/venta.php';
require_once 'models/cliente.php';

class ventaController{
    public function index(){
        $venta = new Venta();
        $ventas = $venta->getAll();

        $ventaD = new Venta();
        $ventasD = $ventaD->getAllCD();

        require_once 'views/venta/view-ventas.php';
    }

    public function consultarProductos(){
        $_SESSION['accion'] = 'v';
        require_once 'views/inventario/view-consultar-producto.php';
    }

    public function consultarUno(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];         
            $venta= new Venta();
            $venta->setID($id);
            $ventas = $venta->getOneIndex();
        }
        require_once 'views/venta/view-ventas.php';
    }

    public function tipoCliente(){
        if($_POST['cliente'] == 1){
            $_SESSION['suscrito'] = 1;
            require_once 'views/venta/view-cliente-suscrito.php';
        } else if($_POST['cliente'] == 2) {
            header("Location:".base_url.'venta/ingresarVenta');
        } else if($_POST['cliente'] == 0){
            $_SESSION['mensaje'] = "No se ha seleccionado el tipo de cliente.";
            $_SESSION['clase'] = "warning";
            header("Location:".base_url.'venta/consultarProductos');
        }
    }

    public function obtenerCliente(){
        if(isset($_POST['idCliente'])){

            $clientes = new Cliente();
            $clientes->setID($_POST['idCliente']);
            $cliente = $clientes->getOne();
            $_SESSION['suscrito'];

            require_once 'views/venta/view-cliente-suscrito.php';
        }
    }

    public function ingresarVenta(){

        if(isset($_SESSION['listado'])){
            $listado = $_SESSION['listado'];
            $totalVenta = 0;

            //Recorrer Listado
            foreach($listado as $indice => $producto){
                $totalVenta = $totalVenta + $producto['total'];
            }
            
            if(isset($_GET['cliente'])){
                $_SESSION['idCliente'] = $_GET['cliente'];
            }

            $_SESSION['totalVenta']=$totalVenta;

        } else {
            $_SESSION['mensaje'] = "No se han agregado productos";
            $_SESSION['clase'] = "warning";
            header("Location:".base_url.'venta/consultarProductos');
        }

        require_once 'views/venta/view-ingreso-ventas.php';
    }

    public function guardarDatos(){
        //var_dump($_SESSION['listado']);
        // $listado = $_SESSION['listado'];
        
        if(isset($_POST)){
            //CLIENTE
            if(isset($_SESSION['idCliente'])){
                $idCliente = $_SESSION['idCliente'];
            } else {
                $idCliente = $_POST['idCliente'];
            }
            $nombre = $_POST['nombre'];
            $direccion = $_POST['direccion'];
            $tipo = $_POST['tipo'];


            $idVenta = $_POST['idVenta'];
            $fecha = $_POST['fecha'];
            $saldo = $_POST['saldo'];

            $venta = new Venta();
            $venta->setID($idVenta);
            $venta->setIDcliente($idCliente);
            $venta->setFecha($fecha);
            $venta->setTotal($_SESSION['totalVenta']);
            $venta->setSaldoPagado($saldo);

            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $venta->setID($id);
                $guardar = $venta->editarVenta();
                // var_dump($compra);
                // require_once 'views/compra/view-ingreso-compras.php';

                if($guardar){
                    $_SESSION['mensaje'] = "Venta actualizada correctamente.";
                    $_SESSION['clase'] = "success";
                } else {
                    $_SESSION['mensaje'] = "Error al actualizar la venta.";
                    $_SESSION['clase'] = "danger";
                } 
                    
            } else {
                $valor=0;

                if(isset($_SESSION['idCliente'])){
                    $valor=1;
                } else {
                    $cliente = new Cliente();
                    $cliente->setID($idCliente);
                    $cliente->setNombre($nombre);
                    $cliente->setDireccion($direccion);
                    $cliente->setTipo($tipo);
                    $guardarCliente = $cliente->guardarCliente();
                    if($guardarCliente){
                        $valor = 2;
                    }else{
                        $_SESSION['mensaje'] = "Error al guardar el cliente.";
                        $_SESSION['clase'] = "danger";
                    }
                }
                

                if($valor == 1 || $valor == 2){
                    if(isset($_SESSION['listado'])){
                        $listado = $_SESSION['listado'];
                        $guardar = $venta->guardarVenta();
    
                        if($guardar){
                            foreach($listado as $indice => $producto){
                                $ventaDetalle = "";
                                $ventaDetalle = new Venta();
                                $ventaDetalle->setIDprod($producto['id']);
                                $ventaDetalle->setID($idVenta);
                                $ventaDetalle->setCantidad($producto['cantidad']);
    
                                $guardar2 = $ventaDetalle->guardarVentaDetalle();
                                if($guardar2){
                                    $_SESSION['mensaje'] = "Venta Registrada Correctamente.";
                                    $_SESSION['clase'] = "success";
                                } else {
                                    $_SESSION['mensaje'] = "Error al registrar la venta detalle.";
                                    $_SESSION['clase'] = "danger";
                                } 
                            }
                        } else {
                            $_SESSION['mensaje'] = "Error al registrar la venta.";
                            $_SESSION['clase'] = "danger";
                        }
                    } else {
                        $_SESSION['mensaje'] = "No se han agregado productos.";
                        $_SESSION['clase'] = "warning";   
                    }
                } 
            }              
            
        } else {
            $_SESSION['mensaje'] = "No se ha enviado la información de venta.";
            $_SESSION['clase'] = "danger";
        }
        unset($_SESSION['listado']);
        unset($_SESSION['producto']);
        unset($_SESSION['totalVenta']);
        $_SESSION['test'] = $_GET['cliente'];
        header("Location:".base_url.'venta/index');
        
    }

    public function editarDatos(){
       
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $edit = true;
            
            $ventas = new Venta();
            $ventas->setID($id);
            
            $venta = $ventas->getOne();

            require_once 'views/venta/view-ingreso-ventas.php';

        } else {
            header('Location:'.base_url.'venta/index');
        }

        
    }

    public function eliminarDatos(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $venta = new Venta();
            $venta->setID($id);
            $delete1 = $venta->deleteVentaDetalle();
            if($delete1) {
                $delete2 = $venta->deleteVenta();
                if($delete2){
                    $_SESSION['mensaje'] = 'Venta eliminada correctamente.';
                    $_SESSION['clase'] = 'warning';
                } else {
                    $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó la venta.';
                    $_SESSION['clase'] = 'danger';
                }
            } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó la venta.';
                $_SESSION['clase'] = 'danger';
            }
        } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó la venta.';
                $_SESSION['clase'] = 'danger';
        }
        header('Location:'.base_url.'venta/index');
    }

    public function eliminarDatosVD(){
        if(isset($_GET['id']) && isset($_GET['art'])){
            $id = $_GET['id'];
            $art = $_GET['art'];
            $venta = new Venta();
            $venta->setID($id);
            $venta->setIDprod($art);
            $delete1 = $venta->deleteVentaDetalle();
        } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó la venta.';
                $_SESSION['clase'] = 'danger';
        }
        header('Location:'.base_url.'venta/index');
    }

}

?>