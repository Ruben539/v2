<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarEspecialidad.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Agregar Especialidad <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                Datos de la especialidad a grabar
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <div class="form-group">
                                    <label class="control-label">Descripción</label>
                                    <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ingrese el gasto" required>
                                </div>


                                <input type="hidden" name="estatus" id="estatus" value="1">
                                <button type="submit" class="btn btn-primary mr-2">Registrar</button>
                                <a class="btn btn-light" href="../Templates/especialidades.php">Cancelar</a>
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