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

                        <h4>Roles del Sistema </h4>

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

                                    $sql = mysqli_query($conection, "SELECT r.id,r.descripcion FROM roles r  WHERE r.estatus = 1");

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

          
