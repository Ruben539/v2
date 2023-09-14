<?php

session_start();
require_once("../Models/conexion.php");
$iduser = $_SESSION['user'];

$query_usuario = mysqli_query($conection, "SELECT id_usuario,nombre,pass,usuario,foto FROM usuario where usuario = '$iduser' AND estatus = 1");
$resultado = mysqli_num_rows($query_usuario);
if ($resultado > 0) {
  while ($data = mysqli_fetch_array($query_usuario)) {
    $idusuario = $data['id_usuario'];
  }
}
date_default_timezone_set('America/Asuncion');


$ci         = $_POST['ci'];
$nombre     = $_POST['nombre'];
$seguro     = $_POST['seguro'];
$estudio    = $_POST['estudio'];
$medico     = $_POST['medico'];
$descuento  = $_POST['descuento'];
$fecha      = date('d-m-Y H:i:s');
$monto      = $_POST['monto'];
$comentario = $_POST['comentario'];
$nacimiento = $_POST['nacimiento'];
$estado     = 'En Espera';
$estatus    = 1;
$usuario_1  = $idusuario;


if (  $seguro == "Seguros"){

$comprobante = mysqli_query($conection, "INSERT INTO historial(Cedula,Estudio,Atendedor,Fecha,Seguro,MontoS,Descuento,Comentario,estado,estatus) 
    VALUES('$ci','$estudio','$medico','$fecha','$seguro','$monto','$descuento','$comentario','$estado','$estatus')");

}else{

  $comprobante = mysqli_query($conection, "INSERT INTO historial(Cedula,Estudio,Atendedor,Fecha,Seguro,Monto,Descuento,Comentario,estado,estatus) 
  VALUES('$ci','$estudio','$medico','$fecha','$seguro','$monto','$descuento','$comentario','$estado','$estatus')");
}

if ($comprobante) {
  header('location: Impresiones.php');
} else {
  echo "<script>javascript:alert('Ha ocurrido un error');</script>";
  exit();
}
