<?php
session_start();
require_once("../Models/conexion.php");
if ($_POST['fecha_desde'] && $_POST['fecha_hasta'] && empty($_POST['estudio'])) {


    $desde    = $_POST['fecha_desde'] . '-00:00:00';
    $hasta    = $_POST['fecha_hasta'] . '-23:00:00';

    //TODO: Consulta para traer el total de estudios por el rango seleccionado.
    $estudios = mysqli_query($conection, "SELECT COUNT(e.id) AS cantidad,SUM(dc.nro_radiografias) as nro_radiografias, e.nombre,e.id as estudio_id,
    SUM(IF(dc.nro_radiografias <> 0, (dc.monto * dc.nro_radiografias) , dc.monto)) as monto,
    SUM(IF(dc.nro_radiografias <> 0, (dc.monto_seguro * dc.nro_radiografias) , dc.monto_seguro)) as monto_seguro,
    dc.descuento
    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
    INNER JOIN estudios e ON e.id = dc.estudio_id
    WHERE  c.created_at BETWEEN '$desde' AND '$hasta'  
    AND c.estatus = 1 GROUP BY e.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($estudios);
    $nroEstudio = 0;
} else if ($_POST['fecha_desde'] && $_POST['fecha_hasta'] && !empty($_POST['estudio'])) {


    $desde    = $_POST['fecha_desde'] . '-00:00:00';
    $hasta    = $_POST['fecha_hasta'] . '-23:00:00';
    $estudio  = $_POST['estudio'];

    //TODO: Consulta para traer el total de estudios por el rango seleccionado.
    $estudios = mysqli_query($conection, "SELECT COUNT(e.id) AS cantidad,SUM(dc.nro_radiografias) as nro_radiografias, e.nombre,e.id as estudio_id,
   SUM(IF(dc.nro_radiografias <> 0, (dc.monto * dc.nro_radiografias) , dc.monto)) as monto,
   SUM(IF(dc.nro_radiografias <> 0, (dc.monto_seguro * dc.nro_radiografias) , dc.monto_seguro)) as monto_seguro,
   dc.descuento
   FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
   INNER JOIN estudios e ON e.id = dc.estudio_id
   WHERE e.id = $estudio AND  c.created_at BETWEEN '$desde' AND '$hasta'  
   AND c.estatus = 1 GROUP BY e.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($estudios);
    $nroEstudio = 0;
}


ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Estudios</title>
    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/v2/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="table-responsive pt-3">
        <table class="table table-bordered text-center" id="tabla">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Estudio</th>
                    <th>Cantidad</th>
                    <th>Nro de Posiciones</th>
                    <th>Monto Total</th>
                    <th>Monto Seguro</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado > 0) {
                    while ($data =  mysqli_fetch_array($estudios)) {
                        $nroEstudio++;

                ?>
                        <tr>
                            <td><?php echo $nroEstudio; ?></td>
                            <td><?php echo $data['nombre']; ?></td>
                            <td><?php echo $data['cantidad']; ?></td>
                            <td><?php echo $data['nro_radiografias']; ?></td>
                            <td><?php echo number_format($data['monto'] - $data['descuento'],0,'.','.'); ?></td>
                            <td><?php echo number_format($data['monto_seguro'] - $data['descuento'],0,'.','.'); ?></td>
                        </tr>
                <?php  }
                } ?>
            </tbody>
        </table>
    </div>

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
$dompdf->stream('reporte-estudios.pdf', array('Attachment' => false));

?>