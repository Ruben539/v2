<?php 

require_once("../Models/conexion.php");
	if (!empty($_POST)) {
		$alert = '';
	
		if (empty( $_POST['Informa'])) {
	
			$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
	
		}else{
	
			$id           = $_POST['id'];
			$Informa      = $_POST['Informa'];
			$Placas       = $_POST['Placas'];
		
			
	
	
	//echo "SELECT * FROM usuario
	
			//WHERE(usuario = '$user' AND idusuario != $id) or (correo = '$email' AND idusuario != $id";
	//exit; sirve para ejectuar la consulta en mysql
			$query = mysqli_query($conection,"SELECT * FROM historial
				WHERE  id != id"
			);
	
			$resultado = mysqli_fetch_array($query);
	
	
		}
	
		if ($resultado > 0) {
			$alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
	
		}else{
	
			$sql_update = mysqli_query($conection,"UPDATE historial SET Informa = '$Informa',Placas = '$Placas'
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