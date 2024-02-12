<?php


require_once('../Models/conexion.php');
$alert = '';

if (!empty($_POST)) {


    if ( empty($_POST['monto'])) {

        $alert = '<p class = "msg_error">Debe llenar Todos los Campos</p>';
    } else {


        $monto        = $_POST['monto'];

        $resultado = 0;

        $query = mysqli_query($conection, "SELECT id,monto FROM caja_chica  WHERE estatus = 1 ");

        $resultado = mysqli_num_rows($query);
       

        if ($resultado > 0) {
    
            $total     = 0;

            while($data  = mysqli_fetch_array($query)){
                $id         = $data['id'];
                $montoCaja  = $data['monto'];
            }
            
            $total =  $montoCaja + $monto;

            if($montoCaja < 900000){
               
                $update_caja = mysqli_query($conection,"UPDATE caja_chica SET monto = 0, estatus = 0 WHERE id = $id");
                
                $query_insert = mysqli_query($conection, "INSERT INTO caja_chica(monto)
				VALUES('$total')");

            }else{
                
                $query_insert = mysqli_query($conection, "INSERT INTO caja_chica(monto)
				VALUES('$monto')");
            }

        } else {


            $query_insert = mysqli_query($conection, "INSERT INTO caja_chica(monto)
				VALUES('$monto')");


            if ($query_insert) {

                $alert = '<p class = "msg_save">Monto asignado correctamente</p>';
            } else {
                $alert = '<p class = "msg_error">Error al asignar el monto</p>';
            }
        }
      
    }
   // mysqli_close($conection);
}
