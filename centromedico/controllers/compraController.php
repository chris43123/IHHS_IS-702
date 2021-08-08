<?php
require_once 'models/compra.php';

class compraController{
    
    public function index(){
        $compra = new Compra();
        $compras = $compra->getAll();

        $compraD = new Compra();
        $comprasD = $compraD->getAllCD();

        $total = new Compra();
        $totalCompras = $total->totalCompras();

        $pagos = new Compra();
        $totalPagos = $pagos->totalPagos();

        $pendientes = new Compra();
        $totalpendientes = $pendientes->totalPendientes();

        $totalMes = new Compra();
        $totalComprasMes = $totalMes->totalComprasMes();

        require_once 'views/compra/view-compras.php';
    }

    public function consultarUno(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];         
            $compra = new Compra();
            $compra->setID($id);
            $compras = $compra->getOneIndex();
        }

        $total = new Compra();
        $totalCompras = $total->totalCompras();

        $pagos = new Compra();
        $totalPagos = $pagos->totalPagos();

        $pendientes = new Compra();
        $totalpendientes = $pendientes->totalPendientes();

        $totalMes = new Compra();
        $totalComprasMes = $totalMes->totalComprasMes();
        
        require_once 'views/compra/view-compras.php';
    }

    public function consultarUnoCD(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];         
            $compra = new Compra();
            $compra->setID($id);
            $compras = $compra->getOneIndexCD();
        }

        $total = new Compra();
        $totalCompras = $total->totalCompras();

        $pagos = new Compra();
        $totalPagos = $pagos->totalPagos();

        $pendientes = new Compra();
        $totalpendientes = $pendientes->totalPendientes();

        $totalMes = new Compra();
        $totalComprasMes = $totalMes->totalComprasMes();
        
        require_once 'views/compra/view-compras.php';
    }

    public function ingresarCompra(){

        if(isset($_SESSION['listado'])){
            $listado = $_SESSION['listado'];
            $totalCompra = 0;

            //Recorrer Listado
            foreach($listado as $indice => $producto){
                $totalCompra = $totalCompra + $producto['total'];
            }
            $_SESSION['totalCompra']=$totalCompra;

        } else {
            $_SESSION['mensaje'] = "No se han agregado productos";
            $_SESSION['clase'] = "warning";
            header("Location:".base_url.'compra/consultarProductos');
        }

        require_once 'views/compra/view-ingreso-compras.php';
    }

    public function guardarDatos(){
        //var_dump($_SESSION['listado']);
        // $listado = $_SESSION['listado'];
        if(isset($_POST)){
            $idCompra = $_POST['idCompra'];
            $idProveedor = $_POST['idProveedor'];
            $fecha = $_POST['fecha'];
            $cheque = $_POST['cheque'];
            $saldo = $_POST['saldo']; 

            $compra = new Compra();
            $compra->setID($idCompra);
            $compra->setIDproveedor($idProveedor);
            $compra->setFecha($fecha);
            $compra->setCheque($cheque);
            $compra->setTotal($_SESSION['totalCompra']);
            $compra->setSaldoPagado($saldo);

            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $compra->setID($id);
                $guardar = $compra->editarCompra();
                // var_dump($compra);
                // require_once 'views/compra/view-ingreso-compras.php';

                if($guardar){
                    $_SESSION['mensaje'] = "Compra actualizada correctamente.";
                    $_SESSION['clase'] = "success";
                } else {
                    $_SESSION['mensaje'] = "Error al actualizar la compra.";
                    $_SESSION['clase'] = "danger";
                } 
                    
            } else {
                if(isset($_SESSION['listado'])){
                    $listado = $_SESSION['listado'];
                    $guardar = $compra->guardarCompra();

                    if($guardar){
                        foreach($listado as $indice => $producto){
                            $compraDetalle = "";
                            $compraDetalle = new Compra();
                            $compraDetalle->setIDprod($producto['id']);
                            $compraDetalle->setID($idCompra);
                            $compraDetalle->setCantidad($producto['cantidad']);

                            $guardar2 = $compraDetalle->guardarCompraDetalle();
                            if($guardar2){
                                $_SESSION['mensaje'] = "Compra Registrada Correctamente.";
                                $_SESSION['clase'] = "success";
                            } else {
                                $_SESSION['mensaje'] = "Error al registrar la compra detalle.";
                                $_SESSION['clase'] = "danger";
                            } 
                        }
                    } else {
                        $_SESSION['mensaje'] = "Error al registrar la compra.";
                        $_SESSION['clase'] = "danger";
                    }
                } else {
                    $_SESSION['mensaje'] = "No se han agregado productos.";
                    $_SESSION['clase'] = "warning";   
                }
            }              
            
        } else {
            $_SESSION['mensaje'] = "No se ha enviado la información de compra.";
            $_SESSION['clase'] = "danger";
        }
        unset($_SESSION['listado']);
        unset($_SESSION['producto']);
        unset($_SESSION['totalCompra']);
        header("Location:".base_url.'compra/index');
        
    }

    public function editarDatos(){
       
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $edit = true;
            
            $compras = new Compra();
            $compras->setID($id);
            
            $compra = $compras->getOne();

            require_once 'views/compra/view-ingreso-compras.php';

        } else {
            header('Location:'.base_url.'compra/index');
        }

        
    }

    public function eliminarDatos(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $compra = new Compra();
            $compra->setID($id);
            $delete = $compra->deleteCompra();
        } else {
                $_SESSION['mensaje'] = 'Ocurrio un error, no se eliminó la compra.';
                $_SESSION['clase'] = 'danger';
        }
        header('Location:'.base_url.'compra/index');
    }

    public function eliminarDatosCD(){
        if(isset($_GET['id']) && isset($_GET['art'])){
            $id = $_GET['id'];
            $art = $_GET['art'];
            $compra = new Compra();
            $compra->setID($id);
            $compra->setIDprod($art);
            
            $delete = $compra->deleteCompraDetalle();
        } else {
                $_SESSION['mensaje'] = $_GET['art'] . "test";
                $_SESSION['clase'] = 'danger';
        }
        header('Location:'.base_url.'compra/index');
    }

    public function consultarProductos(){
        $_SESSION['accion'] = 'c';
        require_once 'views/inventario/view-consultar-producto.php';
    }


}

?>