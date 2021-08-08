<!--Contenido-->
<div class="formulario">

    <div class="row form-buscar-producto">
        <div class="col-md-6">
            <h1>Consulta de Producto</h1>
            <a href="<?=base_url?>producto/deleteAll" class="btn btn-eliminar float-end">Cerrar<i class="bi bi-x-square-fill"></i></a>

        <!-- FORMULARIO DE BUSQUEDA DE PRODUCTO -->
            <form action="<?=base_url?>producto/consultarProducto" method="POST" role="form">
                <div class="mb-3">
                    <label for="" class="form-label">Producto</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="" name="IDProd">
                        <input type="submit" class="btn btn-outline-secondary btn-editar" value="Buscar">
                    </div>
                    <?php if($_SESSION['accion'] == 'c'):?>
                            <div id="" class="form-text">Ingrese el codigo del producto del cual desea hacer pedido a los proveedores.</div> 
                    <?php elseif($_SESSION['accion'] == 'v') :?>
                            <div id="" class="form-text">Ingrese el codigo del producto del cual desea realizar la venta.</div>
                    <?php endif;?>
                                       
                </div>
            </form>

             <!--Contralar datos Sesion-->
            <?php
                if(isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['clase']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php  
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['clase']);
            } ?>
            
            <!--Mostrar informacion producto y añadir cantidad-->
            <div class="info-producto p-20 mb-5">
                <?php if(isset($_SESSION['producto'])) { ?>
                    <div class="">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary"><strong>Detalle Producto</strong></li>
                            <li class="list-group-item"><span class="text-primary">Producto: </span><?= $_SESSION['producto']['codigo'] ?> </li>
                            <li class="list-group-item"><span class="text-primary">Proveedores: </span><?= $_SESSION['producto']['proveedor'] ?> </li>
                            <li class="list-group-item"><span class="text-primary">Existencias: </span><?= $_SESSION['producto']['existencias'] ?> </li>
                            <li class="list-group-item"><span class="text-primary">Estante: </span><?= $_SESSION['producto']['estante'] ?> </li>
                            <li class="list-group-item"><span class="text-primary">Precio: </span><?= $_SESSION['producto']['precio'] ?> </li>
                            <li class="list-group-item"><span class="text-primary">
                                <form action="<?=base_url?>producto/obtenerProductos" method="POST" role="form">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Cantidad</span>
                                        <input type="text" class="form-control" id="" name="cantidad" required>
                                        <input type="submit" class="btn btn-outline-secondary btn-editar" value="Añadir">
                                    </div>
                                </form>
                            </li>  
                        </ul>
                    </div>
                <?php } ?>
            </div>
                

            <?php 
                if($_SESSION['accion'] == 'c'){
                    $url_action = base_url."compra/ingresarCompra";
                } elseif($_SESSION['accion'] == 'v') {
                    $url_action = base_url."venta/tipoCliente";
                }
                
            ?>
                
            <!--Imprimir productos-->
            <form action="<?=$url_action?>" method="POST">
                <div class="row tabla">
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr class="table-dark">
                                <td colspan="8" class="text-center">Detalle Compra</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Existencias</th>
                            <th scope="col">Estante</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php if(isset($_SESSION['listado'])) { 
                        
                            foreach($_SESSION['listado']  as $indice => $producto){
                        ?>

                            <tr>
                                <th scope="row"><?=$producto['codigo']?></th>
                                <td><?=$producto['nombre']?></td>
                                <td><?=$producto['proveedor']?></td>
                                <td><?=$producto['existencias']?></td>
                                <td><?=$producto['estante']?></td>
                                <td><?=$producto['cantidad']?></td>
                                <td><?=$producto['precio']?></td>
                                <td><?=$producto['total']?></td>
                            </tr>
                        
                        <?php  }
                        } ?>                        
            
                        </tbody>
                    </table>
                </div>

                    <?php if($_SESSION['accion'] == 'c'):?>
                        <input type="submit" class="btn btn-nuevo mb-5" value="Ingresar Compra" >
                    <?php elseif($_SESSION['accion'] == 'v') :?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="cliente">Cliente</label>
                            </div>
                            <select class="custom-select" id="cliente" name="cliente">
                                <option selected value="0">Elegir...</option>
                                <option value="1">Cliente Suscrito</option>
                                <option value="2">Cliente Nuevo</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-nuevo mb-5" value="Ingresar Venta" >
                    <?php endif;?>
                
            </form>
            

            
        </div>
    </div>
</div>