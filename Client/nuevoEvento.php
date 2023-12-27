<?php
//print_r($_POST);
//exit();
date_default_timezone_set("America/Paraguay");
setlocale(LC_ALL,"es_ES");
//$hora = date("g:i:A");

require_once('../Models/conexion.php');

$doctor_id         = $_REQUEST['doctor_id'];
$agenda            = ucwords($_REQUEST['agenda']);
$nombre            = $_REQUEST['nombre'];
$f_inicio          = $_REQUEST['fecha_inicio'];
$fecha_inicio      = date('Y-m-d', strtotime($f_inicio)); 

$f_fin             = $_REQUEST['fecha_fin']; 
$seteando_f_final  = date('Y-m-d', strtotime($f_fin));  
$fecha_fin1        = strtotime($seteando_f_final."+ 1 days");
$fecha_fin         = date('Y-m-d', ($fecha_fin1));  
$color_evento      = $_REQUEST['color_evento'];


$query_insert = "INSERT INTO  agendamiento(
      doctor_id,
      agenda,
      nombre,
      fecha_inicio,
      fecha_fin,
      color_evento
      )
    VALUES (
      '" .$doctor_id. "',
      '" .$agenda. "',
      '" .$nombre. "',
      '". $fecha_inicio."',
      '" .$fecha_fin. "',
      '" .$color_evento. "'
  )";
$resultadoNuevoEvento = mysqli_query($conection, $query_insert);

header("Location:calendario.php?e=1");


$id = $_REQUEST('id');

$query = mysqli_query($conection, 'SELECT * FROM agendamiento where estatus = 1');
$resultado = mysqli_num_rows($query);

?>