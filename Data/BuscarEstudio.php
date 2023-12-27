
<?php

require_once("../Models/conexion.php");

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])){
  
  $hoy = date('Y-m-d');
  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, dc.monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE c.created_at LIKE '%".$hoy."%' GROUP BY c.id");

$resultado = mysqli_num_rows($sql);

}else{

  $desde    = $_POST['fecha_desde']. '-00:00:00';
  $hasta    = $_POST['fecha_hasta']. '-23:00:00';
  $estudio  = $_POST['estudio'];

  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, dc.monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE dc.estudio_id = '".$estudio."' AND  c.created_at BETWEEN '".$desde."' AND '".$hasta."' ");

$resultado = mysqli_num_rows($sql);
}


echo ' 

<thead>
<tr class="text-center" style="font-size: 12px;font-weight: bold;">
  <th>Nro Ticket </th>
  <th>Ruc </th>
  <th>Nombre</th>
  <th>Estudio</th>
  <th>Doctor</th>
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
    $descuento = 0;
    $totalEfectivo = 0;
    $precio = 0;
    $estatus = 0;

while ($data = mysqli_fetch_array($sql)) {
  $estatus = $data['estatus'];
  if($estatus == 1){
    $precio = $data['monto'];
  }else{
    $precio = 0;
  }
  
  $descuento += (int)$data['descuento'];
  $nro++;

  if ($data['estudio'] == 'Radiografias') {
    $monto = $precio * $data['nro_radiografias'];
  } else if ($data['estudio'] != 'Radiografias') {
    $monto =  $precio;
  }

  $totalEfectivo += $data['monto'];

  if($estatus == 1){
    echo '<tr>
        <td>' . $data['id'] . '</td>
        <td>' . $data['ruc'] . '</td>
        <td>' . $data['razon_social'] . '</td>
        <td>' . $data['estudio']. '</td>
        <td>' . $data['doctor']. '</td>
        <td>' . number_format($data['monto'], 0, '.', '.') . '</td>
        <td>' . number_format($data['monto_seguro'], 0, '.', '.') . '</td>
        <td>' . number_format($data['descuento'], 0, '.', '.') . '</td>
        <td>' . number_format($data['monto'] - $data['descuento'], 0, '.', '.') . '</td>
        <td>' .  $data['forma_pago'] . '</td>
        <td>' .  $data['seguro'] . '</td>
        </tr>';
  }else{
    echo '<tr class = "alert alert-danger">
        <td>' . $data['id'] . '</td>
        <td>' . $data['ruc'] . '</td>
        <td>' . $data['razon_social'] . '</td>
        <td>' . $data['estudio']. '</td>
        <td>' . $data['doctor']. '</td>
        <td>' . number_format($data['monto'], 0, '.', '.') . '</td>
        <td>' . number_format($data['monto_seguro'], 0, '.', '.') . '</td>
        <td>' . number_format($data['descuento'], 0, '.', '.') . '</td>
        <td>' . number_format($data['monto'] - $data['descuento'], 0, '.', '.') . '</td>
        <td>' .  $data['forma_pago'] . '</td>
        <td>' .  $data['seguro'] . '</td>
        </tr>';
  }
 
 
}
echo
'</tbody>
   </table>';
?>