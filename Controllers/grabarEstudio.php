<?php


require_once("../Models/conexion.php");
$alert = '';
if (!empty($_POST)) {
	$alert = '';

	if (empty($_POST['nombre']) || empty($_POST['seguro'])  || empty($_POST['preferencial'])) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

	}else{

		$nombre        = $_POST['nombre'];
		$seguro        = $_POST['seguro'];
		$preferencial  = $_POST['preferencial'];
		$hospitalario  = $_POST['hospitalario'];
		$categoria_id  = $_POST['categoria_id'];
		

		$resultado = 0;

		$query = mysqli_query($conection,"SELECT * FROM estudios WHERE nombre = '$nombre' ");

		$resultado = mysqli_fetch_array($query);



			$query_insert = mysqli_query($conection,"INSERT INTO estudios(nombre,seguro,preferencial,hospitalario,categoria_id)
				VALUES('$nombre','$seguro','$preferencial','$hospitalario','$categoria_id')");

			if ($query_insert ) {
				$alert = '<p class = "msg_save">Registro Guardado Correctamente</p>';

			}else{
				$alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
			}

	}
	mysqli_close($conection);
}
