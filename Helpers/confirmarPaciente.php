<?php
session_start();
require_once "../Models/conexion.php";
	

	$id= $_POST['id'];
	$estado = 'Atendido';

    
	
	

	$sql = "UPDATE comprobantes set 
                    estado = '$estado'
                    WHERE id = '$id'";
    echo $resultado = mysqli_query($conection,$sql);