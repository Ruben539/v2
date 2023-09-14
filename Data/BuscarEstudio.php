
<?php
require_once("../Models/conexion.php");
$fecha_desde = '';
$fecha_hasta  = '';
$fecha  = '';
$hoy = date('m-Y');
$buscar = '';
$where = '';

if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])) {

  $sql = mysqli_query($conection, "SELECT Estudio, COUNT(*) as cantidad FROM historial 
   WHERE Fecha LIKE '%".$hoy."%'  GROUP BY Estudio ORDER BY cantidad ");


} else if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])) {

  $fecha_desde = date_create($_REQUEST['fecha_desde']);
  $desde = date_format($fecha_desde, 'd-m-Y');


  $fecha_hasta = date_create($_REQUEST['fecha_hasta']);
  $hasta = date_format($fecha_hasta, 'd-m-Y');

  $fecha = date_format($fecha_hasta, 'm-Y');

  if ($desde == $hasta) {

    $where = "Fecha LIKE '%$desde%'";

  } else {

    $f_de = $desde . '-00:00:00';
    $f_a  = $hasta . '-23:00:00';
    $where = "Fecha BETWEEN '$f_de' AND '$f_a' AND Fecha LIKE '%".$fecha."%' ";
    $buscar = "fecha_desde=$desde&fecha_hasta=$hasta ";


  }
  $sql = mysqli_query($conection, "SELECT Estudio, COUNT(*) as cantidad FROM historial 
   WHERE $where  GROUP BY Estudio ORDER BY cantidad ");
}





$resultado = mysqli_num_rows($sql);


echo ' 

<thead>
      <tr class="text-center">      
        <th>Estudio</th>
        <th>Cantidad</th>
                                   
      </tr>
    </thead>
    <tbody>';
$total = 0;

while ($data = mysqli_fetch_array($sql)) {
  $total += $data['cantidad'];
  echo '<tr>
             <td>' . $data['Estudio'] . '</td>
             <td class="text-center">' . $data['cantidad'] . '</td>
             

        </tr>';
}
echo
'</tbody>
  <tfoot>
    <tr>
      <td><b>Cantidad Total : </b></td>
    
      <td class="text-center alert alert-success">' . $total . '</td>
      
      
    </tr>
  </tfoot>
   </table>';
?>