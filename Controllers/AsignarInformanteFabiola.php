<?php 


require_once("../Models/conexion.php");
$alert = '';
// print_r($_POST);
// exit();
	if (!empty($_POST)) {
	
	
		if (empty( $_POST['informante_id'])) {
	
			$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
	
		}else{
	
			$id              = $_POST['id'];
			$informante_id   = $_POST['informante_id'];
			$nro_placas      = $_POST['nro_placas'];
		
			
	
	
	//echo "SELECT * FROM usuario
	
			//WHERE(usuario = '$user' AND idusuario != $id) or (correo = '$email' AND idusuario != $id";
	//exit; sirve para ejectuar la consulta en mysql
			$query = mysqli_query($conection,"SELECT * FROM comprobantes
				WHERE  id != id"
			);
	
			$resultado = mysqli_fetch_array($query);
	
	
		}
	
		if ($resultado > 0) {
			$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
	
		}else{
	
			$sql_update = mysqli_query($conection,"UPDATE comprobantes SET informante_id = '$informante_id', nro_placas = '$nro_placas'
				WHERE id = $id");
	
			if ($sql_update) {
	
				$alert = '<p class = "msg_save">Asignado Correctamente</p>';
	
			}else{
				$alert = '<p class = "msg_error">Error al Actualizar el Registro</p>';
			}
		}
		mysqli_close($conection);
	}

?>