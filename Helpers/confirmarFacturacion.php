<?php

require_once "../Models/conexion.php";


$id               = $_POST['id'];
$forma_pago_id    = $_POST['forma_pago_id'];
$id_referente     = $_POST['id_referente'];
$forma_pago_id_2  = $_POST['forma_pago_id_2'];
$monto_2          = $_POST['monto_2'];
$estatus          = 1;


date_default_timezone_set('America/Asuncion');

$sql = mysqli_query($conection, "SELECT dc.comprobante_id,dc.estudio_id,dc.monto,dc.monto_seguro,dc.descuento,dc.cobertura,dc.seguro_id,dc.descripcion,dc.nro_radiografias,dc.condicion_venta
         FROM detalle_comprobantes dc WHERE dc.comprobante_id = '" . $id . "' ");

$resultado = mysqli_num_rows($sql);


while ($data = mysqli_fetch_array($sql)) {

    $comprobante_id   = $data['comprobante_id'];
    $estudio_id       = $data['estudio_id'];
    $monto            = $data['monto'];
    $monto_seguro     = $data['monto_seguro'];
    $descuento        = $data['descuento'];
    $cobertura        = $data['cobertura'];
    $seguro_id        = $data['seguro_id'];
    $descripcion      = $data['descripcion'];
    $nro_radiografias = $data['nro_radiografias'];
    $condicion_venta  = $data['condicion_venta'];
}




if (empty($forma_pago_id_2)) {

    //TODO: Si el pago no es combinado se ejecuta la siguiente linea de codigo.
    $sql_facturacion = mysqli_query($conection, "UPDATE detalle_comprobantes 
        SET forma_pago_id = '$forma_pago_id', id_referente = '$id_referente'  WHERE comprobante_id = $id");

    if ($sql_facturacion) {

        $sql_updateComprobante = mysqli_query($conection, "UPDATE comprobantes SET estatus = '$estatus' WHERE id = $id");

        //TODO: Si el pago fue grabado correctamente y el estado del comprobante se actualizo, se inicia el grabado en la tabla de consultas.
        if ($sql_updateComprobante) {

            //TODO: Obntener los datos del comprobante para poder usarlos para grabarlos en la tabla de consultas.
            $datosComprobantes = mysqli_query($conection, "SELECT * FROM comprobantes WHERE id = $id");

            while ($comprobante =  mysqli_fetch_array($datosComprobantes)) {
                $ruc          =  $comprobante['ruc'];
                $razon_social =  $comprobante['razon_social'];
                $doctor_id    =  $comprobante['doctor_id'];
            }

            //TODO: Datos necesarios para calcular los montos a grabar, ya incluido de manera automatica el -10000 de la bio y las posiciones de las radiografias.
            $precio = 0;
            $costo  = 0;


            if ($descripcion == 'Radiografias') {
                $precio = $monto * $nro_radiografias;
            } else {
                $precio = $monto;
            }

            $montoConsulta = 0;
            $montoCobrado  = 0;

            if ($monto == 0) {
                $montoConsulta = 0;
                $costo  = ($monto_seguro * $nro_radiografias) - $descuento;
                $montoCobrado = $costo;
            } else {
                $montoConsulta = $precio - 10000;
                $costo = 0;
                $montoCobrado  = $montoConsulta - $descuento;
            }


            $insert_consulta = mysqli_query($conection, "INSERT INTO consulta_medicos(comprobante_id,ruc,razon_social,estudio_id,doctor_id,monto,monto_seguro,descuento,monto_cobrado,forma_pago_id,seguro_id)
            VALUES('$id','$ruc','$razon_social','$estudio_id','$doctor_id','$montoConsulta','$costo','$descuento','$montoCobrado','$forma_pago_id','$seguro_id')");

            if ($insert_consulta) {

                $monto_doctor = mysqli_query($conection, "SELECT * FROM pago_estudio_medicos WHERE estudio_id = '$estudio_id'");

                $resultado = mysqli_num_rows($monto_doctor);

                if ($resultado > 0) {
                    while ($data = mysqli_fetch_array($monto_doctor)) {
                        $monto_estudio = $data['monto'];
                    }

                    $precio = 0;
                    $total  = 0;

                    if ($descripcion == 'Radiografias') {
                        $precio = $monto * $nro_radiografias;
                    } else {
                        $precio = $monto;
                    }

                    $montoDiax   = 0;
                    $montoDoctor = 0;

                    if ($monto == 0) {
                        $total       =  ($monto_seguro * $nro_radiografias) - $descuento;
                        $montoDoctor =  $monto_estudio;
                        $montoDiax   =  $total - $montoDoctor;
                    } else {
                        $total = $precio - 10000 - $descuento;
                        $montoDoctor = $monto_estudio;
                        $montoDiax  = $total  - $monto_estudio;
                    }


                    $insert_servicio = mysqli_query($conection, "INSERT INTO servicio_medicos(comprobante_id,doctor_id,estudio_id,monto,monto_diax,monto_doctor)
                    VALUES('$id','$doctor_id','$estudio_id','$total','$montoDiax','$montoDoctor')");
                }
            }

            //TODO:Inicio del query para el grabado del deposito diario.

            if ($doctor_id != 1  && $doctor_id != 2 && $doctor_id != 3 && $doctor_id != 4 && $doctor_id != 5 && $doctor_id != 6 && $doctor_id != 14) {

                if ($forma_pago_id == 1) {
                    $hoy =  date('Y-m-d');

                    $sqlDeposito = mysqli_query($conection, "SELECT id,monto FROM deposito_diarios WHERE fecha_deposito LIKE '" . $hoy . "'");

                    $resultado = mysqli_num_rows($sqlDeposito);

                    $total  = 0;
                    $precio = 0;

                    if ($resultado > 0) {
                        while ($data =  mysqli_fetch_array($sqlDeposito)) {
                            $idIngreso   =   $data["id"];
                            $montoIngreso =  $data["monto"];
                        }

                        if ($descripcion == 'Radiografias') {

                            $precio = $monto * $nro_radiografias;

                        } else {

                            $precio = $monto;

                        }

                        $total = ($precio - $descuento) + $montoIngreso;

                        $updateIngreso = mysqli_query($conection, "UPDATE deposito_diarios SET monto ='$total' WHERE id ='$idIngreso'");

                    } else {
                       
                        $hoy    = date("Y-m-d");
                        $precio = 0;

                        if ($descripcion == 'Radiografias') {

                            $precio = $monto * $nro_radiografias;

                        } else {

                            $precio = $monto;
                            
                        }

                        $insertIngreso = mysqli_query($conection,"INSERT INTO deposito_diarios(monto,fecha_deposito)
                        VALUES('$precio','$hoy')");

                    }
                }

                //TODO:Inicio del query si el doctor es de Paz.
            } else if ($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14) {
             
                if($forma_pago_id == 1){
                    $hoy = date('Y-m-d');

                    $sqlDeposito = mysqli_query($conection, "SELECT id,monto FROM deposito_diarios WHERE fecha_deposito LIKE '" . $hoy . "'");

                    $resultado = mysqli_num_rows($sqlDeposito);

                    $total = 0;
                    if($resultado > 0){
                        while($data = mysqli_fetch_array($sqlDeposito)){
                            $idIngreso   =   $data["id"];
                            $montoIngreso =  $data["monto"];
                        }

                        $total = $montoIngreso + 10000;
                        $updateIngreso = mysqli_query($conection,"UPDATE deposito_diarios SET monto =  '$total' WHERE id = '$idIngreso'");

                    }else{
                        $hoy = date('Y-m-d');
                        $bio = 10000;

                        $insertIngreso = mysqli_query($conection,"INSERT INTO deposito_diarios(monto,fecha_deposito)
                        VALUES('$bio','$hoy')");

                    }

                }else if ($forma_pago_id == 2) {

                    $hoy = date('Y-m-d');
                    
                    $sqlDeposito = mysqli_query($conection, "SELECT id,monto FROM deposito_diarios WHERE fecha_deposito LIKE '" . $hoy . "'");

                    $resultado = mysqli_num_rows($sqlDeposito);

                    if($resultado > 0){
                        while($data = mysqli_fetch_array($sqlDeposito)){
                            $idIngreso   =   $data["id"];
                            $montoIngreso =  $data["monto"];
                        }
                    }
                   
                    $precio     = 0;
                    $total      = 0;
                    $diferencia = 0;

                    if ($descripcion == 'Radiografias') {

                        $precio = $monto * $nro_radiografias;

                    } else {

                        $precio = $monto;
                        
                    }

                    $total = ($precio - 10000) - $descuento;
                    $diferencia = $montoIngreso - $total;

                    $updateIngreso = mysqli_query($conection,"UPDATE deposito_diarios SET monto =  '$diferencia' WHERE id = '$idIngreso'");
                }
            }
        }
    }
} else {

    $pago  = 0;
    $pago_diferido = 1;
    $pago = $monto - $monto_2;

    $datosComprobantes = mysqli_query($conection, "SELECT * FROM comprobantes WHERE id = $id");

    while ($comprobante =  mysqli_fetch_array($datosComprobantes)) {
        $ruc          =  $comprobante['ruc'];
        $razon_social =  $comprobante['razon_social'];
        $doctor_id    =  $comprobante['doctor_id'];
    }


    //TODO: Si se habilito el pago combinado.

    $sql_facturacion = mysqli_query($conection, "UPDATE detalle_comprobantes
       SET forma_pago_id = '$forma_pago_id', id_referente = '$id_referente', monto = '$pago'  WHERE comprobante_id = $id");

    if ($sql_facturacion) {
        $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto,cobertura,seguro_id,descripcion,nro_radiografias,condicion_venta,forma_pago_id,pago_diferido)
           VALUES('$comprobante_id','$estudio_id','$monto_2','$cobertura','$seguro_id','$descripcion','$nro_radiografias','$condicion_venta','$forma_pago_id_2','$pago_diferido')");

        if ($quey_detalle) {
            $sql_updateComprobante = mysqli_query($conection, "UPDATE comprobantes SET estatus = '$estatus' WHERE id = $id");

            //TODO: Si el pago diferido es en tarjeta se realizara la resta del monto del ingreso en efectivo en diax.

            if ($doctor_id == 1  || $doctor_id == 2 || $doctor_id == 3 || $doctor_id == 4 || $doctor_id == 5 || $doctor_id == 6 || $doctor_id == 14) {
                if ($forma_pago_id_2 == 2) {
                    $fecha =  date('Y-m-d');
                    $selectDeposito = mysqli_query($conection, "SELECT * FROM deposito_diarios WHERE fecha_deposito LIKE '%$fecha%'");

                    $resultado =  mysqli_num_rows($selectDeposito);

                    if ($resultado > 0) {
                        while ($data = mysqli_fetch_array($selectDeposito)) {
                            $idIngreso      = $data['id'];
                            $montoIngreso   = $data['monto'];
                        }

                        $total =  $montoIngreso - $monto_2;

                        $upadteDeposito =  mysqli_query($conection, "UPDATE deposito_diarios SET monto = '$total' WHERE id = $idIngreso");
                    }
                }
            }
        }

        if ($sql_updateComprobante) {

            //TODO: Obntener los datos del comprobante para poder usarlos para grabarlos en la tabla de consultas.
            $datosComprobantes = mysqli_query($conection, "SELECT * FROM comprobantes WHERE id = $id");

            while ($comprobante =  mysqli_fetch_array($datosComprobantes)) {
                $ruc          =  $comprobante['ruc'];
                $razon_social =  $comprobante['razon_social'];
                $doctor_id    =  $comprobante['doctor_id'];
            }

            //TODO: Datos necesarios para calcular los montos a grabar, ya incluido de manera automatica el -10000 de la bio y las pciosiones de las radiografias.
            $precio = 0;
            $costo  = 0;


            if ($descripcion == 'Radiografias') {
                $precio = $monto * $nro_radiografias;
            } else {
                $precio = $monto;
            }

            $montoConsulta = 0;
            $montoCobrado  = 0;

            if ($monto == 0) {
                $montoConsulta = 0;
                $costo  = ($monto_seguro * $nro_radiografias) - $descuento;
                $montoCobrado = $costo;
            } else {
                $montoConsulta = $precio - 10000;
                $costo = 0;
                $montoCobrado  = $montoConsulta - $descuento;
            }


            $insert_consulta = mysqli_query($conection, "INSERT INTO consulta_medicos(comprobante_id,ruc,razon_social,estudio_id,doctor_id,monto,monto_seguro,descuento,monto_cobrado,forma_pago_id,seguro_id)
        VALUES('$id','$ruc','$razon_social','$estudio_id','$doctor_id','$montoConsulta','$costo','$descuento','$montoCobrado','$forma_pago_id','$seguro_id')");

            if ($insert_consulta) {

                $monto_doctor = mysqli_query($conection, "SELECT * FROM pago_estudio_medicos WHERE estudio_id = '$estudio_id'");

                $resultado = mysqli_num_rows($monto_doctor);

                if ($resultado > 0) {
                    while ($data = mysqli_fetch_array($monto_doctor)) {
                        $monto_estudio = $data['monto'];
                    }

                    $precio = 0;
                    $total  = 0;

                    if ($descripcion == 'Radiografias') {
                        $precio = $monto * $nro_radiografias;
                    } else {
                        $precio = $monto;
                    }

                    $montoDiax   = 0;
                    $montoDoctor = 0;

                    if ($monto == 0) {
                        $total       =  ($monto_seguro * $nro_radiografias) - $descuento;
                        $montoDoctor =  $monto_estudio;
                        $montoDiax   =  $total - $montoDoctor;
                    } else {
                        $total = $precio - 10000 - $descuento;
                        $montoDoctor = $monto_estudio;
                        $montoDiax  = $total  - $monto_estudio;
                    }


                    $insert_servicio = mysqli_query($conection, "INSERT INTO servicio_medicos(comprobante_id,doctor_id,estudio_id,monto,monto_diax,monto_doctor)
                VALUES('$id','$doctor_id','$estudio_id','$total','$montoDiax','$montoDoctor')");
                }
            }
        }
    }
}



echo $sql_updateComprobante;
