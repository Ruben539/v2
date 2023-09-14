<?php

require_once("../Models/conexion.php");
$alert = '';

if (!empty($_POST)) {
    $alert = '';

    if (empty($_POST['id']) || empty($_POST['comentario']) || empty($_POST['estatus'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
        
    } else {

        $id           = $_POST['id'];
        $comentario   = $_POST['comentario'];
        $estatus      = $_POST['estatus'];
        $usuario_1    = $_POST['usuario_1'];
       



        $query = mysqli_query($conection,"SELECT * FROM gastos
			WHERE  id != id"
        );

        $resultado = mysqli_fetch_array($query);
    }

    if ($resultado > 0) {
        $alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
    } else {
      
        
        $sql_update = mysqli_query($conection, "UPDATE gastos SET comentario = '$comentario', estatus = '$estatus',
         usuario_1 = '$usuario_1'
			WHERE id = $id");

        if ($sql_update) {

            $alert = '<p class = "msg_success">Solicitado Correctamente</p>';

        } else {
            $alert = '<p class = "msg_error">Error al Solicitar la Cancelación</p>';

        }
    }
}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
    header('location: ../Templates/gastos.php');

    //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM gastos  WHERE id = $id");

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
    header("location: ../Plantilla/gastos.php");
} else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $id           = $data['id'];
        $nombre       = $data['descripcion'];
        $comentario   = $data['comentario'];
    }
}