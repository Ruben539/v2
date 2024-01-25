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

                        <h4>Ordenes Canceladas <i class="typcn typcn-delete"></i></h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-striped project-orders-table text-center" id="tabla">
                                <thead>
                                    <tr>
                                        <th class="ml-5">Nro</th>
                                        <th>Ruc </th>
                                        <th>Nro Ticket </th>
                                        <th>Razon Social</th>
                                        <th>Estudio</th>
                                        <th>Monto</th>
                                        <th>Descuento</th>
                                        <th>Doctor</th>
                                        <th>Forma de Pago</th>
                                        <th>Seguro</th>
                                        <th>Comentario</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $fecha1 = "05-01-2023";
                                    $fecha =  date('m-Y');
                                    //  echo $fecha1." ".$fecha2;
                                    //  exit;
                                    $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                                    fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                                    IF(c.estatus = 1, dc.monto, 0) as monto,
                                    IF(c.estatus = 1, dc.descuento, 0) as descuento
                                    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                                    INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                                    INNER JOIN seguros s ON s.id = dc.seguro_id
                                    WHERE  c.estatus = 0 GROUP BY c.id  ORDER BY  c.id ASC");

                                    $resultado = mysqli_num_rows($sql);
                                    $diax = 0;
                                    $nro = 0;
                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $diax += (int)$data['monto'];
                                            $nro++;
                                    ?>
                                            <tr class="text-center">


                                                <td><?php echo $nro ?></td>
                                                <td><?php echo $data['id'] ?></td>
                                                <td><?php echo $data['ruc']; ?></td>
                                                <td><?php echo $data['razon_social']; ?></td>
                                                <td><?php echo $data['estudio']; ?></td>
                                                <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                                                <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                                                <td><?php echo $data['doctor'] ?></td>
                                                <td><?php echo $data['forma_pago'] ?></td>
                                                <td><?php echo $data['seguro'] ?></td>
                                                <td><?php echo $data['comentario'] ?></td>
                                                <td><?php echo $data['created_at'] ?></td>
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