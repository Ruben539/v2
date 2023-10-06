<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/modificarEspecialidad.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Actualizar Especialidad <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                Datos de la especialidad modificar
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label"> Descripcion</label>
                                    <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ingrese el monto" required value="<?php echo $descripcion; ?>">
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
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

          