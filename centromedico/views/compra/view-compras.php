
<div class="resumen-compras">
    <h1>Gestión de Compras</h1>
    <!--Contralar datos Sesion-->
    <?php
        if(isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['clase']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php session_unset(); } ?>

    <div class="row">
        <a href="<?=base_url?>compra/consultarProductos" class="btn btn-nuevo">Nueva Compra<i class="bi bi-pencil-fill"></i></a>
    </div>
    <div class="row tarjetas-compras">
        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t1">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. <?= number_format($totalCompras->total,2) ?></h1>
                    <p>Total Compras</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t3">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. <?= number_format($totalPagos->pagos,2) ?></h1>
                    <p>Total Pagos</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t5">
                <i class="bi bi-bag-x-fill"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. <?= number_format($totalpendientes->pendiente,2) ?></h1>
                    <p>Total Pendientes</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t4">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1>L. <?= number_format($totalComprasMes->total,2) ?></h1>
                    <p>Último Mes</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="contenido-tablas">
    <h2>Contenido de Compras</h2>
    <div class="row filtros">       
        <div class="col-md-6 filtro-cantidad">
            <p>Mostrar</p>
            <select name="" id="">
                <option value="10">Ultimos 10</option>
                <option value="10">Ultimos 15</option>
                <option value="10">Ultimos 20</option>
            </select>
        </div>
        <div class="col-md-6 buscar">
            <form action="<?=base_url?>compra/consultarUno" method="POST">
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
                <th scope="col">No. Compra</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Fecha</th>
                <th scope="col">No. Cheque</th>
                <th scope="col">Total</th>
                <th scope="col">Saldo Pagado</th>
                <th scope="col">Saldo Pendiente</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = $compras->fetch_object()):?>

                <tr>
                    <th scope="row"> <?=$row->id; ?> </th>
                    <td> <?=$row->nombreP;?> </td>
                    <td> <?=$row->fecha;?> </td>
                    <td> <?=$row->cheque;?> </td>
                    <td>L. <?=number_format($row->total,2);?> </td>
                    <td>L. <?=number_format($row->saldo,2);?> </td>
                    <td>L. <?=number_format(($row->total-$row->saldo),2);?> </td>
                    <td>
                        <a href="<?=base_url?>compra/editarDatos&id=<?=$row->id?>" class="btn btn-editar">Editar<i class="bi bi-pencil-square"></i></a>
                        <a href="<?=base_url?>compra/eliminarDatos&id=<?=$row->id?>" class="btn btn-eliminar">Eliminar<i class="bi bi-x-square-fill"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            
                
            </tbody>
            </table>
    </div>
</div>

<div class="contenido-tablas">
    <h2>Contenido de Compras Detalle</h2>
    <div class="row filtros">       
        <div class="col-md-6 buscar">
            <form action="<?=base_url?>compra/consultarUnoCD" method="POST">
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
                <th scope="col">No. Compra</th>
                <th scope="col">Articulo</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Total</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = $comprasD->fetch_object()):?>

                <tr>
                    <th scope="row"> <?=$row->compra; ?> </th>
                    <td> <?=$row->articulo;?> </td>
                    <td>L. <?=number_format($row->precio,2);?> </td>
                    <td> <?=$row->cantidad;?> </td>
                    <td>L. <?=number_format($row->total,2);?> </td>
                    <td>
                        <a href="<?=base_url?>compra/editarDatosCD&id=<?=$row->compra?>&art=<?=$row->idart?>" class="btn btn-editar">Editar<i class="bi bi-pencil-square"></i></a>
                        <a href="<?=base_url?>compra/eliminarDatosCD&id=<?=$row->compra?>&art=<?=$row->idart?>" class="btn btn-eliminar">Eliminar<i class="bi bi-x-square-fill"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            
                
            </tbody>
            </table>
    </div>
</div>