<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 ) {
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

                        <h4>Gastos del Sistema a Eliminar</h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Solicitado Por</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Comentario</th>
                                        <th>Aprobado por</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.usuario_1,g.created_at,g.comentario,g.fecha_2,g.usuario_2
                                       FROM gastos g  where  g.estatus = 0 ");
                                   
                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['created_at'] ?></td>
                                                <td><?php echo $data['usuario_1']; ?></td>
                                                <td><?php echo $data['descripcion']; ?></td>
                                                <td><?php echo $data['monto']; ?></td>
                                                <td><?php echo $data['comentario']; ?></td>
                                                <td><?php echo $data['usuario_2']; ?></td>
                                                <td><?php echo $data['fecha_2'] ?></td>
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
       

