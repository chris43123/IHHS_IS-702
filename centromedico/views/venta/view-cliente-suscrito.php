<!--Contenido-->
<div class="formulario">

    <div class="row form-buscar-producto">
        <div class="col-md-6">
            <h1>Consulta de Cliente</h1>
            <a href="<?=base_url?>producto/deleteAll" class="btn btn-eliminar float-end">Cerrar<i class="bi bi-x-square-fill"></i></a>

        <!-- FORMULARIO DE BUSQUEDA DE CLIENTE -->
                <h4>Cliente Suscrito:</h4>
                <form action="<?=base_url?>venta/obtenerCliente" method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text">ID Cliente</span>
                        <input type="text" class="form-control" id="" name="idCliente" required>
                        <input type="submit" class="btn btn-outline-secondary btn-editar" name="" value="Buscar">
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
            
            <!--Mostrar informacion cliente-->
            <div class="info-producto p-20 mb-5">
                <?php if(isset($cliente)) { ?>
                    <div class="mb-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary"><strong>Detalle Cliente</strong></li>
                            <li class="list-group-item"><span class="text-primary">ID Cliente: </span><?= $cliente->IDcliente; ?> </li>
                            <li class="list-group-item"><span class="text-primary">Nombre: </span><?= $cliente->Nombre ?> </li>
                            <li class="list-group-item"><span class="text-primary">Dirección: </span><?= $cliente->Direccion ?> </li>
                            <li class="list-group-item"><span class="text-primary">Saldo Crediticio: </span><?= $cliente->saldoCrediticio ?> </li>
                        </ul>
                    </div>
                    <a href="<?=base_url?>venta/ingresarVenta&cliente=<?= $cliente->IDcliente; ?>" class="btn btn-primary">Aceptar</a>
                <?php } ?>
            </div>  
            
        </div>
    </div>
</div>