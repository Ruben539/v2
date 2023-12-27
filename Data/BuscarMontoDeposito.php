<?php 



require_once("../Models/conexion.php");
$alert = '';
$result = '';


//Recuperacion del monto para mostrar al seleccionar Actualizar


$fecha = $_POST['fecha'];



$sql = mysqli_query($conection,"SELECT SUM(dc.monto - dc.descuento) as monto FROM detalle_comprobantes dc INNER JOIN comprobantes c ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id
WHERE dc.forma_pago_id = 1 AND m.nombre LIKE '%DIAX%' AND c.created_at LIKE '%".$fecha."%' AND c.estatus = 1");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Templates/seguros.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		
		$monto  = $data['monto'];	
		 $result = number_format($monto,'.','.');

	}
	echo $result;
	
}