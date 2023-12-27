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
		$telefono        = $_POST['telefono'];
		$fecha_nac       = $_POST['fecha_nac'];


		
        $query = mysqli_query($conection,"SELECT * FROM comisionista WHERE cedula = '$cedula' or telefono = '$telefono' or correo = '$correo'");
        

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">La cedula o el correo o telefono ya existen</p>';
        }else{

            $query_insert = mysqli_query($conection,"INSERT INTO comisionista(id_referente,cedula,nombre,correo,telefono,fecha_nac)
                VALUES('$id','$cedula','$nombre','$correo','$telefono','$fecha_nac')");

			if ($query_insert) {

				$alert = '<p class = "msg_success">Medico registrado como comisionista correctamente</p>';
			} else {
				$alert = '<p class = "msg_error">Error al registrar el Registro</p>';
			}
		}
	}
}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
	header('location: ../Templates/medicos.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT m.id,m.nombre,m.cedula,m.correo,m.telefono,m.fecha_nac
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
		$telefono     = $data['telefono'];
		$fecha_nac    = $data['fecha_nac'];
	}
}
