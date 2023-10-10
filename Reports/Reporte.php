<?php 

session_start();
require_once("../Models/conexion.php");

$hoy =  date('Y-m-d');
$id = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,u.fecha_nac,u.nombre,
SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
WHERE c.id = '".$id."' AND c.created_at like '%$hoy%'  ORDER BY c.id DESC LIMIT 1 ");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

//echo 'paso el sql';
//exit();


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
     
	header("location: ../Templates/dashboard.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		$id            = $data['id'];
		$ruc           = $data['ruc'];
		$razon_socual  = $data['razon_social'];
		$medico        = $data['doctor'];
		$seguro        = $data['seguro'];
		$estudio       = $data['estudio'];
		$monto         = number_format($data['monto'],0, '.', '.');
		$descuento     = number_format($data['descuento'],0, '.', '.');
		$comentario    = $data['comentario'];
		$created_at    = $data['created_at'];
		$nombre        = $data['nombre'];
		$fecha_nac     = $data['fecha_nac'];

	}
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
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos Pacientes</h5>
          <div class="table-responsive" >
            <table id="tabla_Usuario" class="table table-striped table-bordered table-condensed" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25); font-size: 10px;">
              <thead>
                <tr class="text-center">

             
                <th>Cedula</th>
                <th>Nombre</th>
                <th>F. Nacimiento</th>
                <th>Fecha Carga</th>
                <th>Estudio /os</th>
                <th>Medico</th>
                <th>Monto</th>
                <th>ID</th>
                

                </tr>
              </thead>

              <tbody>
                
                    <tr class="text-center">

                    <td><?php echo $ruc; ?></td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $fecha_nac; ?></td>
                    <td><?php echo $created_at; ?></td>
                    <td><?php echo $estudio; ?></td>
                    <td><?php echo $medico; ?></td>
                    <td><?php echo $monto; ?></td>
                    <td><?php echo $id; ?></td>
                
                    </tr>

              </tbody>  
           </table>
          </div>

          <h5 class="text-center">Uso Interno</h5>
          <div class="table-responsive" >
            <table id="tabla_Usuario" class="table table-striped table-bordered table-condensed" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25); font-size: 10px;">
              <thead>
                <tr class="text-center">

                <th>Cedula</th>
                <th>Nombre</th>
                <th>F. Nacimiento</th>
                <th>Fecha Carga</th>
                <th>Estudio /os</th>
                <th>Medico</th>
                <th>Monto</th>
                <th>Descuento</th>
                <th>Seguro</th>
                <th>ID</th>
                

                </tr>
              </thead>

              <tbody>
                
                    <tr class="text-center">

                    <td><?php echo $ruc; ?></td>
                    <td><?php echo $nombre; ?></td>
                    <td><?php echo $fecha_nac; ?></td>
                    <td><?php echo $created_at; ?></td>
                    <td><?php echo $estudio; ?></td>
                    <td><?php echo $medico; ?></td>
                    <td><?php echo $monto; ?></td>
                    <td><?php echo $descuento; ?></td>
                    <td><?php echo $seguro; ?></td>
                    <td><?php echo $id; ?></td>
                
                    </tr>

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
$dompdf->stream('reporte-Comprobante.pdf', array('Attachment' => false));

?>
