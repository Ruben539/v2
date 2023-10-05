<?php
session_start();
require_once "../Models/conexion.php";
	

	$id=$_POST['id'];

	$estatus = 0;
	$fecha_anulado = date('Y-m-d h:i:s');
    $usuario =  $_SESSION['idUser'];
	

	$sql = "UPDATE comprobantes set 
                fecha_anulado = '$fecha_anulado',
                usuario_2 = '$usuario',
                estatus = '$estatus'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);

 ?>