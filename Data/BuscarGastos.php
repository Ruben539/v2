
<?php

require_once("../Models/conexion.php");

$fecha_desde = '';
$fecha_hasta  = '';
$hoy = date("Y-m-d");


if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta']) ) {

 
    $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.created_at
    FROM gastos g  where created_at like '%".$hoy."%'  AND g.estatus = 1 ");

}else{ 

    $fecha_desde = $_POST['fecha_desde'];
    $fecha_hasta  = $_POST['fecha_hasta'];
   // exit();

    $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.created_at
  FROM gastos g  where created_at BETWEEN '$fecha_desde' AND '$fecha_hasta' AND g.estatus = 1");
}



$resultado = mysqli_num_rows($sql);


echo ' 

<thead>
      <tr class="text-center">      
        <th>Descripcion</th>
        <th>Monto</th>                               
        <th>Fecha</th>                                
        <th>Editar</th>                                
        <th>Eliminar</th>                                
      </tr>
    </thead>
    <tbody class="text-center">';
    $monto = 0;

  while ($data = mysqli_fetch_array($sql)){
    $monto += $data['monto'];
    echo '<tr>
             <td>'. $data['descripcion']. '</td>
             <td>'. $data['monto']. '</td>
             <td>'. $data['created_at']. '</td>
             <td>
             <a href="../View/modificarGasto.php?id='. $data['id'].' " class="btn btn-outline-info"><i class="typcn typcn-edit"></i></a>
             </td>
             <td>
             <a href="../View/gastosCancelacion.php?id='. $data['id'].' " class="btn btn-outline-danger"><i class="typcn typcn-trash"></i></a>
             </td>
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
      <td class="text-center alert alert-success">'.number_format($monto, 0, '','.').'.<b>GS</b></td>
      
      
    </tr>
  </tfoot>
   </table>';
?>