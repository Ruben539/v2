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

                        <h4>Usuarios del Sistema Inactivos </h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Nombre
                                        </th>
                                        <th>
                                            Correo
                                        </th>
                                        <th>
                                            Usuario
                                        </th>

                                        <th>
                                            Puesto
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($conection, "SELECT u.id,u.nombre,u.correo,u.usuario,r.descripcion 
                                    FROM usuarios u INNER JOIN roles r ON r.id = u.rol  where  u.estatus = 0 ORDER BY  u.id DESC");

                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['correo']; ?></td>
                                                <td><?php echo $data['usuario']; ?></td>
                                                <td><?php echo $data['descripcion'] ?></td>
                                               
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
