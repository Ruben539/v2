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

                        <h4>Estudios del Sistema <a href="../View/agregarEstudio.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> Registrar</a></h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                        <th>Estudio</th>
                                        <th>Precio Seguro</th>
                                        <th>Precio Preferencial</th>
                                        <th>Precio Hospitalario</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $sql = mysqli_query($conection, "SELECT e.id,e.nombre,e.seguro,e.preferencial,e.hospitalario
                                     FROM estudios e where e.estatus = 0 ORDER BY e.id DESC");
             
                                                 $resultado = mysqli_num_rows($sql);
             
                                                 if ($resultado > 0) {
                                                     while ($ver = mysqli_fetch_array($sql)) {
                                                         $datos = $ver[0];
                                                         $ver[1];
                                                         $ver[2];
                                                         $ver[3];
                                                         $ver[4];
             
                                                 ?>
                                                         <tr class="text-center">
             
                                                             <td><?= $ver[0]; ?></td>
                                                             <td><?= $ver[1]; ?></td>
                                                             <td><?= $ver[2]; ?></td>
                                                             <td><?= $ver[3]; ?></td>
                                                             <td><?= $ver[4]; ?></td>
                                            </tr>


                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>

            <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
            <script src="../assets/js/sweetalert2.min.js"></script>
            <script src="../assets/js/core/popper.min.js"></script>
            <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
            <script src="../assets/js/Estudios/estudios.js"></script>
            