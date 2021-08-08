<!--Contenido-->
<div class="formulario">
    <h1>Ingresar Datos de Compra</h1>

    <?php if(isset($_SESSION['totalCompra'])){ ?>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr class="table-dark">
                        <td colspan="2" class="text-center">Detalle Compra</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th scope="col" class="">Total:</th>
                        <th scope="row" class="table-secondary text-center">L. <?=$_SESSION['totalCompra']?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <?php } ?>

    <div class="row form-ingreso-producto">
        <div class="col-md-6">

            <!--Comprobar si es Ingreso o Edicion-->
            <?php if(isset($edit) && isset($compra) && is_object($compra)): ?>
                <h3 class="mb-3">Editar Compra: <span class="text-secondary"><?=$compra->id?></span></h3>
                <?php
                    $url_action = base_url."compra/guardarDatos&id=".$compra->id;
                ?>
            <?php else: ?>
                <h3 class="mb-3">Crear Nuevo Compra</h3>
                <?php
                    $url_action = base_url."compra/guardarDatos";
                ?>
            <?php endif; ?>

            <hr>
            <form action="<?=$url_action?>" method="POST">   
                <div class="mb-3">
                    <label for="" class="form-label">No. de compra:</label>
                    <input type="number" class="form-control" id="" name="idCompra" value="<?=isset($compra) && is_object($compra) ? $compra->id : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">ID Proveedor:</label>
                    <input type="number" class="form-control" id="" name="idProveedor" value="<?=isset($compra) && is_object($compra) ? $compra->IDproveedor : '';?>" required>
                </div>                        
                <div class="mb-3">
                    <label for="" class="form-label">Fecha de compra:</label>
                    <input type="date" class="form-control" id="" name="fecha" value="<?=isset($compra) && is_object($compra) ? $compra->fecha : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No. Cheque:</label>
                    <input type="number" class="form-control" id="" name="cheque" value="<?=isset($compra) && is_object($compra) ? $compra->cheque : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Saldo Pagado:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">L. </span>
                        <input type="number" class="form-control" name="saldo" value="<?=isset($compra) && is_object($compra) ? $compra->saldo : '';?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3" name="ingreso-producto">Enviar</button>
                
            </form>
        </div>
    </div>
</div>