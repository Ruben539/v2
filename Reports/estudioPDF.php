<?php

session_start();
require_once("../Models/conexion.php");

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
    <title>Estudios del Sistema</title>
</head>

<body>
    <main class="app-content">
        <h2 class="text-center">Lista de Estudios</h2>
        <div class="table-responsive pt-3">
            <table class="table table-bordered" id="tabla">
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Estudio</th>
                        <th>Seguro</th>
                        <th>Normal</th>
                        <th>Hospitalario</th>
                        <th>Categoria</th>
                        <th>Pago Estudio</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = mysqli_query($conection, "SELECT e.id,e.nombre,e.seguro,e.preferencial,e.hospitalario,ce.descripcion,pem.monto
                                    FROM estudios e INNER JOIN categoria_estudio ce ON ce.id = e.categoria_id
                                    LEFT JOIN pago_estudio_medicos pem ON pem.estudio_id = e.id 
                                    WHERE e.estatus = 1 ORDER BY e.id DESC");

                    $resultado = mysqli_num_rows($sql);

                    if ($resultado > 0) {
                        while ($ver = mysqli_fetch_array($sql)) {
                            $datos = $ver[0] . "||" .
                                $ver[1] . "||" .
                                $ver[2] . "||" .
                                $ver[3] . "||" .
                                $ver[4] . "||" .
                                $ver[5] . "||" .
                                $ver[6];

                    ?>
                            <tr class="text-center">

                                <td><?= $ver[0]; ?></td>
                                <td><?= $ver[1]; ?></td>
                                <td><?= number_format($ver[2], 0, '.', '.'); ?></td>
                                <td><?= number_format($ver[3], 0, '.', '.'); ?></td>
                                <td><?= number_format($ver[4], 0, '.', '.'); ?></td>
                                <td><?= $ver[5]; ?></td>
                                <td><?= number_format($ver[6], 0, '.', '.'); ?></td>

                            </tr>


                    <?php }
                    } ?>
                </tbody>
            </table>
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
$dompdf->stream('estudios.pdf', array('Attachment' => false));

?>