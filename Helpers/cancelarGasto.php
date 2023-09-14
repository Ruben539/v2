<?php
session_start();
require_once "../Models/conexion.php";
	
    $usuario = $_SESSION['nombre'];
	$id= $_POST['id'];
	$estatus = 0;
    $fecha = date('d-m-Y H:i:s');
    
	
	

	$sql = "UPDATE gastos set 
                estatus = '$estatus',
                usuario_2 = '$usuario',
                fecha_2 = '$fecha'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);