<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
    if (empty($_SESSION['active'])) {
        header('location: salir.php');
    }
} else {
    header('location: salir.php');
}

require_once('../Models/conexion.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4>Reporte Diario <i class="typcn typcn-user"></i> </h4>

                    <form class="row" method="POST" action="../Reports/reporteDiarioDiax.php" target="_blank">
                    <div class="col-md-6">
                        <div class="widget-small">
                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6 pb-3">
                        <div class="widget-small">
                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="widget-small">
                            <select name="valor" id="valor" class="form-control">
                                <option value="">Seleccione una opción.........</option>
                                <option value="DIAX">Diax</option>
                                <option value="PAZ">PAZ</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>Filtrar

                    </div>
            </div>
            </form>

     

                    </div>
                </div>
            </div>


               


        <?php include('../includes/footer_admin.php'); ?>

        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
