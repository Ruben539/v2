<?php


require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {


    if (empty($_POST['doctor_id']) || empty($_POST['especialidad_id'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $doctor_id        = $_POST['doctor_id'];
        $especialidad_id  = $_POST['especialidad_id'];



        $resultado = 0;

        $query = mysqli_query($conection, "SELECT * FROM especialidad_doctores WHERE doctor_id = '".$doctor_id."' AND especialidad_id = '".$especialidad_id."' ");

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">El doctor ya esta vinculado con esta especialidad</p>';
        } else {


            $query_insert = mysqli_query($conection, "INSERT INTO especialidad_doctores(doctor_id,especialidad_id)
				VALUES('$doctor_id','$especialidad_id')");


            if ($query_insert) {

                $alert = '<p class = "msg_save">Especialidad Asignada Correctamente</p>';
            } else {
                $alert = '<p class = "msg_error">Error al Asignar la Especialidad</p>';
            }
        }
      
    }
   // mysqli_close($conection);
}
