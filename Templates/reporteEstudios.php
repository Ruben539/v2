<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
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
                        <h4>Rendicion de Estudios <i class="typcn typcn-flow-children"></i> </h4>

                        <form class="row" method="POST" action="../Reports/reporteEstudiosPDF.php" target="_blank">
                            <div class="col-md-6">
                                <div class="widget-small">
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="widget-small">
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label for=""></label>
                                <div class="widget-small">
                                    <?php
                                    include "../Models/conexion.php";

                                    $query_estudio = mysqli_query($conection, "SELECT e.id,e.nombre,e.seguro,e.preferencial,e.hospitalario
                                    FROM estudios e where e.estatus = 1 ORDER BY e.id DESC");

                                    mysqli_close($conection); //con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
                                    $resultado = mysqli_num_rows($query_estudio);

                                    ?>
                                    <select name="estudio" id="estudio" class="chosen form-control">
                                    <option value="">Seleccione un estudio</option>
                                        <?php

                                        if ($resultado > 0) {
                                            while ($estudio = mysqli_fetch_array($query_estudio)) {

                                        ?>
                                                
                                                <option value="<?php echo $estudio["id"]; ?>"><?php echo
                                                    $estudio["nombre"] ?></option>

                                        <?php


                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <label for=""></label>
                            </div>


                            <div>

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
        <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
        <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
        <script src="../node_modules/chosen-js/chosen.jquery.js"></script>
        <script>
            $(document).ready(function() {
                $(".chosen").chosen();
            });
        </script>
       