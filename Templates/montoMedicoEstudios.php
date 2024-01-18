<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 5) {
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

                        <h4>Monto medicos por estudios.
                        <a href="../View/asignarMontoMedicos.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> Asignar</a>   
                    </h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered text-center" id="tabla">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>

                                        <th>

                                            Estudio
                                        </th>
                                        <th>

                                            Monto a Cobrar
                                        </th>
                                        <?php if ($_SESSION['rol'] == 1) { ?>
                                            <th>
                                                Acción       
                                            </th>
                                        <?php } ?>
  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $sql = mysqli_query($conection, "SELECT pem.id, e.nombre As estudio, pem.monto
                                    FROM pago_estudio_medicos pem INNER JOIN estudios e ON e.id =  pem.estudio_id
                                    WHERE pem.estatus = 1 AND e.estatus = 1 ");

                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['estudio']; ?></td>
                                                <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                                                <?php if ($_SESSION['rol'] == 1 ) { ?>
                                                    <td>
                                                        <a href="../View/modificarMontoMedico.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-info" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-edit"></i></a>
                                                    </td>
                                                <?php } ?>                                             
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
          
