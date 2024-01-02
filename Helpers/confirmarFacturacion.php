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
        $sql = mysqli_query($conection, "SELECT dc.comprobante_id,dc.estudio_id,dc.monto,dc.cobertura,dc.seguro_id,dc.descripcion,dc.nro_radiografias,dc.condicion_venta
         FROM detalle_comprobantes dc WHERE dc.comprobante_id = $id ");

        while ($data = mysqli_fetch_array($sql)) {

            $comprobante_id   = $data['comprobante_id'];
            $estudio_id       = $data['estudio_id'];
            $monto            = $data['monto'];
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
       }
    }

        echo $sql_updateComprobante;


?>