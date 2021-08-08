
<div class="resumen-compras">
    <h1>Gestión de Ventas</h1>
    <!--Contralar datos Sesion-->
    <?php
        if(isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['clase']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php session_unset(); } ?>
    
    <div class="row">
        <a href="<?= base_url ?>venta/consultarProductos" class="btn btn-nuevo">Nueva Venta<i class="bi bi-pencil-fill"></i></a>
    </div>
    <div class="row tarjetas-compras">
        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t1">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. 14,500.00</h1>
                    <p>Total Ventas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t2">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. 1,350.00</h1>
                    <p>Devoluciones</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t3">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. 13,140.00</h1>
                    <p>Ultimo Mes</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t4">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>14,540.00</h1>
                    <p>Total Ventas</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="contenido-tablas">
    <h2>Contenido de Ventas</h2>
    <div class="row filtros">       

        <div class="col-md-6 buscar">
            <form action="<?=base_url?>venta/consultarUno" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control input-buscar" placeholder="Buscar..." name="id"> 
                    <input type="submit" class="input-group-text icono" id="" value="Buscar">
                </div>
            </form>
        </div>
    </div>
    <div class="row tabla">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">No. Venta</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                <th scope="col">Saldo Pagado</th>
                <th scope="col">Saldo Pendiente</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $ventas->fetch_object()):?>

                <tr>
                    <th scope="row"> <?=$row->id; ?> </th>
                    <td> <?=$row->nombreC;?> </td>
                    <td> <?=$row->fecha;?> </td>
                    <td>L. <?=number_format($row->total,2);?> </td>
                    <td>L. <?=number_format($row->saldo,2);?> </td>
                    <td>L. <?=number_format(($row->total - $row->saldo),2);?> </td>
                    <td>
                        <a href="<?=base_url?>venta/editarDatos&id=<?=$row->id?>" class="btn btn-editar">Editar<i class="bi bi-pencil-square"></i></a>
                        <a href="<?=base_url?>venta/eliminarDatos&id=<?=$row->id?>" class="btn btn-eliminar">Eliminar<i class="bi bi-x-square-fill"></i></a>
                    </td>
                </tr>

                <?php endwhile; ?>
                
            </tbody>
            </table>
    </div>
</div>

<div class="contenido-tablas">
    <h2>Contenido de Ventas Detalle</h2>
    <div class="row filtros">       
        <div class="col-md-6 buscar">
            <form action="<?=base_url?>compra/consultarUnoVD" method="POST">
                <div class="input-group mb-3">
                    <input type="number" class="form-control input-buscar" name="id" placeholder="Buscar..." required>
                    <input type="submit" class="input-group-text icono" id="" value="Buscar">
                </div>
            </form>
        </div>
    </div>
    <div class="row tabla">
        <table class="table table-hover  table-responsive">
            <thead>
                <tr>
                <th scope="col">No. Venta</th>
                <th scope="col">Articulo</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Total</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = $ventasD->fetch_object()):?>

                <tr>
                    <th scope="row"> <?=$row->venta; ?> </th>
                    <td> <?=$row->articulo;?> </td>
                    <td>L. <?=number_format($row->precio,2);?> </td>
                    <td> <?=$row->cantidad;?> </td>
                    <td>L. <?=number_format($row->total,2);?> </td>
                    <td>
                        <a href="<?=base_url?>venta/eliminarDatosVD&id=<?=$row->venta?>&art=<?=$row->idart?>" class="btn btn-eliminar">Eliminar<i class="bi bi-x-square-fill"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            
                
            </tbody>
            </table>
    </div>
</div>
