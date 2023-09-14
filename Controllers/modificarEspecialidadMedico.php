<?php 



require_once("../Models/conexion.php");
$alert = '';


	if (!empty($_POST)) {
		
	
		if (empty( $_POST['especialidad_id']) ) {
	
			$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
	
		}else{
	
			$id                  = $_POST['id'];
			$especialidad_id     = $_POST['especialidad_id'];
								
	
	
	//echo "SELECT * FROM usuario
	
			//WHERE(usuario = '$user' AND idusuario != $iduser) or (correo = '$email' AND idusuario != $iduser";
	//exit; sirve para ejectuar la consulta en mysql
			$query = mysqli_query($conection,"SELECT * FROM especialidad_doctores
				WHERE  id != id"
			);
	
			$resultado = mysqli_fetch_array($query);
	
	
		}
	
		if ($resultado > 0) {
			$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
	
		}else{
	
			$sql_update = mysqli_query($conection,"UPDATE especialidad_doctores SET especialidad_id = '$especialidad_id'
				WHERE id = $id");
	
			if ($sql_update) {
	
				$alert = '<p class = "msg_success">Actualizado Correctamente</p>';
	
			}else{
				$alert = '<p class = "msg_error">Error al Actualizar el Registro</p>';
			}
		}
	}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
	header('location: ../Templates/especialidades.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT ed.id, m.nombre, e.descripcion FROM especialidad_doctores ed 
INNER JOIN especialidades e ON e.id = ed.especialidad_id
INNER JOIN medicos m ON m.id = ed.doctor_id 
where ed.id = $id AND ed.estatus = 1 ");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Templates/especialidades.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		$id           = $data['id'];
		$nombre       = $data['nombre'];	
		$descripcion  = $data['descripcion'];	

	}
}