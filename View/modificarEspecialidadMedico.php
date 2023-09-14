<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/modificarEspecialidadMedico.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Actualizar Especialidad del Medico <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                Datos de la especialidad modificar
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label"> Descripcion</label>
                                    <select class="chosen form-control" name="especialidad_id" id="especialidad_id" required data-placeholder="Seleccione la Especialidad">
                                        <option value="<?php echo $id; ?>" selected><?php echo $descripcion; ?></option>
                                        <option value="" >----------------------------------------------Seleccione otra especialidad----------------------------------------</option>
                                        <?php
                                        $raw_results4 = mysqli_query($conection, "select * from especialidades;") or die(mysqli_error($conection));
                                        while ($results = mysqli_fetch_array($raw_results4)) {
                                        ?>
                                            <option value=" <?php echo $results['id'] ?> ">
                                                <?php echo $results['descripcion']; ?>
                                            </option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                                <a class="btn btn-light" href="../Templates/especialidadDoctor.php">Cancelar</a>
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
            <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
<script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../node_modules/chosen-js/chosen.jquery.js"></script>
<script>
           
           $(document).ready(function() {
           $(".chosen").chosen();
           
       });
       
      
   </script>