<?php

$alert = '';

session_start();

if (!empty($_SESSION['active'])) {

  header('Location: ../Templates/salir.php');
}else{

  if (!empty($_POST)) {


    if (empty($_POST['usuario']) || empty($_POST['password'])){
      $alert= '<div class= "alert alert-danger"><i class="fas fa-exclamation-triangle"></i><b> Rellene todos los Campos</b></div>';
    }else{

      require_once("Models/conexion.php");
      
      

      $user =  mysqli_real_escape_string($conection,$_POST['usuario']);
      $pass = md5(mysqli_real_escape_string($conection,$_POST['password']));

      if (preg_match('/^[a-zA-ZñÑ]+$/',$_POST['usuario']) &&
        preg_match('/^[0-9a-zA-Z]+$/',$_POST['password'])) {



        $query = mysqli_query($conection,"SELECT * FROM medicos WHERE usuario = '$user'
          AND pass = '$pass' AND estatus = 1");

      mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
      $resultado = mysqli_num_rows($query);


      if ($resultado > 0) {
        $data = mysqli_fetch_array($query);

        $_SESSION['active'] = true;
        $_SESSION['idMedico'] = $data['id'];
        $_SESSION['cedula'] = $data['cedula'];
        $_SESSION['nombre'] = $data['nombre'];
        $_SESSION['correo'] = $data['correo'];
        $_SESSION['user'] = $data['usuario'];

       
        


        if ($_SESSION['active']) {
         header('Location: Templates/dashboardDoctores.php');

       }
      
    }else{

      $alert= '<div class= "alert alert-danger"><i class="fas fa-exclamation-triangle"></i><b> El Usuario y/o la Contraseña son Incorrectas</b></div>';

      session_destroy();
    }
  }
}
}
}


?>


