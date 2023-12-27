<?php
session_start();

require_once("../Models/conexion.php");
require_once("../includes/header_admin.php");

$id = $_SESSION['idMedico'];



?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <?php
                $cantidadEspera = 0;
                date_default_timezone_set('America/Asuncion');
                $fecha  =  date('Y-m-d');
                $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre
                    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                    INNER JOIN medicos m ON m.id = c.doctor_id 
                    WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
                    AND m.id =  '" . $id . "' AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 AND c.estado LIKE '%En Espera%' GROUP BY m.nombre ORDER BY cantidad DESC");

                $resultado = mysqli_num_rows($sql);

                if ($resultado > 0) {

                    while ($data = mysqli_fetch_array($sql)) {
                        $cantidadEspera =  $data['cantidad'];
                    }
                }

                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Pacientes en Espera</p>
                                <?php if ($cantidadEspera != 0) { ?>
                                    <h1 class="mb-0" id="idPacienteDiax"><?php echo $cantidadEspera; ?></h1>
                                <?php } else { ?>
                                    <h1 class="mb-0" id="idPacienteDiax">0</h1>
                                <?php } ?>
                            </div>
                            <i class="typcn typcn-user icon-xl text-secondary"></i>
                        </div>
                        <canvas id="expense-chart" height="80"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <?php
                $cantidadAtendida = 0;
                date_default_timezone_set('America/Asuncion');
                $fecha  =  date('Y-m-d');
                $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre
                    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                    INNER JOIN medicos m ON m.id = c.doctor_id 
                    WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
                    AND m.id =  '" . $id . "' AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 AND c.estado LIKE '%Atendido%' GROUP BY m.nombre ORDER BY cantidad DESC");

                $resultado = mysqli_num_rows($sql);

                if ($resultado > 0) {

                    while ($data = mysqli_fetch_array($sql)) {
                        $cantidadAtendida =  $data['cantidad'];
                    }
                }

                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Pacientes Atendidos</p>
                                <?php if ($cantidadAtendida != 0) { ?>
                                    <h1 class="mb-0"><?php echo $cantidadAtendida; ?></h1>
                                <?php } else { ?>
                                    <h1 class="mb-0">0</h1>
                                <?php } ?>
                            </div>
                            <i class="typcn typcn-user icon-xl text-secondary"></i>
                        </div>
                        <canvas id="budget-chart" height="80"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Cantidad Total de Pacientes</p>
                                <h1 class="mb-0" id="idTotalPacientes"><?php echo $cantidadAtendida + $cantidadEspera; ?></h1>
                            </div>
                            <i class="typcn typcn-group icon-xl text-secondary"></i>
                        </div>
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <!---Tabla de los pacientes que deriven de la consulta de PAZ--->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="titulos col-md-4">
                        <h3>Lista Pacientes en espera</h3>
                    </div>
                    <div class="table-responsive pt-9">
                        <table class="table table-striped project-orders-table text-center">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cedula</th>
                                    <th>Paciente</th>
                                    <th>F. Nacimiento</th>
                                    <th>Estudio</th>
                                    <th>Seguro</th>
                                    <th>Comentario</th>
                                    <th>Atendido</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha =  date('Y-m-d');
                                //  echo $fecha1." ".$fecha2;
                                //  exit;
                                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
                                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,c.estado, u.fecha_nac
                                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                                INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
                                WHERE  m.id =  '" . $id . "'   AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                                $resultado = mysqli_num_rows($sql);
                                $medicos = 0;
                                $descuento = 0;
                                $nro = 0;

                                if ($resultado > 0) {
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $medicos += (int)$data['monto'];
                                        $descuento += (int)$data['descuento'];

                                        $nro++;
                                ?>
                                        <?php if ($data['estado'] === 'En Espera') { ?>
                                            <tr class="text-center" style="color: red">
                                            <?php } else { ?>
                                            <tr class="text-center" style="color: green">
                                            <?php } ?>

                                            <td><?php echo $data['created_at']; ?></td>
                                            <td><?php echo number_format($data['ruc'],0,'.','.'); ?></td>
                                            <td><?php echo $data['razon_social']; ?></td>
                                            <td><?php echo $data['fecha_nac']; ?></td>
                                            <td><?php echo $data['estudio']; ?></td>
                                            <td><?php echo $data['seguro'] ?></td>
                                            <td><?php echo $data['comentario'] ?></td>

                                            <?php if ($data['estado'] === 'En Espera') { ?>
                                                <td>
                                                    <button onclick="confirmarPaciente('<?php echo $data['id']; ?>')"  class="btn btn-outline-success" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);">
                                                        <i class="typcn typcn-input-checked-outline" aria-hidden="true"></i></button>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <button href="#" onclick="permisoAuto()" class="btn btn-outline-success" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);">
                                                    <i class="typcn typcn-input-checked-outline" aria-hidden="true"></i></button>
                                                </td>
                                            <?php } ?>

                                            </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                        <section>
                            <p>Ingreso Total :</p>
                            <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($medicos - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!---Fin de la tabla-------------------------------------------->


        <?php include('../includes/footer_admin.php'); ?>
        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../../assets/js/sweetalert2.min.js"></script>
        <script src="../../assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="../../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../assets/js/dataTables.bootstrap.min.js"></script>
        <script src="../js/confirmarPaciente.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('#btnEditarPass').click(function() {
                    /* Act on the event */
                    confirmarPaciente();
                });
            });
        </script>

        <script>
            function permisoAuto() {
                Swal.fire({
                    /*toast: true,*/
                    position: 'center',
                    title: 'Mensaje del Sistema !',
                    text: 'El paciente ya se encuentra en estado de Atendido',
                    footer: 'ya no puede cambiar de estado este paciente!',
                    imageUrl: '../../assets/images/logo.png',
                    imageWidth: 300,
                    imageHeight: 200,
                    imageAlt: 'Custom image',
                    showConfirmButton: false,
                    timer: 5000,

                })
            }
        </script>