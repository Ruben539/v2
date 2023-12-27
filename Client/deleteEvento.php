<?php
require_once('../Models/conexion.php');
$id    		= $_REQUEST['id']; 

$sqlDeleteEvento = ("UPDATE agendamiento 
SET estatus = 0  WHERE  id='" .$id. "'");
$resultProd = mysqli_query($conection, $sqlDeleteEvento);

?>
  