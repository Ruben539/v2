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

                        <h4>Movimientos eliminados del Sistema</h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Fecha de Movimiento</th>
                                        <th>Forma de Pago</th>
                                        <th>Nro Cheque/ Transferencia</th>
                                        <th>Tipo de Movimiento</th>
                                        <th>Monto</th>
                                        <th>Concepto</th>
                                        <th>Eliminado Por</th>
                                        <th>Observación</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,
                                       c.monto,c.concepto,c.usuario,c.created_at,c.proveedor,c.aprobado,c.observacion
                                       FROM empresa_movimientos c where  c.estatus = 0 ");
                                  
                                    $resultado = mysqli_num_rows($sql);
                                    $row = 0;
                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $row++;
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $row; ?></td>
                                                <td><?php echo $data['created_at']; ?></td>
                                                <td><?php echo $data['forma_pago']; ?></td>
                                                <td><?php echo $data['nro_cheque']; ?></td>
                                                <td><?php echo $data['tipo_salida']; ?></td>
                                                <td><?php echo $data['monto']; ?></td>
                                                <td><?php echo $data['concepto'] ?></td>
                                                <td><?php echo $data['aprobado'] ?></td>
                                                <td><?php echo $data['observacion'] ?></td>


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
          

