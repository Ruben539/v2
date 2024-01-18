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

  $sql = mysqli_query($conection, "SELECT m.nombre AS medico, e.nombre AS estudio, sm.monto, sm.monto_diax, sm.monto_doctor, ed.descripcion AS estado, sm.created_at
  FROM servicio_medicos sm INNER JOIN estudios e ON e.id = sm.estudio_id
  INNER JOIN medicos m ON m.id = sm.doctor_id INNER JOIN estado_deuda ed ON ed.id = sm.estado_deuda_id
  WHERE sm.doctor_id = $doctor_id AND sm.created_at BETWEEN '$desde' AND '$hasta' AND sm.estatus = 1;");

}

         



$resultado = mysqli_num_rows($sql);
  
if ($resultado > 0) {
  echo ' 

  <thead>
        <tr class="text-center">      
        <th>Nro </th>
        <th>Medico </th>
        <th>Estudio</th>
        <th>Monto</th>
        <th>Monto Diax</th>
        <th>Monto Medico</th>
        <th>Estado</th>
        <th>Fecha</th>                                
        </tr>
      </thead>
      <tbody>';
      $nro = 0;
      $monto = 0;
   
    while ($data = mysqli_fetch_array($sql)){
      $monto += $data['monto_doctor'];
     $nro++;
   
  
      echo '<tr>
  
      <td>'.$nro.'</td>
      <td>'. $data['medico'].'</td>
      <td>'. $data['estudio']. '</td>
      <td>'. number_format($data['monto'], 0, '.', '.'). '</td>
      <td>'. number_format($data['monto_diax'], 0, '.', '.'). '</td>
      <td>'. number_format($data['monto_doctor'], 0, '.', '.'). '</td>
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
        <td class="text-center alert alert-success">'.number_format($monto, 0, '.', '.').'.<b>GS</b></td>
  
      </tr>
    </tfoot>
     </table>';

}else{
  echo $alert = '<p class = "alert alert-danger">No hay Registros</p>';
  exit();
}


?>