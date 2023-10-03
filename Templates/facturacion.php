<?php
print_r($_POST);
exit();

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

//Datos para grabar en los comprobantes
$ruc           = $_POST['ruc'];
$razon_social  = $_POST['razon_social'];
$paciente_id   = $_POST['paciente_id'];
$doctor_id     = $_POST['doctor_id'];
$usuario_1     = $idusuario;
$comentario    = $_POST['comentario'];
$estado        = 'En Espera';

//Datos para grabar en el detalle de los comprobantes;
$medico     = $_POST['medico'];
$descuento  = $_POST['descuento'];
$fecha      = date('d-m-Y H:i:s');
$monto      = $_POST['monto'];


$estatus    = 1;



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
