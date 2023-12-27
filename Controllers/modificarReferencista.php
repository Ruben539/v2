<?php

require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {
	if (empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['fecha_nac'])) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
	} else {

		$id            = $_POST['id'];
		$cedula        = $_POST['cedula'];
		$nombre        = $_POST['nombre'];
		$correo        = $_POST['correo'];
		$telefono      = $_POST['telefono'];
		$fecha_nac     = $_POST['fecha_nac'];



		//echo "SELECT * FROM usuario

		//WHERE(usuario = '$user' AND id != $iduser) or (correo = '$email' AND id != $iduser";
		//exit; sirve para ejectuar la consulta en mysql
		$query = mysqli_query(
			$conection,
			"SELECT * FROM comisionista
				WHERE  id != id"
		);

		$resultado = mysqli_fetch_array($query);
	}

	if ($resultado > 0) {
		$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
	} else {

		$sql_update = mysqli_query($conection, "UPDATE comisionista SET cedula = '$cedula',nombre = '$nombre',correo = '$correo', telefono = '$telefono',fecha_nac = '$fecha_nac'
				WHERE id = $id");

		if ($sql_update) {

			 $alert = '<p class = "msg_success">Actualizado Correctamente</p>';
		} else {
			 $alert = '<p class = "msg_error">Error al Actualizar el Registro</p>';
		}
	}

    
}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
	header('location: ../Templates/usuarios.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT c.id, c.cedula, c.nombre, c.correo, c.telefono, c.fecha_nac, c.created_at 
FROM comisionista c where c.estatus = 1");


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Templates/usuarios.php");
} else {
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {

		$id          = $data['id'];
		$cedula      = $data['cedula'];
		$nombre      = $data['nombre'];
		$correo      = $data['correo'];
		$telefono    = $data['telefono'];
		$fecha_nac   = $data['fecha_nac'];

	}
}

mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
?>

