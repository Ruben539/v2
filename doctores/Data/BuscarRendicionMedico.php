<?php 

session_start();
require_once('../Models/conexion.php');

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])){

    echo '<div class="alert alert-danger text-center"><h3>Debes seleccionar un rango de Fecha</h3></div>';
}else{

$id     =  $_SESSION['idMedico'];
$desde  = $_POST['fecha_desde']. ' 00:00:00';
$hasta  = $_POST['fecha_hasta']. ' 23:00:00';

$sql_medico = mysqli_query($conection, "SELECT c.ruc, c.razon_social, c.created_at,dc.descripcion as estudio, dc.monto,dc.monto_seguro,
dc.descuento,dc.nro_radiografias,fp.descripcion as forma_pago,s.descripcion as seguro,dc.pago_diferido,
IF(c.estatus = 1, dc.monto - 10000, 0) as monto,
IF(c.estatus = 1, dc.descuento, 0) as descuento
FROM detalle_comprobantes dc INNER JOIN comprobantes c ON c.id =  dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id 
WHERE c.doctor_id = '$id' AND c.created_at BETWEEN '$desde' AND '$hasta' AND c.estatus = 1");

}

$resultado = mysqli_num_rows($sql_medico);
if($resultado > 0) {

    echo ' 
    <thead>
          <tr class="text-center">      
          <th>Fecha </th>
          <th>Ruc </th>
          <th>Nombre</th>
          <th>Estudio</th>
          <th>Monto</th>
          <th>Monto Seguro</th>
          <th>Desc.</th>
          <th>Monto Cobrado</th>
          <th>Forma de Pago</th>
          <th>Seguro</th>                              
          </tr>
        </thead>
        <tbody>';
        $monto = 0;

    while($data = mysqli_fetch_array($sql_medico)){
        $monto += $data['monto'];

        echo '<tr>
  
        <td>'. $data['created_at']. '</td>
        <td>'. $data['ruc']. '</td>
        <td>'. $data['razon_social'].'</td>
        <td>'. $data['estudio']. '</td>
        <td>'. number_format($data['monto'], 0, '.', '.'). '</td>
        <td>'. number_format($data['monto_seguro'], 0, '.', '.'). '</td>
        <td>'. number_format($data['descuento'], 0, '.', '.'). '</td>
        <td>'. number_format($data['monto'] - $data['descuento'], 0, '.', '.'). '</td>
        <td>'. $data['forma_pago']. '</td>
        <td>'. $data['seguro']. '</td>
    
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
  
}

