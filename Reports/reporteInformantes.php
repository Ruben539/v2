<?php
session_start();
require_once("../Models/conexion.php");
if ($_POST['fecha_desde'] && $_POST['fecha_hasta'] && $_POST['medico']) {

    $desde     = $_POST['fecha_desde'] . ' 00:00:00';
    $hasta     = $_POST['fecha_hasta'] . ' 23:00:00';
    $doctor_id = $_POST['medico'];

    $query_consulta =  mysqli_query($conection, "SELECT c.ruc, c.razon_social, c.created_at,dc.descripcion as estudio,
    dc.monto,dc.monto_seguro,dc.descuento,dc.nro_radiografias,fp.descripcion as forma_pago,s.descripcion as seguro,dc.pago_diferido,
    IF(c.estatus = 1 || dc.monto_seguro < 0, dc.monto - 10000, 0) as monto,
    IF(c.estatus = 1, dc.descuento, 0) as descuento,m.nombre as medico
    FROM detalle_comprobantes dc INNER JOIN comprobantes c ON c.id =  dc.comprobante_id
    INNER JOIN medicos m ON m.id = c.informante_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
    INNER JOIN seguros s ON s.id = dc.seguro_id 
    WHERE c.informante_id = $doctor_id AND c.created_at BETWEEN '$desde' AND '$hasta' AND c.estatus = 1");
}



ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/sistemadiax/bootstrap/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/v2/bootstrap/dist/css/bootstrap.min.css">
    <title>Reporte de Informantes</title>
</head>

<body>
    <main class="app-content">
        <div class="col-md-12">
            <div class="tile">
                <h5 class="text-center">Datos de la Rendición</h5>
                <div class="table-responsive">
                    <div>
                        <p>Fecha : <?php echo  $desde; ?></p>
                        <p>Hasta : <?php echo  $hasta; ?></p>
                       
                        <hr>
                    </div>
                    <table id="tabla_Usuario" class="table table-bordered table-condensed" style="font-size: 12px; margin-left: -35px;">
                        <thead>
                            <tr class="text-center" style="font-size: 12px;font-weight: bold;">
                                <th>Nro </th>
                                <th>Fecha</th>
                                <th>Ruc </th>
                                <th>Razon Social</th>
                                <th>Estudio</th>
                                <th>Doctor</th>
                                <th>Monto</th>
                                <th>Monto Seguro</th>
                                <th>Descuento</th>
                                <th>Monto Cobrado</th>
                                <th>Forma de Pago</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 10px;">
                            <?php
                            $monto     = 0;
                            $descuento = 0;
                            $nro       = 0;

                            while ($data = mysqli_fetch_array($query_consulta)) {
                                $nro++;
                                $monto     += $data['monto'];
                                $descuento += $data['descuento'];

                            ?>
                                <tr>
                                    <td><?php echo $nro; ?></td>
                                    <td><?php echo $data['created_at']; ?></td>
                                    <td><?php echo $data['ruc']; ?></td>
                                    <td><?php echo $data['razon_social']; ?></td>
                                    <td><?php echo $data['estudio']; ?></td>
                                    <td><?php echo $data['medico']; ?></td>
                                    <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                                    <td><?php echo number_format($data['monto_seguro'],0,'.','.'); ?></td>
                                    <td><?php echo number_format($data['descuento'],0,'.','.');?></td>
                                    <td><?php echo number_format($data['monto'] - $data['descuento'],0,'.','.'); ?></td>
                                    <td><?php echo $data['forma_pago']; ?></td>
                                </tr>


                            <?php } ?>
                        </tbody>
                    </table>
                    <section>
                        <p>Total a Cobrar : </p>
                        <p class="alert alert-success text-right"><?php echo number_format($monto,0,'.','.')?>.GS</p>
                    </section>
                </div>
            </div>
        </div>
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
$dompdf->stream('reporte-informantes.pdf', array('Attachment' => false));

?>