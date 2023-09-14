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

                        <h4>Especialidad de los Medicos<a href="../View/agregarEspecialidad.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> Registrar</a> </h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered text-center" id="tabla">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>

                                        <th>

                                            Descripción
                                        </th>
  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $sql = mysqli_query($conection, "SELECT e.id,e.descripcion FROM especialidades e  WHERE e.estatus = 1");

                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['descripcion']; ?></td>
                                                                                              
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
          
