<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/asignarMontoEstudioMedicos.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Vincular el doctor con el estudio <i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                                Asignar el monto a cobrar por el estudio
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <div class="form-group">
                                    <label class="control-label">Medico</label>
                                    <select class="chosen form-control" name="doctor_id" id="doctor_id" required data-placeholder="Seleccione un Medico">
                                        <option value=""></option>
                                        <?php
                                        $raw_results4 = mysqli_query($conection, "SELECT * FROM medicos WHERE estatus = 1;") or die(mysqli_error($conection));
                                        while ($results = mysqli_fetch_array($raw_results4)) {
                                        ?>

                                            <option value=" <?php echo $results['id'] ?> ">
                                                <?php echo $results['nombre']; ?>
                                            </option>

                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label class="control-label">estudio</label>
                                    <select class="chosen form-control" name="estudio_id" id="estudio_id" required data-placeholder="Seleccione la estudio">
                                        <option value=""></option>
                                        <?php
                                        $raw_results4 = mysqli_query($conection, "SELECT  * FROM  estudios WHERE estatus = 1;") or die(mysqli_error($conection));
                                        while ($results = mysqli_fetch_array($raw_results4)) {
                                        ?>

                                            <option value=" <?php echo $results['id'] ?> ">
                                                <?php echo $results['nombre']; ?>
                                            </option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Monto</label>
                                    <input class="form-control" type="text" name="monto" id="monto" placeholder="Ingrese el monto" required>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Asignar</button>
                                <a class="btn btn-light" href="../Templates/montoMedicoEstudios.php">Cancelar</a>
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
            <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
            <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
            <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
            <script src="../node_modules/chosen-js/chosen.jquery.js"></script>
            <script>
                $(document).ready(function() {
                    $(".chosen").chosen();

                });
            </script>