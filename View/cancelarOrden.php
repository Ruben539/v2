<?php
require_once("../includes/header_admin.php");
require_once('../Extension/pedidoCancelacionOrden.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Solicitud de Cancelación <i class="typcn typcn-user"></i></h4>
                            <p class="card-description text-center">
                                Cargar la observación sobre la Cancelación de <?php echo $razon_social; ?>
                            </p>
                            <form action="" method="POST">
                                <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

                                <div class="form-group">
                                    <label class="control-label"><span>Comentario de la Anulación</span></label>
                                    <textarea class="form-control" type="text" name="motivo_anulado" id="motivo_anulado" placeholder="Ingrese su el motivo de la anulación" style="max-height: 170px;" required></textarea>
                                </div>
                                <input type="hidden" class="form-control" name="estatus" id="estatus" value="2">

                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-user-times"></i>Cancelar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Templates/dashboard.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Regresar</a>

                                </div>
                            </form>
                            <br>
                            <?php if($alert) { ?>
                                <div class="alert alert-info"><?php echo  $alert; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>