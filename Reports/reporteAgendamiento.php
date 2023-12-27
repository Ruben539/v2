<?php
session_start();

require_once("../Models/conexion.php");

$doctor = '';
$fecha_desde = '';
$fecha_hasta  = '';
if(empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta']) || empty($_POST['doctor'])) {
  
  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar los parametros a buscar

  </div>';
  exit();
  
}

if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])|| !empty($_REQUEST['doctor'])) {
  $fecha_desde = date_create($_REQUEST['fecha_desde']);
  $desde = date_format($fecha_desde, 'Y-m-d');


  $fecha_hasta = date_create($_REQUEST['fecha_hasta']);
  $hasta = date_format($fecha_hasta, 'Y-m-d');

  $doctor = trim($_POST['doctor']);

 $buscar = '';
 $where = '';

} if ($desde == $hasta) {

  $where = "fecha_inicio LIKE '%$desde%' AND a.doctor_id = '".$doctor."' ";

  $buscar = "fecha_desde=$desde&fecha_hasta=$hasta AND a.doctor_id = '".$doctor."' ";
}else {
  $f_de = $desde.'-00:00:00';
  $f_a  = $hasta.'-23:00:00';
  $where = "fecha_inicio BETWEEN '$f_de' AND '$f_a' AND a.doctor_id = '".$doctor."' ";
  $buscar = "fecha_desde=$desde&fecha_hasta=$hasta AND a.doctor_id = '".$doctor."'";
}

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/v2/bootstrap/dist/css/bootstrap.min.css">
  <title>Agenda de Medico</title>
</head>

<body>

  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Agenda del Dia</h5>
          <div class="table-responsive">
            <table id="tabla_Usuario" class="table table-striped table-bordered table-condensed" style=" font-size: 10px;">
              <thead>
                <tr class="text-center">

                <th>Nro</th>
                <th>Nombre del Paciente</th>
                <th>Motivo de Consulta</th>
                <th>Doctor</th>
                <th>Fecha</th>              

                </tr>
              </thead>

              <tbody>
                <?php

                $anio = date_create($_REQUEST['fecha_desde']);
                 $hoy = date_format($anio, 'Y-m');

                $sql = mysqli_query($conection,"SELECT DISTINCT(a.id),a.nombre,a.agenda, a.fecha_inicio, a.fecha_fin, a.color_evento, m.id as doctor_id, m.nombre as medico
                FROM agendamiento a INNER JOIN medicos m ON m.id = a.doctor_id
               WHERE $where and fecha_inicio like '%".$hoy."%' ORDER BY  a.id DESC");
              
              
                $resultado = mysqli_num_rows($sql);
                $nro = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $nro++;

                ?>
                    <tr class="text-center">

                    <td><?php echo $nro; ?></td>
                    <td><?php echo $data['nombre']; ?></td>
                    <td><?php echo $data['agenda']; ?></td>
                    <td><?php echo $data['medico']; ?></td>
                    <td><?php echo $data['fecha_inicio']; ?></td>

                    </tr>


                <?php }
                } ?>
              </tbody>
            </table>
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
$dompdf->stream('agenda-medicos.pdf', array('Attachment' => false));

?>