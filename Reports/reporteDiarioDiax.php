<?php
session_start();

require_once("../Models/conexion.php");

if (empty($_POST['fecha_desde']) || empty($_POST['fecha_hasta'])) {

  echo '<div class="alert alert-danger" role="alert">
    Debes seleccionar las fechas a buscar
  </div>';
  exit();
}

if (!empty($_REQUEST['fecha_desde']) && !empty($_REQUEST['fecha_hasta'])) {
  $fecha_desde = date_create($_REQUEST['fecha_desde']);
  $desde = date_format($fecha_desde, 'Y-m-d');


  $fecha_hasta = date_create($_REQUEST['fecha_hasta']);
  $hasta = date_format($fecha_hasta, 'Y-m-d');

  $valor = trim($_REQUEST['valor']);

  $buscar = '';
  $where = '';
}

$f_de = $desde . '-00:00:00';
$f_a  = $hasta . '-23:00:00';
$where = "c.created_at BETWEEN '$f_de' AND '$f_a' AND m.nombre LIKE '%" . $valor . "%' ";
$buscar = "fecha_desde=$desde&fecha_hasta=$hasta ";

//echo $where;
//exit;
$sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,u.fecha_nac,u.nombre,
SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, 
c.created_at,c.estatus
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
INNER JOIN seguros s ON s.id = dc.seguro_id INNER JOIN usuarios u ON u.id = c.paciente_id
WHERE $where GROUP BY c.id");


ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/bootstrap/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/bootstrap/dist/css/bootstrap.min.css">
  <title>Reporte de Comprobantes</title>
</head>

<body>

  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h5 class="text-center">Datos Pacientes</h5>
          <div class="table-responsive">
            <table id="tabla_Usuario" class="table table-bordered table-condensed" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25); font-size: 10px;">
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
    <!---------------------Tabla de gatos apara el reporte de rendicion----------------------------------->
    <?php if($valor === 'DIAX'){?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="titulos col-md-2">
            <h5>Gastos Diarios</h5>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">ID</th>
                  <th>Fecha</th>
                  <th>Descripcion</th>
                  <th>Monto</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // $fecha1 = "05-01-2023";
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.created_at  FROM gastos g 
               where  g.created_at like '%" . $fecha . "%' and g.estatus = 1");

                $resultado = mysqli_num_rows($sql);
                $gasto = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $gasto += (int)$data['monto'];

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>
                      <td><?php echo $data['descripcion']; ?></td>
                      <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                    </tr>


                <?php }
                } ?>
              </tbody>
              <tr>
                <td><b>Total A Gastos : </b></td>
                <td></td>
                <td></td>
                
                <td class="alert alert-success text-center">
                  <?php echo number_format($gasto, 0, '.', '.'); ?>.<b>GS</b>
                </td>


              </tr>
            </table>
            <section>
              <?php
              $totalDiario = $total - $descuento;
              $rendicion = $totalDiario - $gasto;

              ?>
              <p>Rencion Final</p>
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($rendicion, 0, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>
    <?php }?>
  </main>
</body>

</html>
<?php
$html = ob_get_clean();
//echo $html;

require_once "../Library/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

//$dompdf->setPaper('letter');
$dompdf->setPaper('a4', 'portrait');



$dompdf->render();
$dompdf->stream('reporte-Comprobante.pdf', array('Attachment' => false));

?>