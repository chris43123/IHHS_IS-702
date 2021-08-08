<!--Contenido-->
<div class="formulario">
    <h1>Gestión de Almacén</h1>

     <!--Contralar datos Sesion-->
     <?php
        if(isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['clase']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php session_unset(); } ?>

    
    <div class="row form-ingreso-producto">
        <div class="col-md-6">

            <?php if(isset($edit) && isset($producto) && is_object($producto)): ?>
                <h3 class="mb-3">Editar Producto: <span class="text-secondary"><?=$producto->Nombre?></span></h3>
                <?php
                    $url_action = base_url."inventario/guardarDatos&id=".$producto->codArticulo;
                ?>
            <?php else: ?>
                <h3 class="mb-3">Crear Nuevo Producto</h3>
                <?php
                    $url_action = base_url."inventario/guardarDatos";
                ?>
            <?php endif; ?>

            <hr>

            <form action="<?=$url_action?>" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Codigo:</label>
                    <input type="text" class="form-control" id="" name="codigo" value="<?=isset($producto) && is_object($producto) ? $producto->codArticulo : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nombre del Articulo:</label>
                    <input type="text" class="form-control" id="" name="nombre" value="<?=isset($producto) && is_object($producto) ? $producto->Nombre : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Precio por Unidad:</label>
                    <input type="number" class="form-control" id="" name="precio" value="<?=isset($producto) && is_object($producto) ? $producto->precio : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Impuesto:</label>
                    <input type="number" class="form-control" id="" name="impuesto" value="<?=isset($producto) && is_object($producto) ? $producto->impuesto : '';?>" required>
                </div>                             
                <div class="mb-3">
                    <label for="" class="form-label">Fecha de vencimiento:</label>
                    <input type="date" class="form-control" id=""  name="caducidad" value="<?=isset($producto) && is_object($producto) ? $producto->caducidad : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Limite de Existencias:</label>
                    <input type="number" class="form-control" id="" name="limite" value="<?=isset($producto) && is_object($producto) ? $producto->limite : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">ID Estante:</label>
                    <input type="number" class="form-control" id=""  name="estante" value="<?=isset($producto) && is_object($producto) ? $producto->estante : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">ID Proveedor:</label>
                    <input type="number" class="form-control" id=""  name="proveedor" value="<?=isset($producto) && is_object($producto) ? $producto->IDproveedor : '';?>" required>
                </div>
                <input type="submit" class="btn btn-primary mb-3" name="ingreso-producto" value="enviar">
            </form>
        </div>
    </div>
</div>
