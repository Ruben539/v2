<?php

require_once("../Models/conexion.php");
 

  
    $Cedula        = $_POST['Cedula'];
    $Nombre        = $_POST['Nombre'];
    $Apellido      = $_POST['Apellido'];
    $Sexo          = $_POST['Sexo'];
    $Celular       = $_POST['Celular'];
    $Nacimiento    = $_POST['Nacimiento'];


    $resultado = 0;

    $query = mysqli_query($conection, "SELECT * FROM clientes WHERE  cedula = '$Cedula'");
    
    
    
    $resultado = mysqli_fetch_array($query);

    if ($resultado > 0) {
      echo $alert = '<p class = "msg_success">El Usuario ya existe</p>';
    } else {

      $query_insert = mysqli_query($conection, "INSERT INTO clientes(Cedula,Apellido,Nombre,Nacimiento,Sexo,Celular)
				VALUES('$Cedula','$Apellido','$Nombre','$Nacimiento','$Sexo','$Celular')");

      if ($query_insert) {
        header('Location: ../Templates/registro.php');
      } else {
        echo $alert = '<p class = "msg_error">Error al registrar el usuario</p>';
       exit();
      }
      mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
    }
  
