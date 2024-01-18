<?php
session_start();
require_once("../Models/conexion.php");
if ($_POST['fecha_desde'] && $_POST['fecha_hasta'] && $_POST['medico']) {

    $desde     = $_POST['fecha_desde'] . ' 00:00:00';
    $hasta     = $_POST['fecha_hasta'] . ' 23:00:00';
    $doctor_id = $_POST['medico'];

    $query_consulta =  mysqli_query($conection, "SELECT cm.ruc,cm.razon_social,e.nombre AS estudio,cm.monto,cm.monto_seguro,
    cm.descuento,cm.monto_cobrado,fp.descripcion AS formaPago,ed.descripcion AS estado,cm.created_at,m.nombre AS medico
    FROM consulta_medicos cm INNER JOIN estudios e ON e.id = cm.estudio_id
    INNER JOIN medicos m ON m.id = cm.doctor_id INNER JOIN forma_pagos fp ON fp.id = cm.forma_pago_id
    INNER JOIN estado_deuda ed ON ed.id = cm.estado_deuda_id
    WHERE cm.doctor_id = $doctor_id AND cm.created_at BETWEEN '$desde' AND '$hasta' AND cm.estatus = 1");

    if($query_consulta){
        
        $query_monto = mysqli_query($conection,"SELECT m.nombre AS medico, e.nombre AS estudio, sm.monto, sm.monto_diax, sm.monto_doctor, ed.descripcion AS estado, sm.created_at
        FROM servicio_medicos sm INNER JOIN estudios e ON e.id = sm.estudio_id
        INNER JOIN medicos m ON m.id = sm.doctor_id INNER JOIN estado_deuda ed ON ed.id = sm.estado_deuda_id
        WHERE sm.doctor_id = $doctor_id AND sm.created_at BETWEEN '$desde' AND '$hasta' AND sm.estatus = 1");

    }

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
    <title>Reporte Consulta Medicos</title>
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
                    <table id="tabla_Usuario" class="table table-bordered table-condensed text-center" style="font-size: 12px; margin-left: -35px;">
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
                                $monto     += $data['monto_cobrado'];
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
                                    <td><?php echo number_format($data['descuento'],0,'.','.'); ?></td>
                                    <td><?php echo number_format($data['monto_cobrado'],0,'.','.'); ?></td>
                                    <td><?php echo $data['formaPago']; ?></td>
                                </tr>


                            <?php } ?>
                        </tbody>
                    </table>
                    <section>
                        <p>Total a Cobrar : </p>
                        <p class="alert alert-success text-right"><?php echo number_format($monto - $descuento,0,'.','.')?>.GS</p>
                    </section>
                </div>
                <table class="table table-bordered table-condensed text-center" style="font-size: 12px; margin-left: -35px;">
                    <thead>
                    <tr class="text-center" style="font-size: 12px;font-weight: bold;">      
                        <th>Estudio</th>
                        <th>Monto</th>
                        <th>Monto Diax</th>
                        <th>Monto Medico</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $montoEstudio = 0;
                        $montoDiax    = 0;
                        $montoMedico  = 0;

                        while($data = mysqli_fetch_array($query_monto)){
                            $montoEstudio += $data['monto']; 
                            $montoDiax    += $data['monto_diax']; 
                            $montoMedico  += $data['monto_doctor']; 
                                                
                        ?>
                        <tr>
                            <td><?php echo $data['estudio']; ?></td>
                            <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                            <td><?php echo number_format($data['monto_diax'],0,'.','.'); ?></td>
                            <td><?php echo number_format($data['monto_doctor'],0,'.','.'); ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
                <table class="table table-bordered table-condensed text-center" style="font-size: 12px; margin-left: -35px;">
                    <thead>
                        <tr class="text-center" style="font-size: 12px;font-weight: bold;">
                            <th>Monto Total</th>
                            <th>Monto Diax</th>
                            <th>Monto Medico</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo number_format($montoEstudio,0,'.','.'); ?></td>
                            <td><?php echo number_format($montoDiax,0,'.','.'); ?></td>
                            <td><?php echo number_format($montoMedico,0,'.','.'); ?></td>
                        </tr>
                    </tbody>
                </table>
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
$dompdf->stream('reporte-medicos.pdf', array('Attachment' => false));

?>