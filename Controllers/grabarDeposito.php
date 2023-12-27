<?php

require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {
	

	if (empty($_POST['monto']) || empty($_POST['monto_real']) ) {

		$alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

	}else{

		$fecha       = $_POST['fecha_deposito'];
		$monto       = $_POST['monto'];
		$monto_real  = $_POST['monto_real'];
		$usuario     = $_SESSION['nombre'];

		$foto          = $_FILES['foto'];
        $nombre_foto   = $foto['name'];
        $type          = $foto['type'];
        $url_tmp       = $foto['tmp_name'];

        $imgComprobante =  'img_comprobante.png';

        if($nombre_foto != ''){

            $destino         =  '../Images/Depositos/';
            $imgNombre       = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgComprobante  = $imgNombre.'.jpg';
            $src             = $destino.$imgComprobante;

        }
  		
		

		$resultado = 0;

		$query = mysqli_query($conection,"SELECT * FROM depositos WHERE monto = '$monto' ");

		$resultado = mysqli_fetch_array($query);



			$query_insert = mysqli_query($conection,"INSERT INTO depositos(fecha,monto,monto_real,usuario,foto)
				VALUES('$fecha','$monto','$monto_real','$usuario','$imgComprobante')");


			if ($query_insert) {
				if($nombre_foto != ''){
					move_uploaded_file($url_tmp, $src);
				}
        
                $alert = '<p class = "msg_save">Registro Guardado Correctamente</p>';


			}else{
				$alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
			}

	}
	mysqli_close($conection);
}
