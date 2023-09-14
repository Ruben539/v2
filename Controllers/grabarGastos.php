<?php


require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {
	

	if (empty($_POST['descripcion']) || empty($_POST['monto']) ) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

	}else{

		$descripcion   = $_POST['descripcion'];
		$monto         = $_POST['monto'];
		$estatus       = $_POST['estatus'];
  		
		

		$resultado = 0;

		$query = mysqli_query($conection,"SELECT * FROM gastos WHERE descripcion = '$descripcion' ");

		$resultado = mysqli_fetch_array($query);



			$query_insert = mysqli_query($conection,"INSERT INTO gastos(descripcion,monto,estatus)
				VALUES('$descripcion','$monto','$estatus')");


			if ($query_insert) {
        
                $alert = '<p class = "msg_save">Registro Guardado Correctamente</p>';


			}else{
				$alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
			}

	}
	mysqli_close($conection);
}
