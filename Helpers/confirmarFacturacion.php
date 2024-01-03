<?php
;
    require_once "../Models/conexion.php";

   
    
        $id= $_POST['id'];
        $forma_pago_id    = $_POST['forma_pago_id'];
        $id_referente     = $_POST['id_referente'];
        $forma_pago_id_2  = $_POST['forma_pago_id_2'];
        $monto_2          = $_POST['monto_2'];
        $estatus          = 1;
        $monto = 0;
        $pago  = 0;

        date_default_timezone_set('America/Asuncion');
        $hoy =  date('Y-m-d');
        $sql = mysqli_query($conection, "SELECT dc.comprobante_id,dc.estudio_id,dc.monto,dc.monto_seguro,dc.descuento,dc.cobertura,dc.seguro_id,dc.descripcion,dc.nro_radiografias,dc.condicion_venta
         FROM detalle_comprobantes dc WHERE dc.comprobante_id = $id ");

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
          $pago = (int)$monto - (int)$monto_2;
          $pago_diferido = 1; 
            

        if(!empty($forma_pago_id_2)){
             //validar si el pago es unico
          
        $sql_facturacion= mysqli_query($conection, "UPDATE detalle_comprobantes 
        SET forma_pago_id = '$forma_pago_id', id_referente = '$id_referente', monto = '$pago'  WHERE comprobante_id = $id");

        if($sql_facturacion){
            $quey_detalle = mysqli_query($conection, "INSERT INTO detalle_comprobantes(comprobante_id,estudio_id,monto,cobertura,seguro_id,descripcion,nro_radiografias,condicion_venta,forma_pago_id) 
            VALUES('$comprobante_id','$estudio_id','$monto_2','$cobertura','$seguro_id','$descripcion','$nro_radiografias','$condicion_venta','$forma_pago_id_2')");

            if($quey_detalle){
                $sql_updateComprobante = mysqli_query($conection, "UPDATE comprobantes SET estatus = '$estatus' WHERE id = $id"); 
            }
        }
        
        

    }else{

        //validar si el pago es diferente o igual al anterior
        $sql_facturacion= mysqli_query($conection, "UPDATE detalle_comprobantes 
        SET forma_pago_id = '$forma_pago_id', id_referente = '$id_referente'  WHERE comprobante_id = $id");
       
       if($sql_facturacion){
        $sql_updateComprobante = mysqli_query($conection, "UPDATE comprobantes SET estatus = '$estatus' WHERE id = $id");

        if($sql_updateComprobante){

        $query_estudio = mysqli_query($conection,"SELECT * FROM estudios WHERE id = $estudio_id");

            while($estudio = mysqli_fetch_array($query_estudio)){
                $categoria = $estudio['categoria_id'];
            }

            if($categoria == 1 ){
                //TODO: Obtener los datos para la tabla de consultas_medicos
                $datosComprobantes = mysqli_query($conection,"SELECT * FROM comprobantes WHERE id = $id");

                while($comprobante =  mysqli_fetch_array($datosComprobantes)){
                    $ruc          =  $comprobante['ruc'];
                    $razon_social =  $comprobante['razon_social'];
                    $doctor_id    =  $comprobante['doctor_id'];
                }

                $montoConsulta = 0;
                $montoCobrado  = 0;
                $montoConsulta = $monto - 10000;
                $montoCobrado  = $montoConsulta - $descuento;


                $insert_consulta = mysqli_query($conection,"INSERT INTO consulta_medicos(ruc,razon_social,estudio_id,doctor_id,monto,monto_seguro,descuento,monto_cobrado,forma_pago_id,seguro_id)
                VALUES('$ruc','$razon_social','$estudio_id','$montoConsulta','$monto','$monto_seguro','$descuento','$montoCobrado','$forma_pago_id','$seguro_id')");

            }else if($categoria == 2){

                $datosComprobantes = mysqli_query($conection,"SELECT * FROM comprobantes WHERE id = $id");
                //TODO: Obtener los datos para la tabla de servicio_medicos
                while($comprobante =  mysqli_fetch_array($datosComprobantes)){
                    $ruc          =  $comprobante['ruc'];
                    $razon_social =  $comprobante['razon_social'];
                    $doctor_id    =  $comprobante['doctor_id'];
                }
                
               $datosDoctor = mysqli_query($conection,"SELECT * FROM medicos WHERE id = $doctor_id");
               //TODO: Obtención del monto que cobra el medico por cada servicio.
               while($doctor =mysqli_fetch_array($datosDoctor)){
                    $id          = $doctor['id'];
                    $monto_cobro = $doctor['monto_cobro'];
               }

               $montoDiax   = 0;
               $montoDoctor = 0;
               $montoDiax   =  $monto - $monto_cobro;
               $montoDoctor = $monto_cobro;

               $insert_servicio = mysqli_query($conection,"INSERT INTO servicio_medicos(doctor_id,estudio_id,monto,monto_diax,monto_doctor)
               VALUES('$doctor_id','$estudio_id','$monto','$montoDiax','$montoDoctor')");
            }

        }
       }
    }

        echo $sql_updateComprobante;


?>