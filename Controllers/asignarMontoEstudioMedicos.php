<?php


require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {


    if (empty($_POST['doctor_id']) || empty($_POST['estudio_id']) || empty($_POST['monto'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $doctor_id    = $_POST['doctor_id'];
        $estudio_id   = $_POST['estudio_id'];
        $monto        = $_POST['monto'];



        $resultado = 0;

        $query = mysqli_query($conection, "SELECT * FROM pago_estudio_medicos  WHERE doctor_id = '".$doctor_id."' AND estudio_id = '".$estudio_id."' ");

        $resultado = mysqli_fetch_array($query);

        if ($resultado > 0) {
            $alert = '<p class = "msg_error">El doctor ya esta vinculado con este estudio</p>';
        } else {


            $query_insert = mysqli_query($conection, "INSERT INTO pago_estudio_medicos(doctor_id,estudio_id,monto)
				VALUES('$doctor_id','$estudio_id','$monto')");


            if ($query_insert) {

                $alert = '<p class = "msg_save">Monto asignado correctamente</p>';
            } else {
                $alert = '<p class = "msg_error">Error al asignar el monto</p>';
            }
        }
      
    }
   // mysqli_close($conection);
}
