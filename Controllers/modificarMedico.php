<?php

require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {
	if (empty($_POST['nombre']) || empty($_POST['cedula'])) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
	} else {

		$id              = $_POST['id'];
		$cedula          = $_POST['cedula'];
		$nombre          = $_POST['nombre'];
		$correo          = $_POST['correo'];
		$usuario         = $_POST['usuario'];
		$telefono        = $_POST['telefono'];
		$fecha_nac       = $_POST['fecha_nac'];
		$monto_cobro     = $_POST['monto_cobro'];


		//echo "SELECT * FROM usuario

		//WHERE(usuario = '$user' AND id != $iduser) or (correo = '$email' AND id != $iduser";
		//exit; sirve para ejectuar la consulta en mysql
		$query = mysqli_query(
			$conection,
			"SELECT * FROM medicos
				WHERE  id != id"
		);

		$resultado = mysqli_fetch_array($query);
	}

	if ($resultado > 0) {
		$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
	} else {

		$sql_update = mysqli_query($conection, "UPDATE medicos SET cedula = '$cedula',nombre = '$nombre',usuario = '$usuario', correo = '$correo'
		,telefono = '$telefono',fecha_nac = '$fecha_nac',monto_cobro = '$monto_cobro'
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
	header('location: ../Templates/medicos.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT m.id,m.nombre,m.cedula,m.usuario,m.correo,m.telefono,m.fecha_nac,monto_cobro
FROM medicos m  where m.id = $id AND m.estatus = 1");

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Templates/medicos.php");
} else {
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {

		$id           = $data['id'];
		$cedula       = $data['cedula'];
		$nombre       = $data['nombre'];
		$correo       = $data['correo'];
		$usuario      = $data['usuario'];
		$telefono     = $data['telefono'];
		$fecha_nac    = $data['fecha_nac'];
		$monto_cobro  = $data['monto_cobro'];
	}
}
