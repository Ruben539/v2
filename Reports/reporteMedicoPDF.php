<?php
session_start();
require_once("../Models/conexion.php");

if (empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta']) || empty($_POST['medico'])) {

  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar las fechas a buscar
  </div>';
  exit();
}

if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])) {
  date_default_timezone_set('America/Asuncion');

  $desde = $_REQUEST['fecha_desde'];
  $hasta = $_REQUEST['fecha_hasta'];
  $valor = trim($_REQUEST['medico']);
  $buscar = '';
  $where = '';
  $bio = '';
}

$f_de = $desde . ' 00:00:00';
$f_a  = $hasta . ' 23:00:00';

$where = "c.created_at BETWEEN '" . $f_de . "' AND '" . $f_a . "' AND c.doctor_id = '" . $valor . "' ";
$bio = "c.created_at BETWEEN '" . $f_de . "' AND '" . $f_a . "' AND m.nombre LIKE '%PAZ%' ";
$buscar = "fecha_desde=$desde&fecha_hasta=$hasta ";

/* INICIO DE LA COSULTA PA OBTENER LA LISTA DE BUSQUEDA */

$sql_reporte = mysqli_query($conection, "SELECT c.ruc, c.razon_social, dc.descripcion as estudio, dc.monto,dc.monto_seguro,dc.descuento,dc.nro_radiografias,fp.descripcion as forma_pago,s.descripcion as seguro,
IF(c.estatus = 1, dc.monto, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM detalle_comprobantes dc INNER JOIN comprobantes c ON c.id =  dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id 
WHERE c.created_at BETWEEN '" . $f_de . "' AND '" . $f_a . "' AND  c.doctor_id = $valor AND c.estatus = 1;");

/* FIN DE LA COSULTA PA OBTENER LA LISTA DE BUSQUEDA */


/* FIN DE LA COSULTA PA OBTENER LA LISTA DE PAZ EN BIOS */
$query_bio = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad
FROM detalle_comprobantes dc INNER JOIN comprobantes c ON c.id =  dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id 
WHERE c.created_at BETWEEN '" . $f_de . "' AND '" . $f_a . "' AND  c.doctor_id = $valor AND dc.forma_pago_id = 1 AND  c.estatus = 1;");

while ($data = mysqli_fetch_array($query_bio)) {

  $cantidadBio  = $data['cantidad'];
  $totalBio = $cantidadBio * 10000;
}

/* FIN DE LA COSULTA PA OBTENER LA LISTA DE PAZ EN BIOS */

/* INICIO DE LA COSULTA PA OBTENER AL MEDICO */
$sql_doctores = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, dc.monto,dc.descuento, m.nombre as doctor, 
m.id as docID,fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE c.created_at BETWEEN '" . $f_de . "' AND '" . $f_a . "' AND  c.doctor_id = $valor AND c.estatus = 1  GROUP BY c.id");

$resultado_doctores = mysqli_num_rows($sql_doctores);

$fecha = '';
$medico = '';

while ($data = mysqli_fetch_array($sql_doctores)) {
  $fecha     = $data['created_at'];
  $medico    = $data['doctor'];
  $doctor_id = $data['docID'];
}
/* FIN DE LA COSULTA PA OBTENER AL MEDICO */


$totalIngresado   = 0;
$descuento        = 0;
$monto            = 0;
$porcentajeDiax   = 0;
$porcentajeDoctor = 0;
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
  <title>Reporte de Pacientes por Medico</title>
</head>

<body>

  <main class="app-content">
    <!---------------------Tabla de gatos apara el reporte de EFECTIVO----------------------------------->
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos de la Rendición</h5>
          <div class="table-responsive">
            <div>

              <p>Fecha : <?php echo $desde; ?></p>
              <p>Hasta : <?php echo $hasta; ?></p>
              <p>Medico : <?php echo $medico; ?></p>
              <hr>
            </div>
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 12px; margin-left: -35px;">
              <thead>
                <tr class="text-center" style="font-size: 12px;font-weight: bold;">
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

                while ($data =  mysqli_fetch_array($sql_reporte)) {
                  $descuento       += $data['descuento'];
                  $monto           += $data['monto'];
                  $totalIngresado   = $monto - $descuento;
                  $porcentajeDiax   = $totalIngresado * 0.3;
                  $porcentajeDoctor = $totalIngresado * 0.7;
                ?>
                  <tr>
                    <td><?php echo number_format($data['ruc'], 0, '.', '.'); ?></td>
                    <td><?php echo $data['razon_social']; ?></td>
                    <td><?php echo $data['estudio']; ?></td>
                    <?php if ($data['monto'] == 0) { ?>
                      <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                    <?php } else { ?>
                      <td><?php echo number_format($data['monto'] - 10000, 0, '.', '.'); ?></td>
                    <?php } ?>
                    <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                    <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                    <?php if($data['descuento'] >= $data['monto']){?>
                    <td><?php echo 0; ?></td>
                    <?php } else { ?>
                      <td><?php echo number_format($data['monto'] - $data['descuento'] - 10000, 0, '.', '.'); ?></td>
                      <?php } ?>
                    <td><?php echo $data['forma_pago']; ?></td>
                    <td><?php echo $data['seguro']; ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>

            </table>
            <section>
              <?php if ($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14) { ?>
                <p>Ingreso Total :</p>
                <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalIngresado - $totalBio, 0, '.', '.'); ?>.<b>GS</b></p>
              <?php } else { ?>
                <table class="table table-striped text-center">
                  <thead>
                    <th class="alert alert-success">Total Diax</th>
                    <th class="alert alert-info">Total Doctor</th>
                    <th class="alert alert-warning">Total Ingresado</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?php echo number_format($porcentajeDiax, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($porcentajeDoctor, 0, '.', '.'); ?></td>
                      <td><?php echo number_format(($totalIngresado), 0, '.', '.'); ?></td>
                    </tr>
                  </tbody>
                </table>
              <?php } ?>
            </section>
          </div>
        </div>
      </div>
    </div>



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
$dompdf->setPaper('a4', 'portrait');



$dompdf->render();
$dompdf->stream('reporte-medicos.pdf', array('Attachment' => false));

?>