<?php

require_once("../Models/conexion.php");
$alert = '';


if (!empty($_POST)) {
    if ( empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['telefono'])  || empty($_POST['fecha_nac'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

        }else{

            
            $cedula     = $_POST['cedula'];
            $nombre     = $_POST['nombre'];
            $correo     = $_POST['correo'];
            $telefono   = $_POST['telefono'];
            $fecha_nac  = $_POST['fecha_nac'];
           
           
            

        $query = mysqli_query($conection,"SELECT * FROM comisionista WHERE cedula = '$cedula' or telefono = '$telefono' or correo = '$correo'");
        

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">La cedula o el correo o telefono ya existen</p>';
        }else{

            $query_insert = mysqli_query($conection,"INSERT INTO comisionista(cedula,nombre,correo,telefono,fecha_nac)
                VALUES('$cedula','$nombre','$correo','$telefono','$fecha_nac')");

            if ($query_insert ) {
              
                
                $alert = '<div >Grabado con exito !!!!</div>';
            }else{
              
             $alert = '<div>Error al Grabar</div>'; 
         }

       }
    }
    mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
}

