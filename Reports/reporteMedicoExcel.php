<?php
$planillas = "Reporte de Comprobantes Medicos.xls";
header("content-Type: application/vnd.ms-excel");
header("content-Disposition: attachment; filename=" . $planillas);
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
session_start();

require_once("../Models/conexion.php");

$medico = '';
$fecha_desde = '';
$fecha_hasta  = '';
if(empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta']) || empty($_POST['medico'])) {
  
  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar los parametros a buscar

  </div>';
  exit();
  
}

if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])|| !empty($_REQUEST['medico'])) {
  $fecha_desde = date_create($_REQUEST['fecha_desde']);
  $desde = date_format($fecha_desde, 'd-m-Y');


  $fecha_hasta = date_create($_REQUEST['fecha_hasta']);
  $hasta = date_format($fecha_hasta, 'd-m-Y');

  $medico = trim($_POST['medico']);

 $buscar = '';
 $where = '';

}if ($desde > $hasta) {
 echo $alert = '<p class = "alert alert-danger">La Fecha de Inicio de la busqueda debe ser mayor a la del final</p>';
  exit();
  
}else if ($desde == $hasta) {

  $where = "Fecha LIKE '%$desde%' AND Atendedor LIKE '%$medico%'";

  $buscar = "fecha_desde=$desde&fecha_hasta=$hasta AND Atendedor LIKE '%$medico%' ";
}else {
  $f_de = $desde.'-00:00:00';
  $f_a  = $hasta.'-23:00:00';
  $where = "Fecha BETWEEN '$f_de' AND '$f_a' AND Atendedor LIKE '%$medico%' ";
  $buscar = "fecha_desde=$desde&fecha_hasta=$hasta AND Atendedor LIKE '%$medico%'";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistema_diax/bootstrap/dist/css/bootstrap.min.css">
  <title>Reporte de Comprobantes</title>
</head>

<body>

  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Lista de Pacientes</h5>
          <div class="table-responsive">
            <table id="tabla_Usuario" class="table table-striped table-bordered table-condensed" style=" font-size: 10px;">
              <thead>
                <tr class="text-center">

                <th>Fecha</th>
                <th>Nombre</th>
                <th>Cedula</th>
                <th>Estudio</th>
                <th>Doctor/a</th>
                <th>Seguro</th>
                <th>Monto</th>
                <th>Monto Seguro</th>
                <th>Descuento</th>
                <th>Comentario</th>

                </tr>
              </thead>

              <tbody>
                <?php
                  $anio = date_create($_REQUEST['fecha_desde']);
                  $hoy = date_format($anio, 'm-Y');

                $sql = mysqli_query($conection, "SELECT DISTINCT(h.id),c.nombre,c.apellido,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
                FROM historial h inner join clientes c on c.cedula = h.cedula  where $where and Fecha like '%".$hoy."%' ORDER BY  h.id ASC");
              
              
                $resultado = mysqli_num_rows($sql);
                $monto = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $monto += (int)$data['Monto'];

                ?>
                    <tr class="text-center">

                    <td><?php echo $data['Fecha'] ?></td>
                    <td><?php echo $data['nombre'].' '.$data['apellido'];  ?></td>
                    <td><?php echo $data['Cedula']; ?></td>
                    <td><?php echo $data['Estudio']; ?></td>
                    <td><?php echo $data['Atendedor']; ?></td>
                    <td><?php echo $data['Seguro']; ?></td>
                    <td><?php echo $data['Monto'] ?></td>
                    <td><?php echo $data['MontoS'] ?></td>
                    <td><?php echo $data['Descuento'] ?></td>
                    <td><?php echo $data['Comentario'] ?></td>


                    </tr>


                <?php }
                } ?>
              </tbody>
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
                <td class="alert alert-success text-center">
                <?php echo number_format($monto, 3, '.', '.'); ?>.<b>G</b>
                </td>


              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>


  </main>
</body>

</html>
