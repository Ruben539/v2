<?php


require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {


    if (empty($_POST['descripcion'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $descripcion   = $_POST['descripcion'];



        $resultado = 0;

        $query = mysqli_query($conection, "SELECT * FROM seguros WHERE descripcion LIKE '%" . $descripcion . "%' ");

        $resultado = mysqli_fetch_array($query);
        if ($resultado > 0) {
            $alert = '<p class = "msg_error">El seguro ya existe</p>';
        } else {



            $query_insert = mysqli_query($conection, "INSERT INTO seguros(descripcion)
				VALUES('$descripcion')");


            if ($query_insert) {

                $alert = '<p class = "msg_save">Registro Guardado Correctamente</p>';
            } else {
                $alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
            }
        }
        mysqli_close($conection);
    }
}
