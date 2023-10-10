
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

if(empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta']) && empty($_POST['medico'])){
  echo '<div class="alert alert-danger text-center">Debe seleccionar la fecha y el medico a buscar</div>';
  exit();
}else{
  $desde     = $_POST['fecha_desde']. '-00:00:00';
  $hasta     = $_POST['fecha_hasta']. '-23:00:00';
  $doctor_id = $_POST['doctor'];

  $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,u.fecha_nac,u.nombre,
SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, 
c.created_at,c.estatus
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
WHERE date(c.created_at) BETWEEN '".$desde."' AND '".$hasta."' AND m.id = '".$doctor_id."'  GROUP BY c.id");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/v2/bootstrap/dist/css/bootstrap.min.css">
  <title>Reporte de medicos</title>
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
                <th class="ml-5">Nro</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Descuento</th>
                  <th>Doctor</th>
                  <th>Forma de Pago</th>
                  <th>Seguro</th>
                  <th>Comentario</th>
                  <th>Fecha</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $resultado = mysqli_num_rows($sql);
                $total = 0;
                $descuento = 0;
                $nro = 0;
                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $total += (int)$data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;
                ?>
                <?php if($data['estatus'] == 0){?>
                    <tr class="text-center bg-danger">
                <?php }else{ ?>
                  <tr class="text-center">
                  <?php } ?>
                      <td><?php echo $nro ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <p>Ingreso Total :</p>
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($total - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>


  </main>
</body>

</html>

