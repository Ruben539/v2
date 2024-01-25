<?php
session_start();
require_once "../Models/conexion.php";
	

	$id=$_POST['id'];

	$estatus = 0;
	$fecha_anulado = date('Y-m-d h:i:s');
    $usuario =  $_SESSION['idUser'];
	

	$sql = mysqli_query($conection,"UPDATE comprobantes set 
                fecha_anulado = '$fecha_anulado',
                usuario_2 = '$usuario',
                estatus = '$estatus'
                    WHERE id = '$id'");
 

    if($sql){
        
    
        $update_consulta = mysqli_query($conection,"UPDATE consulta_medicos SET estatus = '$estatus'
       WHERE comprobante_id = '$id'");        

        if($update_consulta){
            
            $query_comprobante = mysqli_query($conection,"SELECT * FROM comprobantes WHERE id = '$id'");

            while($data = mysqli_fetch_array($query_comprobante)){
                $ruc    = $data['ruc'];
                $fecha  = $data['created_at'];
            }
    
             $hoy = date_create($fecha);
             $fecha = date_format($hoy, 'Y-m-d');

            $update_servicio = mysqli_query($conection,"UPDATE servicio_medicos SET estatus = '$estatus'
           WHERE comprobante_id = '$id'");

            
        }
        echo $update_servicio;


    }else{
        echo 'ERROR AL ELIMINAR';
        exit;
    }
    

 ?>