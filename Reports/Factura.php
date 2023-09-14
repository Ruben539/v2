<?php 

session_start();

require_once("../Models/conexion.php");
if (empty($_SESSION['active'])) {
	header('location: ../Templates/salir.php');
}


	

//Recuperacion de datos para mostrar al seleccionar Actualizar
//echo $_REQUEST['id'];
//exit();


if (empty($_REQUEST['id'])) {
	header('location: ../Templates/dashboard.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT h.id,c.Nombre,c.Apellido,c.Celular,c.Nacimiento,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
FROM historial h inner join clientes c on c.cedula = h.cedula  WHERE h.id = $id");   

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
		$Nacimiento  = $data['Nacimiento'];
		$Celular     = $data['Celular'];

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
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/assets/css/style.css">
  <title>Factura</title>
</head>

<body>

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/assets/images/logo.png" 
                    style="width: 100px;
                    height: 100px;
                    border: 2px solid #0a4661;
                    border-radius: 50%;"
                    >
				</div>
			</td>
			<td class="info_empresa">
				<h1>Centro Medico La Paz Diax</h1>
				<p>Primera Junta Municipal, Fernando de la Mora</p>
				<p>Telefono: 021514974</p>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Factura: 001-003-0000001 <strong></strong></p>
					<p>Fecha: <?php echo $Fecha; ?></p>
					<p>Timbrado: 123456789</p>
					<p>Inicio Vigencia: 09-06-2023</p>
					<p>Fin Vigencia: 09-06-2024</p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Datos del Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Ruc : </label><p> <?php echo $Cedula; ?></p></td>
							<td><label>Teléfono: </label> <p> <?php echo $Celular; ?></p></td>
						</tr>
						<tr>
							<td><label>Nombre: </label> <p> <?php echo $Nombre.''.$Apellido; ?></p></td>
							<td><label>Fecha Nac. : </label> <p> <?php echo $Nacimiento;?></p></td>
							
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			
				<tr>
					<td class="textcenter"><?php echo $cont;?></td>
					<td><?php echo $Estudio;?></td>
					<td class="textright"><?php echo $Monto;?></td>
					<td class="textright"><?php echo $Monto;?></td>
				</tr>
			
				
			</tbody>
           
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
					<td class="textright"><span></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA ( %)</span></td>
					<td class="textright"><span></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL Q.</span></td>
					<td class="textright"></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">Gracias por su Visita</h4>
	</div>

</div>

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/assets/images/logo.png" 
                    style="width: 100px;
                    height: 100px;
                    border: 2px solid #0a4661;
                    border-radius: 50%;"
                    >
				</div>
			</td>
			<td class="info_empresa">
			<h1>Centro Medico La Paz Diax</h1>
				<p>Primera Junta Municipal, Fernando de la Mora</p>
				<p>Telefono: 021514974</p>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Factura: 001-003-0000001 <strong></strong></p>
					<p>Fecha: <?php echo $Fecha; ?></p>
					<p>Timbrado: 123456789</p>
					<p>Inicio Vigencia: 09-06-2023</p>
					<p>Fin Vigencia: 09-06-2024</p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Datos del Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Ruc : </label><p> <?php echo $Cedula; ?></p></td>
							<td><label>Teléfono: </label> <p> <?php echo $Celular; ?></p></td>
							
						</tr>
						<tr>
							<td><label>Nombre: </label> <p> <?php echo $Nombre.''.$Apellido; ?></p></td>
							<td><label>Fecha de Nac. : </label> <p> <?php echo $Nacimiento; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			
				<tr>
					<td class="textcenter"><?php echo $cont;?></td>
					<td><?php echo $Estudio;?></td>
					<td class="textright"><?php echo $Monto;?></td>
					<td class="textright"><?php echo $Monto;?></td>
				</tr>
			
				
			</tbody>
           
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
					<td class="textright"><span></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA ( %)</span></td>
					<td class="textright"><span></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL Q.</span></td>
					<td class="textright"></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">Gracias por su Visita</h4>
	</div>

</div>

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
$dompdf->stream('reporte-cliente.pdf', array('Attachment' => false));
$dompdf->stream($Cedula."-".$Fecha);
$output = $dompdf->output();
file_put_contents("comprobante", $output);

?>
