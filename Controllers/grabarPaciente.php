<?php

require_once("../Models/conexion.php");
$alert = '';

if (!empty($_POST)) {
  if (empty($_POST['nombre']) || empty($_POST['cedula'])  || empty($_POST['sexo'])) {

    $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
  } else {
    $Cedula        = $_POST['cedula'];
    $nombre        = $_POST['nombre'];
    $correo        = $_POST['correo'];
    $telefono      = $_POST['telefono'];
    $sexo          = $_POST['sexo'];
    $fecha_nac     = $_POST['fecha_nac'];


    $resultado = 0;

    $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE cedula = '$cedula' ");



    $resultado = mysqli_fetch_array($query);

    if ($resultado > 0) {
      echo $alert = '<p class = "msg_success">El Usuario ya existe</p>';
    } else {

      $query_insert = mysqli_query($conection, "INSERT INTO usuarios(cedula,nombre,correo,telefono,sexo,fecha_nac)
      VALUES('$cedula','$nombre','$correo','$telefono','$sexo','$fecha_nac')");

      if ($query_insert) {
        header('Location: ../Templates/registro.php');
      } else {
        echo $alert = '<p class = "msg_error">Error al registrar el usuario</p>';
        exit();
      }
      mysqli_close($conection); //con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
    }
  }
}
