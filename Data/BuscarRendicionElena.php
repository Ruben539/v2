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

  $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,u.fecha_nac,u.nombre,
SUM(dc.monto) as monto,dc.descuento, m.nombre as informante, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, 
c.created_at,c.estatus,c.nro_placas
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.informante_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
WHERE date(c.created_at) BETWEEN '".$desde."' AND '".$hasta."' AND c.informante_id = '".$doctor_id."'   GROUP BY c.id");

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
        <th>Descuento</th>
        <th>Informante</th>
        <th>Nro de Placas</th>
        <th>Comentario</th>
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
      <td>'. number_format($data['descuento'], 0, '.', '.'). '</td>
      <td>'. $data['informante']. '</td>
      <td>'. $data['nro_placas']. '</td>
      <td>'. $data['comentario']. '</td>
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