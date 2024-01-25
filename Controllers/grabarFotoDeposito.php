<?php

require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {
	

	if (empty($_FILES['foto'])  ) {

		$alert = '<p class = "msg_error">Debe llenar sellecionar  la foto</p>';

	}else{

        $id            = $_POST['id'];
        $usuario       = $_POST['usuario'];

		$foto          = $_FILES['foto'];
        $nombre_foto   = $foto['name'];
        $type          = $foto['type'];
        $url_tmp       = $foto['tmp_name'];

        $imgComprobante =  'img_comprobante.png';

        if($nombre_foto != ''){

            $destino         =  '../Images/IngresoDiario/';
            $imgNombre       = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgComprobante  = $imgNombre.'.jpg';
            $src             = $destino.$imgComprobante;

        }


			$query_insert = mysqli_query($conection,"UPDATE deposito_diarios SET foto = '$imgComprobante', usuario = '$usuario'
            WHERE id = '$id'");


			if ($query_insert) {
				if($nombre_foto != ''){
					move_uploaded_file($url_tmp, $src);
				}
        
                $alert = '<p class = "msg_save">Registro Guardado Correctamente</p>';


			}else{
				$alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
			}

	}
	
}

if (empty($_REQUEST['id'])) {
	header('location: ../Templates/depositos.php');

	//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT * FROM deposito_diarios  WHERE id = $id");   

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
	header("location: ../Templates/depositos.php");
}else{
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		
		$id           = $data['id'];
	
	}
}
