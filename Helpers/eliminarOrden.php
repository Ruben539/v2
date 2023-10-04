<?php

require_once "../Models/conexion.php";
	

	$id=$_POST['id'];

	$estatus = 0;
	
	

	$sql = "UPDATE comprobantes set 
                estatus = '$estatus'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);

 ?>