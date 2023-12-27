<?php

require_once("../Models/conexion.php");


$fecha_desde = '';
$fecha_hasta  = '';
date_default_timezone_set('America/Asuncion');
$fecha =  date('Y-m-d');


if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])) {


  $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,c.monto,c.concepto,c.usuario,c.created_at,c.proveedor
    FROM empresa_movimientos c where c.created_at like '%" . $fecha . "%'  AND c.estatus = 1 ");
} else {

  $fecha_desde = $_POST['fecha_desde'];
  $fecha_hasta  = $_POST['fecha_hasta'];
  // exit();

  $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,c.monto,c.concepto,c.usuario,c.created_at,c.proveedor
    FROM empresa_movimientos c where c.created_at BETWEEN '$fecha_desde' AND '$fecha_hasta' AND c.estatus = 1");
}



$resultado = mysqli_num_rows($sql);


echo ' 
<table id="tablaComprobante" class="table table-striped table-bordered table-condensed table-hover" style="width:100%">
<thead>
      <tr class="text-center">      
        <th>Nro.</th>
        <th>Fecha de Movimiento</th>                               
        <th>Forma de Pago</th>                                
        <th>Nro Cheque/ Transferencia</th>                                
        <th>Tipo de Movimiento</th>                                
        <th>Monto</th>                                
        <th>Concepto</th>                                
        <th>Usuario</th>                                
        <th>Comprobante</th>                                
        <th>Editar</th>                                
        <th>Eliminar</th>                                
      </tr>
    </thead>
    <tbody class="text-center">';
$monto = 0;
$num = 0;
while ($data = mysqli_fetch_array($sql)) {
  $monto += (int)$data['monto'];
  $num++;
  echo '<tr>
             <td>' . $num . '</td>
             <td>' . $data['created_at'] . '</td>
             <td>' . $data['forma_pago'] . '</td>
             <td>' . $data['nro_cheque'] . '</td>
             <td>' . $data['tipo_salida'] . '</td>
             <td>' . number_format($data['monto'], 0, '.', '.') . '</td>
             <td>' . $data['concepto'] . '</td>
             <td>' . $data['usuario'] . '</td>
             <td>
             <button class="btn btn-success"  onclick="">
             <i class="typcn typcn-eye-outline"></i></button>
             </td>
             <td>
             <a href="../View/modificarMovimiento.php?id=' . $data['id'] . ' " class="btn btn-outline-info"><i class="typcn typcn-edit"></i></a>
             </td>
             <td>
             <a href="../View/cancelarMovimientos.php?id=' . $data['id'] . ' " class="btn btn-outline-danger"><i class="typcn typcn-trash"></i></a>
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
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="text-center alert alert-success">' . number_format($monto, 0, '.', '.') . '.<b>GS</b></td>
      
      
    </tr>
  </tfoot>
   </table>';
?>

<script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../assets/js/Comprobantes/comprobantes.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $('#btnEditarUsu').click(function() {
      /* Act on the event */

      confirmarDatosFacturacion();
    });



  });
</script>