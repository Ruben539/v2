<?php
session_start();

require_once("../Models/conexion.php");

if (empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta'])) {

  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar las fechas a buscar
  </div>';
  exit();
}

if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])) {
  date_default_timezone_set('America/Asuncion');

  $fecha_desde = date_create($_REQUEST['fecha_desde']);
  $desde = date_format($fecha_desde, 'Y-m-d');


  $fecha_hasta = date_create($_REQUEST['fecha_hasta']);
  $hasta = date_format($fecha_hasta, 'Y-m-d');

  $valor = trim($_REQUEST['valor']);

  $buscar = '';
  $where = '';
}

$f_de = $desde . '-00:00:00';
$f_a  = $hasta . '-23:00:00';
$where = "c.created_at BETWEEN '$f_de' AND '$f_a' AND m.nombre LIKE '%" . $valor . "%' ";
$wherePaz = "c.created_at BETWEEN '$f_de' AND '$f_a' AND m.nombre LIKE '%PAZ%' ";
$buscar = "fecha_desde=$desde&fecha_hasta=$hasta ";

//echo $where;
//exit;
$sql_efectivo = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE $where  AND dc.forma_pago_id = 1 GROUP BY c.id");

$resultado_efectivo = mysqli_num_rows($sql_efectivo);


$sql_post = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE $where  AND dc.forma_pago_id = 2 GROUP BY c.id");

$resultado_post = mysqli_num_rows($sql_post);


//TODO: query para obtener la cantidad de pago por pos en PAZ.
$post_paz = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE c.created_at BETWEEN '$f_de' AND '$f_a' AND m.nombre LIKE '%PAZ%'   AND dc.forma_pago_id = 2 GROUP BY c.id");

$resultado_posPaz = mysqli_num_rows($post_paz);

$monto    = 0;
$montoPOS = 0;
while($data = mysqli_fetch_array($post_paz)){
  $monto =  $data['monto'];
}
$montoPOS += $monto -10000;


$sql_transferencia = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE $where  AND dc.forma_pago_id = 3 GROUP BY c.id");

$resultado_transferencia = mysqli_num_rows($sql_transferencia);


$sql_seguros = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE $where  AND dc.forma_pago_id = 4 GROUP BY c.id");

$resultado_seguros = mysqli_num_rows($sql_seguros);

$sql_doctores = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, dc.monto,dc.descuento, m.nombre as doctor, 
m.id as docID,fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE $where   GROUP BY c.id");

$resultado_doctores = mysqli_num_rows($sql_doctores);

$fecha= '';
$medico = '';

while($data = mysqli_fetch_array($sql_doctores)){
  $fecha     = $data['created_at'];
  $medico    = $data['doctor'];
  $doctor_id = $data['docID'];
}


ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/bootstrap/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/v2/bootstrap/dist/css/bootstrap.min.css">
  <title>Reporte de Comprobantes</title>
</head>

<body>

