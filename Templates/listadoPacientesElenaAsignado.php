<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 ||  $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
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

                        <div class=" shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-black text-capitalize ps-3">Pacientes Asignados :</h5>
                            <hr>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="table-responsive" id="tablaResultado">
                                    <table id="tabla_Usuario" class="table table-striped table-bordered table-condensed" style="width:100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="ml-5">Nro</th>
                                                <th>Ruc </th>
                                                <th>Razon Social</th>
                                                <th>Estudio</th>
                                                <th>Monto</th>
                                                <th>Descuento</th>
                                                <th>Informante</th>
                                                <th>Fecha</th>
                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 5) { ?>
                                                    <th>Reasignar</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            $sql = mysqli_query($conection,"SELECT DISTINCT(c.id), c.ruc, c.razon_social, dc.descripcion AS estudio, dc.monto,dc.descuento, m.nombre AS doctor,c.created_at,s.descripcion AS seguros
                                            FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id 
                                            JOIN medicos m ON m.id = c.informante_id
                                            JOIN seguros s ON s.id = dc.seguro_id
                                            WHERE c. doctor_id = 17  AND c.estatus = 1 AND c.estado LIKE '%Atendido%'");



                                            $resultado = mysqli_num_rows($sql);
                                            $nro = 0;
                                            if ($resultado > 0) {
                                                while ($data = mysqli_fetch_array($sql)) {
                                                    $nro++;
                                            ?>
                                                    <tr class="text-center">
                                                        <td><?php echo $nro ?></td>
                                                        <td><?php echo $data['ruc']; ?></td>
                                                        <td><?php echo $data['razon_social']; ?></td>
                                                        <td><?php echo $data['estudio']; ?></td>
                                                        <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                                                        <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                                                        <td><?php echo $data['doctor'] ?></td>
                                                        <td><?php echo $data['created_at'] ?></td>

                                                        <?php if ($_SESSION['rol'] == 1  || $_SESSION['rol'] == 5) { ?>
                                                            <td>
                                                                <a href="../View/asignarInformanteFabiola.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-info" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);">
                                                                    <i class="typcn typcn-edit"></i>
                                                                </a>
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
                </div>
            </div>
        </div>

        <?php include('../includes/footer_admin.php'); ?>

        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                tablaHerreria = $("#tabla_Usuario").DataTable({
                    "columnDefs": [{
                        "target": 1,
                        "data": null
                    }],

                    //Para cambiar el lenguaje a español
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "zeroRecords": "No se encontraron resultados",
                        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "Buscar:",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "sProcessing": "Procesando...",
                    }
                });



            });
        </script>