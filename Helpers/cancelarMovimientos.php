<?php

require_once("../Models/conexion.php");
$alert = '';

if (!empty($_POST)) {


    if ( empty($_POST['observacion'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $id           = $_POST['id'];
        $observacion  = $_POST['observacion'];
        $estatus      = $_POST['estatus'];
        $aprobado     = $_POST['aprobado'];




        $query = mysqli_query(
            $conection,
            "SELECT * FROM empresa_movimientos
			WHERE  id != id"
        );

        $resultado = mysqli_fetch_array($query);


        if ($resultado > 0) {
            $alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
        } else {


            $sql_update = mysqli_query($conection, "UPDATE empresa_movimientos SET observacion = '$observacion', estatus = '$estatus',
         aprobado = '$aprobado'
			WHERE id = $id");

            if ($sql_update) {

                $alert = '<p class = "msg_success">Cancelado Correctamente</p>';
            } else {
                $alert = '<p class = "msg_error">Error al Solicitar la Cancelación</p>';
            }
        }
    }
}

    //Recuperacion de datos para mostrar al seleccionar Actualizar

    if (empty($_REQUEST['id'])) {
        header('location: ../Templates/movimientosFinancieros.php');

        //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

    }

    $id = $_REQUEST['id'];

    $sql = mysqli_query($conection, "SELECT * FROM empresa_movimientos  WHERE id = $id");

    //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


    $resultado = mysqli_num_rows($sql);

    if ($resultado == 0) {
        header("location: ../Plantilla/movimientosFinancieros.php");
    } else {
       
        while ($data = mysqli_fetch_array($sql)) {

            $id           = $data['id'];
            $tipo_salida  = $data['tipo_salida'];
            $concepto     = $data['concepto'];
        }
    }

