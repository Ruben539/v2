<?php
require_once("../includes/header_admin.php");
require_once('../Helpers/cancelarMovimientos.php');
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">Cancelar Movimiento <i class="typcn typcn-credit-card"></i></h4>
              <p class="card-description text-center">
              <b>Cancelar el movimiento de : <?php echo $tipo_salida; ?>, <?php echo $concepto; ?></b>
              </p>
              <form action="" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

                        <div class="form-group">
                            <label class="control-label"><span>Motivos sobre la Cancelación</span></label>
                            <textarea class="form-control" type="text" name="observacion" id="observacion"
                             placeholder="Ingrese su comentario" style="max-height: 170px;" required ></textarea>
                        </div>
                        <input type="hidden" class="form-control" name="estatus" id="estatus" value="0">
                        <input type="hidden" class="form-control" name="aprobado" id="aprobado" value="<?php echo $_SESSION['nombre'];?>">



                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-user-times"></i>
                            Cancelar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Templates/movimientosFinacieros.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Regresar</a>

                        </div>
                    </form>
                    <br>
                    <?php if (isset($alert)) { ?>
                        <div class="alert alert-info"><?php echo  $alert; ?></div>
                    <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <?php include('../includes/footer_admin.php'); ?>