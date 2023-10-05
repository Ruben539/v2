
<?php
//print_r($_POST);
//exit();
require_once("../Models/conexion.php");

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])){
  
  $hoy = date('Y-m-d');
  $sql = mysqli_query($conection,"SELECT e.nombre, COUNT(dc.estudio_id) AS cantidad FROM  detalle_comprobantes dc
  INNER JOIN estudios e ON e.id = dc.estudio_id
  WHERE date(dc.created_at) LIKE '%".$hoy."%' AND
  e.id IN (SELECT estudio_id FROM detalle_comprobantes)
  GROUP BY e.nombre ORDER BY cantidad");

$resultado = mysqli_num_rows($sql);

}else{

  $desde  = $_POST['fecha_desde']. '-00:00:00';
  $hasta  = $_POST['fecha_hasta']. '-23:00:00';

  $sql = mysqli_query($conection,"SELECT e.nombre, COUNT(dc.estudio_id) AS cantidad FROM  detalle_comprobantes dc
  INNER JOIN estudios e ON e.id = dc.estudio_id
  WHERE date(dc.created_at) BETWEEN '".$desde."' AND '".$hasta."' AND
  e.id IN (SELECT estudio_id FROM detalle_comprobantes)
  GROUP BY e.nombre ORDER BY cantidad");

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