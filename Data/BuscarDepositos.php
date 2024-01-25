<?php
session_start();
require_once("../Models/conexion.php");


$fecha_desde = '';
$fecha_hasta  = '';
date_default_timezone_set('America/Asuncion');
$hoy =  date('Y-m-d');


if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])) {


  $sql = mysqli_query($conection, "SELECT d.id,d.monto,d.foto,d.fecha_deposito
    FROM deposito_diarios d  WHERE d.created_at like '%".$hoy."%'  AND d.estatus = 1 ORDER BY d.id DESC");
} else {

  $fecha_desde = $_POST['fecha_desde'].' 00:00:00';
  $fecha_hasta  = $_POST['fecha_hasta'].' 23:00:00';
   // exit();

    $sql = mysqli_query($conection, "SELECT d.id,d.monto,d.foto,d.fecha_deposito
  FROM deposito_diarios d  WHERE d.created_at BETWEEN '$fecha_desde' AND '$fecha_hasta' AND d.estatus = 1 ORDER BY d.id DESC");
}



$resultado = mysqli_num_rows($sql);


echo ' 
<table id="tablaComprobante" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
<thead>
      <tr class="text-center">      
        <th>Nro.</th>
        <th>Fecha</th>
        <th>Monto</th>                                                                                                                                                       
        <th>Comprobante</th>                              
        <th>Editar</th>                              
      </tr>
    </thead>
    <tbody class="text-center">';
$monto = 0;
$nro = 0;
while ($data = mysqli_fetch_array($sql)) {
  $monto += (int)$data['monto'];
 
  $nro++;
  echo '<tr>
             <td>'. $nro. '</td>
             <td>'. $data['fecha_deposito'] . '</td>
             <td>'. number_format($data['monto'],0,'.','.'). ' GS</td>';
             if($data['foto'] == ''){
              echo '<td>
               <a class="btn btn-outline-danger" href="../View/agregarFotoDeposito.php?id=' . $data['id'] . ' "><i class="typcn typcn-camera-outline"></i></a>
             </td>';
             }else{
              echo '<td>
               <button class="btn btn-outline-success" onclick="mostrarImgenDeposito(`'.$data['foto'].'`)"><i class="typcn typcn-eye-outline"></i></button>
             </td>';
        
             }

             if($_SESSION['rol'] == 1){
              echo '<td>
               <a class="btn btn-outline-info" href="../View/modificarMontoDeposito.php?id=' . $data['id'] . ' "><i class="typcn typcn-edit"></i></a>
             </td>';
        
             }
            
}
echo '
</tr>
</tbody>
 </table>';
?>
