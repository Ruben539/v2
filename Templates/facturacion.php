<?php
//print_r($_POST);
//exit();

session_start();
require_once("../Models/conexion.php");
$iduser = $_SESSION['user'];

$query_usuario = mysqli_query($conection, "SELECT id,nombre,pass,usuario FROM usuarios where usuario = '$iduser' AND estatus = 1");
$resultado = mysqli_num_rows($query_usuario);
if ($resultado > 0) {
  while ($data = mysqli_fetch_array($query_usuario)) {
    $idusuario = $data['id'];
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

//Query para el grabado en la tabla de comprobantes.

$query_comprobante = mysqli_query($conection, "INSERT INTO comprobantes(ruc,razon_social,paciente_id,doctor_id,usuario_1,comentario,estado) 
    VALUES('$ruc','$razon_social','$paciente_id','$doctor_id','$usuario_1','$comentario','$estado')");

if ($query_comprobante) {

  $hoy =  date('Y-m-d');

  $sql = mysqli_query($conection, "SELECT c.id FROM comprobantes c WHERE  c.created_at like '%$hoy%'  ORDER BY id DESC LIMIT 1 ");


  $resultado = mysqli_num_rows($sql);

  if ($resultado == 0) {

    header("location: ../Templates/dashboard.php");
  } else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

      $id   = $data['id'];
    }
  }
  //Datos para grabar en el detalle de los comprobantes;
  $seguro_id       = $_POST['seguro_id'];
  $estudios        = $_POST['estudios'];
  $descripcion     = '';
  $monto           = '';
  $forma_pago_id   = $_POST['forma_pago_id'];
  $descuento       = $_POST['descuento'];
  $comprobante_id  = $id;

  $estudio = '';

  for ($i = 0; $i < count($estudios); $i++) {
    $estudio =  $estudios[$i];

    $raw_results2 = mysqli_query($conection, "select id, nombre, seguro from estudios where id='" . trim($estudios[$i]) . "';") or die(mysqli_error($conection));
    while ($results = mysqli_fetch_array($raw_results2)) {
     $id = $results['id'];
      $descripcion = $results['nombre'];
      $monto += (int)$results['seguro'];
     // exit();
      //Query para el grabado en la tabla del detalle de  comprobantes.
      $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,descripcion,monto,seguro_id,forma_pago_id,descuento) 
  VALUES('$comprobante_id','$id','$descripcion','$monto','$seguro_id','$forma_pago_id','$descuento')");
    }
  }
}



if ($quey_detalle) {
  header('location: Impresiones.php');
} else {
  echo "<script>javascript:alert('Ha ocurrido un error');</script>";
  exit();
}
