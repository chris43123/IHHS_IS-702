
<div class="formulario">
    <div class="row form-ingreso-producto">
        <div class="col-md-7">
            <h3 class="mb-3">Datos Nueva Venta</h3>
            <hr>
            <?php if(isset($_SESSION['totalVenta'])){ ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-hover table-responsive">
                            <thead>
                                <tr class="table-dark">
                                    <td colspan="2" class="text-center">Detalle Venta</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="col" class="">Total:</th>
                                    <th scope="row" class="table-secondary text-center">L. <?=$_SESSION['totalVenta']?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            <?php } ?>

            <!--Comprobar si es Ingreso o Edicion-->
            <?php if(isset($edit) && isset($venta) && is_object($venta)): ?>
                <h3 class="mb-3">Editar Venta No. <span class="text-secondary"><?=$venta->id?></span></h3>
                <?php
                    $url_action = base_url."venta/guardarDatos&id=".$venta->id;
                ?>
            <?php else: ?>
                <?php
                    $url_action = base_url."venta/guardarDatos";
                ?>
            <?php endif; ?>

            <form action="<?=$url_action?>" method="POST" role="form">

            <?php if(isset($_SESSION['suscrito']) && $_SESSION['suscrito'] == 2) : ?>
                <h4>Nuevo Cliente:</h4>
                <div class="mb-3">
                    <label for="" class="form-label">Identidad Cliente:</label>
                    <input type="number" class="form-control" id="" name="idCliente" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nombre Cliente:</label>
                    <input type="text" class="form-control" id="" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Direccion:</label>
                    <input type="text" class="form-control" id="" name="direccion" required>
                </div>                           
                <div class="mb-3">
                    <label for="" class="form-label">Tipo de Cliente:</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="tipo">
                        <option selected value="0">Seleccione un tipo...</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                    </select>
                </div>
            <?php endif; ?>

                <div class="mb-3">
                    <label for="" class="form-label">Numero de Venta:</label>
                    <input type="text" class="form-control" id="" name="idVenta" value="<?=isset($venta) && is_object($venta) ? $venta->id : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" id="" name="fecha" value="<?=isset($venta) && is_object($venta) ? $venta->fecha : '';?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Saldo Pagado:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">L. </span>
                        <input type="text" class="form-control" name="saldo" value="<?=isset($venta) && is_object($venta) ? $venta->saldo : '';?>" required>
                    </div>
                </div>                           
                <input type="submit" class="btn btn-primary mb-3">
            </form>
        </div>
    </div>
</div>

