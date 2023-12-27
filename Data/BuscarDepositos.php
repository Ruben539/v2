<?php

require_once("../Models/conexion.php");


$fecha_desde = '';
$fecha_hasta  = '';
date_default_timezone_set('America/Asuncion');
$hoy =  date('Y-m-d');


if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])) {


  $sql = mysqli_query($conection, "SELECT d.id,d.fecha,d.monto,d.monto_real,d.usuario,d.foto,d.created_at
    FROM depositos d  WHERE d.created_at like '%".$hoy."%'  AND d.estatus = 1 ");
} else {

  $fecha_desde = $_POST['fecha_desde'].' 00:00:00';
    $fecha_hasta  = $_POST['fecha_hasta'].' 23:00:00';
   // exit();

    $sql = mysqli_query($conection, "SELECT d.id,d.fecha,d.monto,d.monto_real,d.usuario,d.foto,d.created_at
  FROM depositos d  WHERE d.created_at BETWEEN '$fecha_desde' AND '$fecha_hasta' AND d.estatus = 1");
}



$resultado = mysqli_num_rows($sql);


echo ' 
<table id="tablaComprobante" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
<thead>
      <tr class="text-center">      
        <th>Nro.</th>
        <th>Fecha</th>
        <th>Monto</th>                                                              
        <th>Monto Depositado</th>                                
        <th>Usuario</th>                                                          
        <th>Comprobante</th>                              
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
             <td>'. $data['fecha']. '</td>
             <td>'. $data['monto']. '</td>
             <td>'. $data['monto_real']. '</td>
             <td>'. $data['usuario']. '</td>
             <td>
             <button class="btn btn-outline-success" onclick="mostrarImgenDeposito(`'.$data['foto'].'`)"><i class="typcn typcn-camera-outline"></i></button>
             </td>
            
        </tr>';
}
echo
'</tbody>
 </table>';
?>
