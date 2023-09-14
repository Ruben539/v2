<?php

require_once("../Models/conexion.php");
$alert = '';

if (!empty($_POST)) {
    $alert = '';

    if (empty($_POST['forma_pago']) ||  empty($_POST['tipo_salida']) || empty($_POST['monto']) || empty($_POST['concepto']) || empty($_POST['usuario'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $forma_pago    = $_POST['forma_pago'];
        $nro_cheque    = $_POST['nro_cheque'];
        $tipo_salida   = $_POST['tipo_salida'];
        $monto         =$_POST['monto'];
        $concepto      = trim($_POST['concepto']);
        $usuario       = $_POST['usuario'];
        $fecha         = $_POST['fecha'];
        $created_at    =  date('Y-m-d H:i:s');
        $estatus       = 1;
        


        $resultado = 0;

        $query = mysqli_query($conection, "SELECT * FROM empresa_movimientos WHERE forma_pago = '$forma_pago' ");

        $resultado = mysqli_fetch_array($query);



        $query_insert = mysqli_query($conection, "INSERT INTO empresa_movimientos(forma_pago,nro_cheque,tipo_salida,monto,concepto,usuario,fecha,created_at,estatus)
				VALUES('$forma_pago','$nro_cheque','$tipo_salida','$monto','$concepto','$usuario','$fecha','$created_at','$estatus');");

        if ($query_insert) {

            $alert = '<p class = "msg_save">Se grabo el Registro</p>';
        } else {
            $alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
        }
    }
    mysqli_close($conection);
}