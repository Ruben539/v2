<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    if (empty($_SESSION['active'])) {
        header('location: salir.php');
    }
} else {
    header('location: salir.php');
}

require_once('../Models/conexion.php');

$fecha_desde = '';
$fecha_hasta  = '';
date_default_timezone_set('America/Asuncion');
$fecha =  date('Y-m');


if (empty($_POST['fecha_desde']) && empty($_POST['fecha_hasta'])) {


    $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,c.monto,c.concepto,c.usuario,c.created_at,c.proveedor,c.foto
    FROM empresa_movimientos c where c.created_at like '%" . $fecha . "%'  AND c.estatus = 1 ");
} else {

    $fecha_desde = $_POST['fecha_desde'];
    $fecha_hasta  = $_POST['fecha_hasta'];
    // exit();

    $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,c.monto,c.concepto,c.usuario,c.created_at,c.proveedor,c.foto
    FROM empresa_movimientos c where c.created_at BETWEEN '$fecha_desde' AND '$fecha_hasta' AND c.estatus = 1");
}



$resultado = mysqli_num_rows($sql);

require_once('../Modals/modalImageComprobante.php');
$query = mysqli_query($conection, "SELECT id,monto FROM caja_chica  WHERE estatus = 1 ");

$resultado = mysqli_num_rows($query);


if ($resultado > 0) {

    $total     = 0;

    while($data  = mysqli_fetch_array($query)){
        $id         = $data['id'];
        $montoCaja  = $data['monto'];
    }
}
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 >Movimientos Financieros <a href="../View/agregarMovientos.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> 
                        Registrar</a>
                        <a href="../View/agregarCajaChica.php" class="btn btn-outline-success"><i class="typcn typcn-archive"></i></a>
                        <a>Monto Caja: <span><?= number_format($montoCaja,0,'.','.');?> GS</span></a>

                        </h4>
                        
                        <form class="row" method="POST" id='formFechas' name='formFechas'>
                            <div class="col-md-5">
                                <div class="widget-small">
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="widget-small">
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">

                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>Filtrar

                            </div>
                    </div>
                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="table-responsive">
                                    <table id="tabla" class="table table-striped table-bordered table-condensed" style="width:100%">
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
                                        <tbody class="text-center">
                                            <?php

                                            $monto = 0;
                                            $nro = 0;
                                            while ($data = mysqli_fetch_array($sql)) {
                                                $monto += (int)$data['monto'];
                                                $nro++;

                                                if ($data['foto'] != 'img_comprobante.png') {
                                                    $foto = '../Images/Comprobantes/'.$data['foto'];
                                                   
                                                  }else{
                                                    $foto = '../Images/'.$data['foto'];
                                                   
                                                  } 

                                                $datos = $data[0]."||".
                                                $data[1]."||".
                                                $data[2]."||".
                                                $data[3]."||".
                                                $data[4]."||".
                                                $data[5]."||".
                                                $data[6]."||".
                                                $data[7]."||".
                                                $data[8]."||".
                                                $data[9];

                                            ?>
                                                <tr>
                                                    <td><?php echo $nro; ?></td>
                                                    <td><?php echo $data['created_at']; ?></td>
                                                    <td><?php echo $data['forma_pago']; ?></td>
                                                    <td><?php echo $data['nro_cheque']; ?></td>
                                                    <td><?php echo $data['tipo_salida']; ?></td>
                                                    <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                                                    <td><?php echo $data['concepto']; ?></td>
                                                    <td><?php echo $data['usuario']; ?></td>
                                                    <td>
                                                        <button class="btn btn-success"  onclick="mostrarImgenComprobante('<?php echo $datos; ?>')">
                                                            <i class="typcn typcn-eye-outline"></i></button>
                                                    </td>
                                                    <td>
                                                        <a href="../View/modificarMovimiento.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-info"><i class="typcn typcn-edit"></i></a>
                                                    </td>

                                                    <td>
                                                    <a href="../View/cancelarMovimientos.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-danger"><i class="typcn typcn-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>





        <?php include('../includes/footer_admin.php'); ?>

        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
        <script src="../assets/js/Comprobantes/comprobantes.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('#btnEditarPass').click(function() {
                    /* Act on the event */
                    EliminarGasto();
                });
            });
        </script>
        <script type="text/javascript">
            $('#formFechas').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: '../Data/BuscarMovimientos.php',
                    data: form.serialize(),
                    success: function(data) {
                        $('#tablaResultado').html('');
                        $('#tablaResultado').append(data);
                    }

                });

            });
        </script>