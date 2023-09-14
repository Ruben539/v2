<?php

require_once "../Models/conexion.php";
	

	$id=$_POST['id'];

	$estatus = 0;
    $monto = 0;
    $descuento = 0;
    $montoS = 0;
	
	

	$sql = "UPDATE historial set 
                    estatus = '$estatus',
                    monto     = '$monto',
                    descuento = '$descuento',
                    montos = '$montoS'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);

 ?>