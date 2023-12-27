<?php 
require_once('../Models/conexion.php');


if (!empty($_POST)) {
    $alert = '';

    if (empty($_POST['forma_pago_id'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $id                = $_POST['id'];
        $idDetalle         = $_POST['idDetalle'];
        $forma_pago_id     = $_POST['forma_pago_id'];
        $estatus           = 1; 



        //echo "SELECT * FROM usuario

        //WHERE(usuario = '$user' AND idusuario != $iduser) or (correo = '$email' AND idusuario != $iduser";
        //exit; sirve para ejectuar la consulta en mysql
        $query = mysqli_query(
            $conection,
            "SELECT * FROM comprobantes
            WHERE  id != id"
        );

        $resultado = mysqli_fetch_array($query);
    }

    if ($resultado > 0) {
        $alert = '<p class = "msg_error">El Registro ya existe,ingrese otro</p>';
    } else {

        $sql_update = mysqli_query($conection, "UPDATE detalle_comprobantes SET forma_pago_id = '$forma_pago_id' WHERE id = $idDetalle");

        if ($sql_update) {

            $sql_updateComprobante = mysqli_query($conection, "UPDATE comprobantes SET estatus = '$estatus' WHERE id = $id");

            if($sql_updateComprobante){
               
                header("Location: Impresiones.php?id=$id");

            }else{
                $alert = '<p class = "msg_error">Error al registrar </p>';
            }

        } else {
            $alert = '<p class = "msg_error">Error al registrar </p>';
        }
    }
}

//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
    header('location: ../Templates/especialidades.php');

    //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT  c.id,c.ruc,dc.id as idDetalle, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor,dc.cobertura, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE  c.estatus = 3 GROUP BY c.id  ORDER BY  c.id ASC");

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
    header("location: ../Templates/pendientesACobrar.php");
} else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $id            = $data['id'];
        $idDetalle     = $data['idDetalle'];
        $ruc           = $data['ruc'];
        $razon_social  = $data['razon_social'];
        $doctor        = $data['doctor'];
        $estudio       = $data['estudio'];
        $seguro        = $data['seguro'];
        $cobertura     = $data['cobertura'];
    }
}



?>