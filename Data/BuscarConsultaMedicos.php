<?php
//echo 'Hola desde el buscador';
//print_r($_POST);
session_start();
require_once("../Models/conexion.php");
$alert = '';
if(empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta']) || empty($_POST['medico'])) {
  
  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar los parametros a buscar

  </div>';
  exit();
  
}


if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])|| !empty($_REQUEST['medico'])) {

  $desde     = $_POST['fecha_desde']. '-00:00:00';
  $hasta     = $_POST['fecha_hasta']. '-23:00:00';
  $doctor_id = $_POST['medico'];

  $sql = mysqli_query($conection, "SELECT cm.ruc,cm.razon_social,e.nombre AS estudio,cm.monto,cm.monto_seguro,
  cm.descuento,cm.monto_cobrado,fp.descripcion AS formaPago,ed.descripcion AS estado,cm.created_at
  FROM consulta_medicos cm INNER JOIN estudios e ON e.id = cm.estudio_id
  INNER JOIN medicos m ON m.id = cm.doctor_id INNER JOIN forma_pagos fp ON fp.id = cm.forma_pago_id
  INNER JOIN estado_deuda ed ON ed.id = cm.estado_deuda_id
  WHERE cm.doctor_id = $doctor_id AND cm.created_at BETWEEN '$desde' AND '$hasta' AND cm.estatus = 1;");

}

         



$resultado = mysqli_num_rows($sql);
  
if ($resultado > 0) {
  echo ' 

  <thead>
        <tr class="text-center">      
        <th>Nro </th>
        <th>Ruc </th>
        <th>Razon Social</th>
        <th>Estudio</th>
        <th>Monto</th>
        <th>Monto Seguro</th>
        <th>Descuento</th>
        <th>Monto Cobrado</th>
        <th>Forma de Pago</th>
        <th>Estado</th>
        <th>Fecha</th>                                
        </tr>
      </thead>
      <tbody>';
      $nro = 0;
      $monto = 0;
   
    while ($data = mysqli_fetch_array($sql)){
      $monto += $data['monto'];
     $nro++;
   
  
      echo '<tr>
  
      <td>'.$nro.'</td>
      <td>'. $data['ruc']. '</td>
      <td>'. $data['razon_social'].'</td>
      <td>'. $data['estudio']. '</td>
      <td>'. number_format($data['monto'], 0, '.', '.'). '</td>
      <td>'. number_format($data['monto_seguro'], 0, '.', '.'). '</td>
      <td>'. number_format($data['descuento'], 0, '.', '.'). '</td>
      <td>'. number_format($data['monto_cobrado'], 0, '.', '.'). '</td>
      <td>'. $data['formaPago']. '</td>
      <td>'. $data['estado']. '</td>
      <td>'. $data['created_at']. '</td>
  
          </tr>';
    }
    echo
    '</tbody>
    <tfoot>
      <tr>
        <td><b>Total A Rendir : </b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-center alert alert-success">'.number_format($monto, 0, '.', '.').'.<b>GS</b></td>
  
      </tr>
    </tfoot>
     </table>';

}else{
  echo $alert = '<p class = "alert alert-danger">No hay Registros</p>';
  exit();
}


?>