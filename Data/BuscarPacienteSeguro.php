
<?php
//print_r($_POST);
//exit();
require_once("../Models/conexion.php");

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta']) && empty($_POST['seguro_id'])){
  
  date_default_timezone_set('America/Asuncion');
  $hoy = date('Y-m-d');

  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE  c.created_at LIKE '%". $hoy."%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

$resultado = mysqli_num_rows($sql);

}else if($_POST['fecha_desde'] && $_POST['fecha_hasta'] && empty($_POST['seguro_id'])){

  date_default_timezone_set('America/Asuncion');
  $desde   = $_POST['fecha_desde']. '-00:00:00';
  $hasta   = $_POST['fecha_hasta']. '-23:00:00';
  //$seguro  = $_POST['seguro_id'];

  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE  c.created_at BETWEEN '".$desde."' AND '".$hasta."'  AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

$resultado = mysqli_num_rows($sql);

}else if($_POST['fecha_desde'] && $_POST['fecha_hasta'] && $_POST['seguro_id'] && empty($_POST['cobertura'])){
  
  $desde      = $_POST['fecha_desde']. '-00:00:00';
  $hasta      = $_POST['fecha_hasta']. '-23:00:00';
  $seguro     = $_POST['seguro_id'];


  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE  c.created_at BETWEEN '".$desde."' AND '".$hasta."' AND dc.seguro_id = '".$seguro."'  AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

$resultado = mysqli_num_rows($sql);

}else if($_POST['fecha_desde'] && $_POST['fecha_hasta'] && $_POST['seguro_id'] && $_POST['cobertura']){

  $desde      = $_POST['fecha_desde']. '-00:00:00';
  $hasta      = $_POST['fecha_hasta']. '-23:00:00';
  $seguro     = $_POST['seguro_id'];
  $cobertura  = $_POST['cobertura'];

  $sql = mysqli_query($conection,"SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, 
  fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro
  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE  c.created_at BETWEEN '".$desde."' AND '".$hasta."' AND dc.seguro_id = '".$seguro."' AND dc.cobertura  = '".$cobertura."'  AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");
}else{
  echo "Error en los parametros";
}


echo ' 

<thead>
  <th>Fecha</th>
  <th class="ml-5">Nro Ticket</th>
  <th>Ruc </th>
  <th>Nombre</th>
  <th>Estudio</th>
  <th>Monto</th>
  <th>Monto Seguro</th>
  <th>Descuento</th>
  <th>Monto Cobrado</th>
  <th>Doctor</th>
  <th>Forma de Pago</th>
  <th>Seguro</th>
  <th>Comentario</th>
                                   
      </tr>
    </thead>
    <tbody>';
$total = 0;
$nro =0;
while ($data = mysqli_fetch_array($sql)) {
  $nro++;
  $total += $data['monto'];
  echo '<tr>
  <td class="text-center">' . $data['created_at'] . '</td>
        <td>' . $data['id']. '</td>
        <td>' . $data['ruc'] . '</td>
        <td class="text-center">' . $data['razon_social'] . '</td>
        <td class="text-center">' . $data['estudio'] . '</td>
        <td class="text-center">' . number_format($data['monto'],0, '.', '.') . '</td>
        <td class="text-center">' . number_format($data['monto_seguro'],0, '.', '.') . '</td>
        <td class="text-center">' . number_format($data['descuento'],0, '.', '.') . '</td>
        <td class="text-center">' . number_format($data['monto'] - $data['descuento'],0, '.', '.') . '</td>
        <td class="text-center">' . $data['doctor'] . '</td>
        <td class="text-center">' . $data['forma_pago'] . '</td>
        <td class="text-center">' . $data['seguro'] . '</td>
        <td class="text-center">' . $data['comentario'] . '</td>
             

        </tr>';
}
echo
'</tbody>
  <tfoot>
    <tr>
      <td><b>Cantidad Total : </b></td>
      <td></td>
      <td class="text-center alert alert-success">' . number_format($total,0,'.','.'). '</td>
      
      
    </tr>
  </tfoot>
   </table>';
?>