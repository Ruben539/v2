<?php



require_once("../Models/conexion.php");
$alert = '';



if (!empty($_POST)) {
    $alert = '';

 
    if (empty($_POST['forma_pago']) ||  empty($_POST['tipo_salida']) || empty($_POST['monto']) || empty($_POST['concepto'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {

        $forma_pago    = $_POST['forma_pago'];
        $nro_cheque    = $_POST['nro_cheque'];
        $tipo_salida   = $_POST['tipo_salida'];
        $monto         =$_POST['monto'];
        $concepto      = trim($_POST['concepto']);
        $usuario       = $_POST['usuario'];
        $proveedor     = $_POST['proveedor'];

        $foto          = $_FILES['foto'];
        $nombre_foto   = $foto['name'];
        $type          = $foto['type'];
        $url_tmp       = $foto['tmp_name'];

        $imgComprobante =  'img_comprobante.png';

        if($nombre_foto != ''){

            $destino         =  '../Images/Comprobantes/';
            $imgNombre       = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgComprobante  = $imgNombre.'.jpg';
            $src             = $destino.$imgComprobante;

        }
              

        $query = mysqli_query($conection, "SELECT id,monto FROM caja_chica WHERE estatus = 1");

        $resultado = mysqli_num_rows($query);
        $total = 0;

        if($resultado > 0){
            while($data = mysqli_fetch_array($query)){
                $id       = $data['id'];
                $montoCaja = $data['monto'];
            }

            if($montoCaja < $monto){
                $alert = '<p class = "msg_error">El monto en su caja es menor al necesitado, actualice su caja</p>'; 
            }else{
              
        $query_insert = mysqli_query($conection, "INSERT INTO empresa_movimientos(forma_pago,nro_cheque,tipo_salida,monto,concepto,usuario,proveedor,foto)
				VALUES('$forma_pago','$nro_cheque','$tipo_salida','$monto','$concepto','$usuario','$proveedor','$imgComprobante' );");

        if ($query_insert) {
            if($nombre_foto != ''){
                move_uploaded_file($url_tmp, $src);
            }

            if($query_insert){
                if($tipo_salida == 'Egreso'){

                $total = $montoCaja - $monto;
                $update_caja = mysqli_query($conection,"UPDATE caja_chica SET monto = '$total' WHERE id = $id");
                
                }
                
            }

            $alert = '<p class = "msg_save">Registro guardado Correctamente</p>';
        } else {
            $alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
        }
            }

           
        }else{
            $alert = '<p class = "msg_error">No tiene monto a descontar en su caja chica</p>';
        }   

           


    //     $query_insert = mysqli_query($conection, "INSERT INTO empresa_movimientos(forma_pago,nro_cheque,tipo_salida,monto,concepto,usuario,proveedor,foto)
	// 			VALUES('$forma_pago','$nro_cheque','$tipo_salida','$monto','$concepto','$usuario','$proveedor','$imgComprobante' );");

    //     if ($query_insert) {
    //         if($nombre_foto != ''){
    //             move_uploaded_file($url_tmp, $src);
    //         }

    //         $alert = '<p class = "msg_save">Registro guardado Correctamente</p>';
    //     } else {
    //         $alert = '<p class = "msg_error">Error al Guardar el Registro</p>';
    //     }
     }
   
}