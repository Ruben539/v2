<?php

require_once("../Models/conexion.php");
$alert = '';


if (!empty($_POST)) {
    if (empty($_POST['nombre']) || empty($_POST['usuario']) || empty($_POST['pass']) || empty($_POST['rol'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

        }else{

            
            $cedula   = $_POST['cedula'];
            $nombre   = $_POST['nombre'];
            $correo   = $_POST['correo'];
            $usuario  = $_POST['usuario'];
            $pass     = md5($_POST['pass']);
            $rol      = $_POST['rol'];
           
           
            

        $query = mysqli_query($conection,"SELECT * FROM usuarios WHERE cedula = '$cedula' or usuario = '$usuario' or correo = '$correo'");
        

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">La cedula o el correo o Usuario ya existen</p>';
        }else{

            $query_insert = mysqli_query($conection,"INSERT INTO usuarios(cedula,nombre,correo,usuario,pass,rol)
                VALUES('$cedula','$nombre','$correo','$usuario','$pass','$rol')");

            if ($query_insert ) {
              
                
                $alert = '<div >Grabado con exito !!!!</div>';
            }else{
              
             $alert = '<div>Error al Grabar</div>'; 
         }

       }
    }
    mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
}

