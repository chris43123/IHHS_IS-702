<div class="resumen-compras">
    <h1>Gestión de Inventario</h1>
    <div class="row">
        <a href="<?=base_url?>inventario/ingresoDatos" class="btn btn-nuevo">Nuevo Producto<i class="bi bi-pencil-fill"></i></a>
    </div>
    <div class="row tarjetas-compras">
        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t1">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1><?= $totalArticulos->totalArticulos ?></h1>
                    <p>Total Productos</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t2">
                    <i class="bi bi-stack"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1><?= $existencias->existencias ?></h1>
                    <p>Existencias</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t6">
                    <i class="bi bi-exclamation-square"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1><?= $articulosBajas->articulosbajas ?></h1>
                    <p>Productos Existencias Bajas</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="row tarjeta-d">
                <div class="col-md-4 icono t5">
                    <i class="bi bi-cart-x"></i>
                </div>
                <div class="col-md-8 texto">
                    <h1><?= $articulosAgotados->articulosagotados ?></h1>
                    <p>Productos Agotados</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="contenido-tablas">
    <h2>Tabla Inventario</h2>
     <!--Contralar datos Sesion-->
     <?php
        if(isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['clase']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php session_unset(); } ?>
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
            <form action="<?=base_url?>inventario/consultarUno" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control input-buscar" name="id" placeholder="Buscar..." required>
                    <input type="submit" class="input-group-text icono" id="" value="Buscar">
                </div>
            </form>
        </div>
    </div>
    <div class="row tabla">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Código</th>
                <th scope="col">Producto</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Precio</th>
                <th scope="col">Impuesto</th>
                <th scope="col">Existencias</th>
                <th scope="col">Limite</th>
                <th scope="col">Caducidad</th>
                <th scope="col">Estante</th>
                <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = $productos->fetch_object()):?>
                <tr>
                    <th scope="row"> <?=$row->codArticulo; ?> </th>
                    <td> <?=$row->Nombre;?> </td>
                    <td> <?=$row->IDproveedor;?> </td>
                    <td> <?=$row->precio;?> </td>
                    <td> <?=$row->impuesto;?> </td>
                    <td> <?=$row->existencias;?> </td>
                    <td> <?=$row->limite;?> </td>
                    <td> <?=$row->caducidad;?> </td>
                    <td> <?=$row->estante;?> </td>
                    <td>
                        <a href="<?=base_url?>inventario/editarDatos&id=<?=$row->codArticulo?>" class="btn btn-editar">Editar<i class="bi bi-pencil-square"></i></a>
                        <a href="<?=base_url?>inventario/eliminarDatos&id=<?=$row->codArticulo?>" class="btn btn-eliminar">Eliminar<i class="bi bi-x-square-fill"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
            </table>
    </div>
</div>
