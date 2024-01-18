<?php


require_once "../Models/conexion.php";
	

	$id     = $_POST['id'];
    $monto  = $_POST['monto'];
	
    $estudio = "SELECT * FROM pago_estudio_medico WHERE estudio_id = '$id'";

    if( $estudio){
        $sql = "UPDATE pago_estudio_medicos set 
        monto = '$monto'
        WHERE estudio_id = '$id'";
    }else{
       $sql = "INSERT INTO pago_estudio_medicos(estudio_id,monto)
       VALUES('$id','$monto')";
    }
	
    echo $resultado = mysqli_query($conection,$sql);

 ?>