<?php 



require_once("../Models/conexion.php");
$alert = '';

if (!empty($_POST)) {
	$alert = '';

	if (empty( $_POST['nombre']) || empty($_POST['seguro']) || empty($_POST['preferencial'])) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

	}else{

		$id              = $_POST['id'];
		$nombre         = $_POST['nombre'];
		$seguro       = $_POST['seguro'];
		$preferencial     = $_POST['preferencial'];
		$hospitalario      = $_POST['hospitalario'];
		


//echo "SELECT * FROM usuario

		//WHERE(usuario = '$user' AND idusuario != $iduser) or (correo = '$email' AND idusuario != $iduser";
//exit; sirve para ejectuar la consulta en mysql
		$query = mysqli_query($conection,"SELECT * FROM estudios
			WHERE  id != id"
		);

		$resultado = mysqli_fetch_array($query);


	}

	if ($resultado > 0) {
		$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';

	}else{

		$sql_update = mysqli_query($conection,"UPDATE estudios SET nombre = '$nombre', seguro = '$seguro',
		 preferencial = '$preferencial', hospitalario = '$hospitalario' WHERE id = $id");

		if ($sql_update) {

			$alert = '<p class = "msg_success">Actualizado Correctamente</p>';

		}else{
			$alert = '<p class = "msg_error">Error al Actualizar el Registro</p>';
		}
	}
}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
	header('location: ../Plantillas/estudios.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT * FROM estudios  WHERE id = $id");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Plantillas/estudios.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		$id            = $data['id'];
		$nombre        = $data['nombre'];
		$seguro        = $data['seguro'];
		$preferencial  = $data['preferencial'];
		$hospitalario  = $data['hospitalario'];

	}
}
