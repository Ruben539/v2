
<?php
//print_r($_POST);
//exit();
require_once("../Models/conexion.php");

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta']) && empty($_POST['seguro_id'])){
  
  $hoy = date('Y-m-d');
  $sql = mysqli_query($conection,"SELECT s.descripcion as nombre, COUNT(DISTINCT(dc.comprobante_id)) AS cantidad FROM  detalle_comprobantes dc
  INNER JOIN comprobantes c ON c.id = dc.comprobante_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE date(dc.created_at) LIKE '%".$hoy."%' AND
  s.id IN (SELECT seguro_id FROM detalle_comprobantes)
  GROUP BY s.descripcion ORDER BY cantidad");

$resultado = mysqli_num_rows($sql);

}else{

  $desde   = $_POST['fecha_desde']. '-00:00:00';
  $hasta   = $_POST['fecha_hasta']. '-23:00:00';
  $seguro  = $_POST['seguro_id'];

  $sql = mysqli_query($conection,"SELECT s.descripcion as nombre, COUNT(DISTINCT(dc.comprobante_id)) AS cantidad FROM  detalle_comprobantes dc
  INNER JOIN comprobantes c ON c.id = dc.comprobante_id
  INNER JOIN seguros s ON s.id = dc.seguro_id
  WHERE s.id = '".$seguro."' AND date(dc.created_at) BETWEEN '".$desde."' AND '".$hasta."' AND
  s.id IN (SELECT seguro_id FROM detalle_comprobantes)
  GROUP BY s.descripcion ORDER BY cantidad");

$resultado = mysqli_num_rows($sql);
}


echo ' 

<thead>
      <tr class="text-center">      
        <th>Nro</th>
        <th>Estudio</th>
        <th>Cantidad</th>
                                   
      </tr>
    </thead>
    <tbody>';
$total = 0;
$nro =0;
while ($data = mysqli_fetch_array($sql)) {
  $nro++;
  $total += $data['cantidad'];
  echo '<tr>
        <td>' . $nro. '</td>
        <td>' . $data['nombre'] . '</td>
        <td class="text-center">' . $data['cantidad'] . '</td>
             

        </tr>';
}
echo
'</tbody>
  <tfoot>
    <tr>
      <td><b>Cantidad Total : </b></td>
      <td></td>
      <td class="text-center alert alert-success">' . $total . '</td>
      
      
    </tr>
  </tfoot>
   </table>';
?>