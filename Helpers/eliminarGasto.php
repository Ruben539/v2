<?php

require_once "../Models/conexion.php";
	

	$id=$_POST['id'];

	$estatus = 2;
	
	

	$sql = "UPDATE gastos set 
                estatus = '$estatus'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);

 ?>