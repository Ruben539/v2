<?php
  // print_r($_POST);
  // exit();

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
$estatus       = 3;

//Query para el grabado en la tabla de comprobantes.

$query_comprobante = mysqli_query($conection, "INSERT INTO comprobantes(ruc,razon_social,paciente_id,doctor_id,usuario_1,comentario,estado,estatus) 
    VALUES('$ruc','$razon_social','$paciente_id','$doctor_id','$usuario_1','$comentario','$estado','$estatus')");

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
  $descuento       = $_POST['descuento'];
  $seguro_id       = $_POST['seguro_id'];
  $estudios        = $_POST['estudios'];
  $cobertura       = $_POST['cobertura'];
  $nro_rayos       = $_POST['nro_rayos'];
  $comprobante_id  = $id;
  $categoria       = 0;
  

 
   $descripcion     = '';
   $monto           = '';

  for ($i = 0; $i < count($estudios); $i++) {

    if($seguro_id == 13){
      $raw_results2 = mysqli_query($conection, "SELECT id, nombre, preferencial,categoria_id FROM estudios WHERE id='" .$estudios[$i]. "'") or die(mysqli_error($conection));
      while ($results = mysqli_fetch_array($raw_results2)) {
        $id = $results['id'];
        $descripcion = $results['nombre'];
        $monto = $results['preferencial'];
        $categoria = $results['categoria_id'];
      }

    }else if($seguro_id != 13 && $seguro_id != 17){
      $raw_results2 = mysqli_query($conection, "SELECT id, nombre, seguro,categoria_id FROM estudios WHERE id='" .$estudios[$i]. "'") or die(mysqli_error($conection));
      while ($results = mysqli_fetch_array($raw_results2)) {
        $id = $results['id'];
        $descripcion = $results['nombre'];
        $monto = $results['seguro'];
        $categoria = $results['categoria_id'];
      }
    }else if($seguro_id == 17){
      $raw_results2 = mysqli_query($conection, "SELECT id, nombre, hospitalario,categoria_id FROM estudios WHERE id='" .$estudios[$i]. "'") or die(mysqli_error($conection));
      while ($results = mysqli_fetch_array($raw_results2)) {
        $id = $results['id'];
        $descripcion = $results['nombre'];
        $monto = $results['hospitalario'];
        $categoria = $results['categoria_id'];
      }
    }
  
    
    

    if($cobertura == 1){
      if($seguro_id == 13){
        $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto,cobertura,seguro_id,descuento,descripcion,nro_radiografias,condicion_venta) 
        VALUES('$comprobante_id','$id','$monto','$cobertura','$seguro_id','$descuento','$descripcion','$nro_rayos','contado')");

      }else if($seguro_id != 13 && $seguro_id != 17){
        $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto,cobertura,seguro_id,descuento,descripcion,nro_radiografias,condicion_venta) 
        VALUES('$comprobante_id','$id','$monto','$cobertura','$seguro_id','$descuento','$descripcion','$nro_rayos','contado')");

      }else if($seguro_id == 17){
        $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto,cobertura,seguro_id,descuento,descripcion,nro_radiografias,condicion_venta) 
        VALUES('$comprobante_id','$id','$monto','$cobertura','$seguro_id','$descuento','$descripcion','$nro_rayos','contado')");
      }

   
    }else if($cobertura == 2){
      if($seguro_id != 13 && $seguro_id != 17){

        $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto_seguro,cobertura,seguro_id,descuento,descripcion,nro_radiografias,condicion_venta) 
        VALUES('$comprobante_id','$id','$monto','$cobertura','$seguro_id','$descuento','$descripcion','$nro_rayos','credito')");
      }else{
        echo "<script>javascript:alert('No puede Cargar sin segura a una Cobertura Completa');</script>";
        exit();
      }
      
    }
   
  }
}

$id = $comprobante_id;

if ($quey_detalle) {
  header("Location: Impresiones.php?id=$id");
} else {
  echo "<script>javascript:alert('Ha ocurrido un error');</script>";
  exit();
}