<main class="app-content">


     <!---------------------Tabla de gatos apara el reporte de EFECTIVO----------------------------------->
     <?php if($resultado_efectivo > 0){?>  
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos de la Rendición</h5>
          <div class="table-responsive">
            <div>
      
              <p>Fecha  : <?php echo $desde; ?></p>
              <hr>
              <p>Forma de pago : EFECTIVO</p>

            </div>
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 11px; margin-left: -35px;">
              <thead>
                <tr class="text-center" style="font-size: 11px;font-weight: bold;">
                  <th>Nro Ticket </th>
                  <th>Ruc </th>
                  <th>Nombre</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Desc.</th>
                  <th>Monto Cobrado</th>
                  <th>Forma de Pago</th>
                  <th>Seguro</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 date_default_timezone_set('America/Asuncion');
                
                 $query_diax = mysqli_query($conection,"SELECT count(DISTINCT(c.id)) AS cantidad  FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
                 INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
                 WHERE $wherePaz AND dc.forma_pago_id = 1  AND c.estatus = 1");
       
                 $resultado_diax = mysqli_num_rows($query_diax);
                 $cantidadPaz  = 0;
                 $porcentaje = 0;
               
                 while($data = mysqli_fetch_array($query_diax)){
       
                     $cantidadPaz  = $data['cantidad'];
                    
       
                 }

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $totalEfectivo = 0;
                $precio = 0;
                $totalDiaxEfectivo = 0;
                $totalMedicoEfectivo = 0;
                $montoFinalEfectivo = 0;
                $estatus = 0;


                if ($resultado_efectivo > 0) {
                  while ($data = mysqli_fetch_array($sql_efectivo)) {
                    $estatus = $data['estatus'];
                    if($estatus == 1){
                      $precio = $data['monto'];
                     
                    }else{
                      $precio = 0;
                    }
                    
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias' ) {
                      $monto =  $precio;
                    }

                    $totalEfectivo += ($monto - $data['descuento']);
                    $montoFinalEfectivo =  $totalEfectivo;
                    $totalDiaxEfectivo = $montoFinalEfectivo * 0.3;
                    $totalMedicoEfectivo = $montoFinalEfectivo * 0.7;
                ?>
                <?php if($estatus == 1){?>

                    <tr class="text-center" style="font-size: 10px; font-weight: 500;">
                <?php }else{?>
                  <tr class="text-center alert alert-danger" style="font-size: 10px; font-weight: 500;">
                <?php }?>
                
                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <?php if($estatus == 1){?>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <?php }else{?>
                        <td><b><?php echo 0; ?></b></td>
                      <?php }?>
                        <td><?php echo $data['forma_pago'] ?></td>
                        <td><?php echo $data['seguro'] ?></td>
                     
                    </tr>
                <?php }
                } 
                
               
                
                
                ?>
              </tbody>
            </table>
            <section>
              <?php if($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4|| $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14){?>
                <p>Ingreso Total :</p>
                <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalEfectivo - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
                <p>Total Bio Paz Efectivo</p>
                <p style="text-align: right;" class="alert alert-warning"> <?php echo number_format($cantidadPaz * 10000); ?>.<b>GS</b></p>
                <p>Resultado Final</p>
                <p style="text-align: right;" class="alert alert-success"> <?php echo number_format(($totalEfectivo - $descuento) - ($cantidadPaz * 10000)); ?>.<b>GS</b></p>
              <?php }else{?>
                <table class="table table-striped text-center">
                <thead>
                <th class="alert alert-success">Total Diax</th>
                <th class="alert alert-info">Total Doctor</th>
                <th class="alert alert-warning">Total Ingresado</th>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo number_format($totalDiaxEfectivo,0,'.','.'); ?></td>
                    <td><?php echo number_format($totalMedicoEfectivo ,0,'.','.'); ?></td>
                    <td><?php echo number_format($totalEfectivo,0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-striped text-center">
              <thead>
                <th>Cantidad Bio Paz</th>
                <th></th>
                <th>Bio Paz Efectivo</th>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $cantidadPaz; ?></td>
                  <td></td>
                  <td><?php echo number_format($cantidadPaz * 10000,0,'.','.'); ?></td>
                </tr>
              </tbody>
            </table>
              <table class="table table-striped">
              <thead>
                <th></th>
                <th></th>
                <th></th>
              </thead>
              <tbody>
                <tr>
                  <td>Monto Total Efectivo</td>
                  <td></td>
                  <td><?php echo number_format((($cantidadPaz * 10000) + $totalEfectivo),0,'.','.'); ?></td>
                </tr>
              </tbody>
            </table>
                <table class="table table-striped">
                <thead>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                  <tr>
                    <td>Monto total POS</td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($montoPOS,0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>
                <table class="table table-striped">
                <thead>
                <th></th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                  <tr>
                    <td>Diferencia</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format((($cantidadPaz * 10000) + $totalEfectivo) - $montoPOS,0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>
              <?php }?>
            </section>
          </div>
        </div>
      </div>
    </div>
    <?php }?>


    <!---------------------Tabla de gatos apara el reporte de POST----------------------------------->
    <?php if($resultado_post > 0){?>  
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos Pacientes</h5>
          <div class="table-responsive">
            <div>
              
              <p>Forma de pago : POST</p>
            </div>
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 11px; margin-left: -35px;">
              <thead>
                <tr class="text-center"  style="font-size: 11px;font-weight: bold;">
                  <th>Nro Ticket </th>
                  <th>Ruc </th>
                  <th>Nombre</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Desc.</th>
                  <th>Monto Cobrado</th>
                  <th>Forma de Pago</th>
                  <th>Seguro</th>
                
                </tr>
              </thead>
              <tbody>
                <?php

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $totalPOST = 0;
                $totalDiaxPOST = 0;
                $totalMedicoPOST = 0;
                $precio = 0;
                $estatus = 0;

                if ($resultado_post > 0) {
                  while ($data = mysqli_fetch_array($sql_post)) {
                    $estatus = $data['estatus'];
                    if($estatus == 1){
                      $precio = $data['monto'];
                    }else{
                      $precio = 0;
                    }

                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $totalPOST += $monto;
                    $totalDiaxPOST = $totalPOST * 0.3;
                    $totalMedicoPOST = $totalPOST * 0.7;
                ?>

                     <?php if($estatus == 1){?>

                    <tr class="text-center" style="font-size: 10px; font-weight: 500;">
                <?php }else{?>
                  <tr class="text-center alert alert-danger" style="font-size: 10px; font-weight: 500;">
                <?php }?>
                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <?php if($estatus == 1){?>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <?php }else{?>
                        <td><b><?php echo 0; ?></b></td>
                      <?php }?>
                        <td><?php echo $data['forma_pago'] ?></td>
                        <td><?php echo $data['seguro'] ?></td>
                      
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <?php if($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14){?>
                  <p>Ingreso Total :</p>
                <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalPOST - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
                
                <?php }else{?>
                  <table class="table table-striped text-center">
                  <thead>
                  <th class="alert alert-success">Total Diax</th>
                  <th class="alert alert-info">Total Doctor</th>
                  <th class="alert alert-warning">Total Ingresado</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo number_format($totalDiaxPOST - $descuento,0,'.','.'); ?></td>
                      <td><?php echo number_format($totalMedicoPOST - $descuento,0,'.','.'); ?></td>
                      <td><?php echo number_format(($totalPOST - $descuento),0,'.','.'); ?></td>
                    </tr>
                  </tbody>
                </table>
                <?php }?>
            </section>
          </div>
        </div>
      </div>
    </div>
    <?php }?>


    <!---------------------Tabla de gatos apara el reporte de TRANSFERENCIA----------------------------------->
    <?php if($resultado_transferencia > 0){?>  
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos Pacientes</h5>
          <div class="table-responsive">
            <div>
              
              <p>Forma de pago : TRANSFERENCIA</p>
            </div>
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 11px; margin-left: -35px;">
              <thead>
                <tr class="text-center"  style="font-size: 11px;font-weight: bold;">
                 <th>Nro Ticket </th>
                  <th>Ruc </th>
                  <th>Nombre</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Desc.</th>
                  <th>Monto Cobrado</th>
                  <th>Forma de Pago</th>
                  <th>Seguro</th>
                
                </tr>
              </thead>
              <tbody>
                <?php

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $totalTransferencia = 0;
                $totalDiaxTransferencia = 0;
                $totalMedicoTransferencia = 0;
                $precio = 0;
                $estatus= 0;

                if ($resultado_transferencia > 0) {
                  while ($data = mysqli_fetch_array($sql_transferencia)) {
                    $estatus = $data['estatus'];
                    if($estatus == 1){
                      $precio = $data['monto'];
                    }else{
                      $precio = 0;
                    }
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $totalTransferencia += $monto;
                    $totalDiaxTransferencia = $totalTransferencia * 0.3;
                    $totalMedicoTransferencia = $totalTransferencia * 0.7;
                ?>
 <?php if($estatus == 1){?>

<tr class="text-center" style="font-size: 10px; font-weight: 500;">
<?php }else{?>
<tr class="text-center alert alert-danger" style="font-size: 10px; font-weight: 500;">
<?php }?>
 <td><?php echo $data['id']; ?></td>
  <td><?php echo $data['ruc']; ?></td>
  <td><?php echo $data['razon_social']; ?></td>
  <td><?php echo $data['estudio']; ?></td>
  <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
  <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
  <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
  <?php if($estatus == 1){?>
  <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
  <?php }else{?>
    <td><b><?php echo 0; ?></b></td>
  <?php }?>
    <td><?php echo $data['forma_pago'] ?></td>
    <td><?php echo $data['seguro'] ?></td>
                      
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <?php if($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14){?>
                  <p>Ingreso Total :</p>
                <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalTransferencia - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
                
                <?php }else{?>
                  <table class="table table-striped text-center">
                  <thead>
                  <th class="alert alert-success">Total Diax</th>
                  <th class="alert alert-info">Total Doctor</th>
                  <th class="alert alert-warning">Total Ingresado</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo number_format($totalDiaxTransferencia - $descuento,0,'.','.'); ?></td>
                      <td><?php echo number_format($totalMedicoTransferencia - $descuento,0,'.','.'); ?></td>
                      <td><?php echo number_format(($totalTransferencia - $descuento),0,'.','.'); ?></td>
                    </tr>
                  </tbody>
                </table>
                <?php }?>
            </section>
          </div>
        </div>
      </div>
    </div>
    <?php }?>


    <!---------------------Tabla de gatos apara el reporte de SEGUROS----------------------------------->
    <?php if($resultado_seguros > 0){?>  
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos Pacientes</h5>
          <div class="table-responsive">
            <div>
            
              <p>Forma de pago : SEGUROS</p>
            </div>
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 11px; margin-left: -35px;">
              <thead>
                <tr class="text-center"  style="font-size: 11px;font-weight: bold;">
                  <th>Nro Ticket </th>
                  <th>Ruc </th>
                  <th>Nombre</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Desc.</th>
                  <th>Monto Cobrado</th>
                  <th>Forma de Pago</th>
                  <th>Seguro</th>
                
                </tr>
              </thead>
              <tbody>
                <?php

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $totalSeguro = 0;
                $totalDiaxSeguro = 0;
                $totalMedicoSeguro = 0;
                $precio = 0;
                $montoFinalSeguro = 0;
                $estatus = 0;

                if ($resultado_seguros > 0) {
                  while ($data = mysqli_fetch_array($sql_seguros)) {
                    $estatus = $data['estatus'];
                    if($estatus == 1){
                      $precio = $data['monto'];
                    }else{
                      $precio = 0;
                    }

                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $totalSeguro += $monto;
                    $montoFinalSeguro = $totalSeguro - $descuento;
                    $totalDiaxSeguro = $montoFinalSeguro * 0.3;
                    $totalMedicoSeguro = $montoFinalSeguro * 0.7;

                ?>
 <?php if($estatus == 1){?>

<tr class="text-center" style="font-size: 10px; font-weight: 500;">
<?php }else{?>
<tr class="text-center alert alert-danger" style="font-size: 10px; font-weight: 500;">
<?php }?>
<td><?php echo $data['id']; ?></td>
  <td><?php echo $data['ruc']; ?></td>
  <td><?php echo $data['razon_social']; ?></td>
  <td><?php echo $data['estudio']; ?></td>
  <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
  <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
  <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
  <?php if($estatus == 1){?>
  <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
  <?php }else{?>
    <td><b><?php echo 0; ?></b></td>
  <?php }?>
    <td><?php echo $data['forma_pago'] ?></td>
    <td><?php echo $data['seguro'] ?></td>
                      
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
            <?php if($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14){?>
                  <p>Ingreso Total :</p>
                <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalSeguro - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
                
                <?php }else{?>
                  <table class="table table-striped text-center">
                  <thead>
                  <th class="alert alert-success">Total Diax</th>
                  <th class="alert alert-info">Total Doctor</th>
                  <th class="alert alert-warning">Total Ingresado</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo number_format($totalDiaxSeguro ,0,'.','.'); ?></td>
                      <td><?php echo number_format($totalMedicoSeguro,0,'.','.'); ?></td>
                      <td><?php echo number_format(($montoFinalSeguro),0,'.','.'); ?></td>
                    </tr>
                  </tbody>
                </table>
                <?php }?>
            </section>
          </div>
        </div>
      </div>
    </div>
<?php }?>
  </main>

</body>

</html>
<?php
$html = ob_get_clean();
//echo $html;

require_once "../Library/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

//$dompdf->setPaper('letter');
$dompdf->setPaper('A4', 'portrait');



$dompdf->render();
$dompdf->stream('reporte-Comprobante.pdf', array('Attachment' => false));

?>