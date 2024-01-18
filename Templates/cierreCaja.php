<?php

require_once("../includes/header_admin.php");
require_once("../Models/conexion.php");
?>
<?php
date_default_timezone_set('America/Asuncion');
$fecha  =  date('Y-m-d');
$sql = mysqli_query($conection, "SELECT (SUM(dc.monto) - dc.descuento) monto  FROM comprobantes c 
             INNER JOIN medicos m ON m.id = c.doctor_id 
             INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
             where c.created_at LIKE '%" . $fecha . "%'  AND c.estatus = 1");

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
    header("location: ../Templates/cierreCaja.php");
} else {
    $montoIngreso = 0;
    while ($data = mysqli_fetch_array($sql)) {
        $montoIngreso = $data['monto'];
        $ingreso = number_format($data['monto'], 0, '.', '.');
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Monto Ingresado</p>
                                <h1 class="mb-0"><?php echo $ingreso; ?></h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                        </div>
                        <canvas id="expense-chart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha  =  date('Y-m-d');
            $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) as pacientes FROM comprobantes c 
             where c.created_at LIKE '%" . $fecha . "%' and c.estatus = 1");

            //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


            $resultado = mysqli_num_rows($sql);

            if ($resultado == 0) {
                header("location: ../Templates/cierreCaja.php");
            } else {
                $cantidadPacientes = 0;
                while ($data = mysqli_fetch_array($sql)) {
                    $cantidadPacientes = $data['pacientes'];
                    $pacientes = $data['pacientes'];
                }
            }
            ?>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Cantidad de Pacientes</p>
                                <h1 class="mb-0"><?php echo $pacientes; ?></h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                        </div>
                        <canvas id="budget-chart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <?php
            date_default_timezone_set('America/Asuncion');
            $fecha  =  date('Y-m-d');
            $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.doctor_id)) AS medicos 
            FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id
            WHERE m.id IN (SELECT c.doctor_id FROM comprobantes) AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1");

            //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


            $resultado = mysqli_num_rows($sql);

            if ($resultado == 0) {
                header("location: ../Templates/cierreCaja.php");
            } else {
                $cantidadMedicos = 0;
                while ($data = mysqli_fetch_array($sql)) {
                    $cantidadMedicos = $data['medicos'];
                    $medicos = $data['medicos'];
                }
            }
            ?>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Cantidad de medicos que atendieron</p>
                                <h1 class="mb-0"><?php echo $medicos; ?></h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                    <div class="titulos col-md-3">
                        <h3>Medicos Paz</h3>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered text-center" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre del Medico</th>
                                    <th>Cantidad de Paciente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha  =  date('Y-m-d');
                                $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre 
                                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                                INNER JOIN medicos m ON m.id = c.doctor_id 
                                WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
                                AND m.nombre LIKE '%PAZ%' AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY m.nombre ORDER BY cantidad DESC");

                                $resultado = mysqli_num_rows($sql);
                                $row = 0;
                                if ($resultado > 0) {
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $row++;
                                ?>
                                        <tr class="text-center">

                                            <td><?php echo $row; ?></td>
                                            <td><?php echo $data['nombre']; ?></td>
                                            <td><?php echo $data['cantidad']; ?></td>

                                        </tr>


                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!---Fin de la tabla-------------------------------------------->
        
        <hr>
        <!---Tabla de los pacientes que deriven de la consulta de DIAX--->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="titulos col-md-3">
                        <h3>Medicos Diax</h3>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered text-center" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre del Medico</th>
                                    <th>Cantidad de Paciente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha  =  date('Y-m-d');
                                $sql = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre 
                                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                                INNER JOIN medicos m ON m.id = c.doctor_id 
                                WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
                                AND m.nombre LIKE '%DIAX%' AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY m.nombre ORDER BY cantidad DESC");

                                $resultado = mysqli_num_rows($sql);
                                $row = 0;
                                if ($resultado > 0) {
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $row++;
                                ?>
                                        <tr class="text-center">

                                            <td><?php echo $row; ?></td>
                                            <td><?php echo $data['nombre']; ?></td>
                                            <td><?php echo $data['cantidad']; ?></td>

                                        </tr>


                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!---Fin de la tabla-------------------------------------------->
         <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="titulos col-md-3">
                        <h4>Formas de Pago Paz</h4>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered text-center" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Forma de Pago</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha  =  date('Y-m-d');

                                $sql = mysqli_query($conection, "SELECT f.descripcion, COUNT(dc.forma_pago_id) AS cantidad, dc.monto,dc.monto_seguro
                                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                                INNER JOIN forma_pagos f ON f.id = dc.forma_pago_id
                                INNER JOIN medicos m ON m.id = c.doctor_id
                                WHERE m.nombre LIKE '%PAZ%' AND c.created_at  LIKE '%" . $fecha . "%' AND c.estatus = 1 
                                GROUP BY f.descripcion ORDER BY cantidad DESC");

                                $resultado = mysqli_num_rows($sql);
                                $row = 0;
                                $monto = 0;
                                $montoSeguro = 0;
                                $total = 0;
                                if ($resultado > 0) {
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $row++;
                                        $monto       = $data['monto'];
                                        $montoSeguro = $data['monto_seguro'];
                                        $total += $monto;
                                ?>
                                        <tr class="text-center">

                                            <td><?php echo $row; ?></td>
                                            <td><?php echo $data['descripcion']; ?></td>
                                            <td><?php echo $data['cantidad']; ?></td>
                                            <?php if($data['descripcion'] == 'Seguro'){?>
                                            <td><?php echo number_format($montoSeguro, 0, '.', '.'); ?></td>
                                            <?php }else{?>
                                                <td><?php echo number_format($total, 0, '.', '.'); ?></td>
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
        <!---Fin de la tabla-------------------------------------------->
            <!---Fin de la tabla-------------------------------------------->
            <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="titulos col-md-3">
                        <h4>Formas de Pago Diax</h4>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered text-center" id="tabla">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha  =  date('Y-m-d');

                                $sql = mysqli_query($conection, "SELECT SUM(dc.monto) - dc.descuento, AS monto, dc.monto_seguro  FROM comprobantes c 
                                INNER JOIN medicos m ON m.id = c.doctor_id 
                                INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                                where c.created_at LIKE '%$fecha%' AND m.nombre like '%DIAX%' AND c.estatus = 1");

                                $resultado = mysqli_num_rows($sql);
                                $row = 0;
                                $monto = 0;
                                $montoSeguro = 0;
                                $total = 0;
                                $precio = 0;
                                if ($resultado > 0) {
                                    while ($data = mysqli_fetch_array($sql)) {
                                        $row++;
                                        $precio = $data['monto'];

                                    if($data['estudio']) {
                                            $monto = $precio * $data['nro_radiografias'];
                                    } else if ($data['estudio'] != 'Radiografias') {
                                            $monto =  $precio;
                                    }
                                       
                                ?>
                                        <tr class="text-center">

                                            <td><?php echo $row; ?></td>
                                            
                                            <td><?php echo $data['monto']; ?></td>
                                        


                                        </tr>


                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!---Fin de la tabla-------------------------------------------->
        <hr>
        <!---Tabla de los pacientes que deriven de la consulta de DIAX--->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="titulos col-md-3">
                        <h4>Pendientes a Cobrar</h4>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered" id="tabla">
                            <thead>
                                <tr>
                                    <th class="ml-5">Nro Ticket</th>
                                    <th>Ruc </th>
                                    <th>Razon Social</th>
                                    <th>Estudio</th>
                                    <th>Monto</th>
                                    <th>Monto Seguro</th>
                                    <th>Descuento</th>
                                    <th>Doctor</th>
                                    <th>Seguro</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fecha =  date('Y-m-d');
                                //  echo $fecha1." ".$fecha2;
                                //  exit;
                                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
                               s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro
                                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                                INNER JOIN medicos m ON m.id = c.doctor_id
                                INNER JOIN seguros s ON s.id = dc.seguro_id
                                WHERE m.nombre LIKE '%PAZ%'  AND c.created_at LIKE '%". $fecha."%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");
                
                                $resultado = mysqli_num_rows($sql);
                                $paz = 0;
                                $descuento = 0;
                                $nro = 0;
                                if ($resultado > 0) {
                                  while ($data = mysqli_fetch_array($sql)) {
                                    $paz += (int)$data['monto'];
                                    $descuento += (int)$data['descuento'];
                                    $nro++;
                                ?>
                                    <tr class="text-center">
                
                                      <td><?php echo $data['id'];?></td>
                                      <td><?php echo $data['ruc']; ?></td>
                                      <td><?php echo $data['razon_social']; ?></td>
                                      <td><?php echo $data['estudio']; ?></td>
                                      <td><?php echo number_format($data['monto'],0, '.', '.'); ?></td>
                                      <td><?php echo number_format($data['monto_seguro'],0, '.', '.'); ?></td>
                                      <td><?php echo number_format($data['descuento'],0, '.', '.'); ?></td>
                                      <td><?php echo $data['doctor'] ?></td>
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
        <!---Fin de la tabla-------------------------------------------->

        <?php include('../includes/footer_admin.php'); ?>