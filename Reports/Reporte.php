<?php 

session_start();

require_once("../Models/conexion.php");

$hoy =  date('d-m-Y');

$sql = mysqli_query($conection,"SELECT DISTINCT(h.id),c.Nombre,c.Apellido,c.Nacimiento,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
FROM historial h inner join clientes c on c.cedula = h.cedula WHERE  h.Fecha like '%$hoy%'  ORDER BY h.id DESC LIMIT 1 ");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

//echo 'paso el sql';
//exit();


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
     
	header("location: ../Templates/dashboard.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		$id          = $data['id'];
		$Cedula      = $data['Cedula'];
		$Estudio     = $data['Estudio'];
		$Atendedor   = $data['Atendedor'];
		$Seguro      = $data['Seguro'];
		$Monto       = $data['Monto'];
		$Descuento   = $data['Descuento'];
		$Comentario  = $data['Comentario'];
		$Fecha       = $data['Fecha'];
		$Nombre      = $data['Nombre'];
		$Apellido    = $data['Apellido'];
		$Nacimiento    = $data['Nacimiento'];

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
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistema_diax/bootstrap/dist/css/bootstrap.min.css">
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

                    <td><?php echo $Cedula; ?></td>
                    <td><?php echo $Nombre.' '.$Apellido; ?></td>
                    <td><?php echo $Nacimiento; ?></td>
                    <td><?php echo $Fecha; ?></td>
                    <td><?php echo $Estudio; ?></td>
                    <td><?php echo $Atendedor; ?></td>
                    <td><?php echo $Monto; ?></td>
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

                    <td><?php echo $Cedula; ?></td>
                    <td><?php echo $Nombre.' '.$Apellido; ?></td>
                    <td><?php echo $Nacimiento; ?></td>
                    <td><?php echo $Fecha; ?></td>
                    <td><?php echo $Estudio; ?></td>
                    <td><?php echo $Atendedor; ?></td>
                    <td><?php echo $Monto; ?></td>
                    <td><?php echo $Descuento; ?></td>
                    <td><?php echo $Seguro; ?></td>
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
