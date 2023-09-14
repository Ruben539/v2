<?php

require_once("../Models/conexion.php");
$alert = '';


if (!empty($_POST)) {
    if (empty($_POST['nombre']) || empty($_POST['cedula'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';

        }else{

            
            $nombre       = $_POST['nombre'];
            $cedula       =$_POST['cedula'];
            $correo       = $_POST['correo'];
            $telefono     = $_POST['telefono'];
            $fecha_nac    = $_POST['fecha_nac'];
                       

        $query = mysqli_query($conection,"SELECT * FROM medicos WHERE telefono = '$telefono' or cedula = '$cedula'");

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">El telefono o el cedula o Usuario ya existen</p>';
        }else{

            $query_insert = mysqli_query($conection,"INSERT INTO medicos(nombre,cedula,correo,telefono,fecha_nac)
                VALUES('$nombre','$cedula','$correo','$telefono','$fecha_nac')");

            if ($query_insert ) {
              
                
                $alert = '<div >Medico grabado con exito !!!!</div>';
            }else{
              
             $alert = '<div>Error al Grabar</div>'; 
         }

       }
       mysqli_close($conection);
    }
}

