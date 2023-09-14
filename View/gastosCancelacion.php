<?php
require_once("../includes/header_admin.php");
require_once('../Helpers/gastosCancelacion.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Solicitar Eliminación <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                del gastos <?php echo $nombre; ?>
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                                <div class="form-group">
                                    <label class="control-label"><span>Ingrese un sobre el pedido de la Cancelación</span></label>
                                    <textarea class="form-control" type="text" name="comentario" id="comentario" placeholder="Ingrese su comentario" style="max-height: 170px;" required></textarea>
                                </div>
                                <input type="hidden" class="form-control" name="estatus" id="estatus" value="2">
                                <input type="hidden" class="form-control" name="usuario_1" id="usuario_1" value="<?= $_SESSION['nombre']; ?>">

                                <button type="submit" class="btn btn-primary mr-2">Solicitar</button>
                                <a class="btn btn-light" href="../Templates/gastos.php">Cancelar</a>
                                <br>
                                <?php if ($alert != "") {  ?>
                                    <div class="btn btn-outline-primary btn-lg w-100 mt-4 mb-0">
                                        <p style="color:#fff;">
                                            <?php echo $alert; ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>