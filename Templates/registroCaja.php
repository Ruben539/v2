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


//Recuperacion de datos para mostrar al seleccionar Actualizar

if (empty($_REQUEST['id'])) {
    header('location: ../Templates/especialidades.php');

    //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php

}

$id = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT  DISTINCT(c.id),c.ruc,dc.id as idDetalle, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor,dc.cobertura,s.descripcion as seguro,c.comentario, c.created_at
FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
INNER JOIN medicos m ON m.id = c.doctor_id 
INNER JOIN seguros s ON s.id = dc.seguro_id
WHERE  c.estatus = 3 GROUP BY c.id  ORDER BY  c.id ASC");

//mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {
    header("location: ../Templates/pendientesACobrar.php");
} else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $id            = $data['id'];
        $idDetalle     = $data['idDetalle'];
        $ruc           = $data['ruc'];
        $razon_social  = $data['razon_social'];
        $doctor        = $data['doctor'];
        $estudio       = $data['estudio'];
        $seguro        = $data['seguro'];
        $cobertura     = $data['cobertura'];
    }
}

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class=" shadow-primary border-radius-lg pt-1 pb-1">
                            <h4 class="text-black text-capitalize ps-4 text-center">Finalizar Carga</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-------------------------------------INICIO DEL FORMULARIO------------------------------------------------------------------->
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Datos del la Orden</h2>
                        <hr>
                        <p class="card-description">
                            <b>N° de Cedula :</b> <?= $ruc; ?>
                        </p>
                        <p class="card-description">
                            <b>Nombre del Paciente :</b> <?= $razon_social; ?>
                        </p>
                        <p class="card-description">
                            <b>Doctor :</b> <?= $doctor; ?>
                        </p>
                        <p class="card-description">
                            <b>Estudio a Realizar :</b> <?= $estudio; ?>
                        </p>
                        <p class="card-description">
                            <b>Seguro :</b> <?= $seguro; ?>
                        </p>
                        <?php if ($cobertura == 2) { ?>
                            <p class="card-description"><b>Cobertura :</b> Completa</p>

                        <?php } else { ?>
                            <p class="card-description">Cobertura : Preferencial</p>
                        <?php } ?>
                        <hr>
                        <form class="forms-sample" action="facturacionFinal.php" method="POST">
                        <input type="hidden" name="idDetalle" id="idDetalle" value="<?php echo $idDetalle; ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                            <div class="form-group">
                                <label for="forma_pago_id">Forma de Pago</label>
                                <select class="chosen form-control" name="forma_pago_id" id="forma_pago_id" required data-placeholder="Seleccione la forma de Pago">
                                    <option value=""></option>
                                    <?php
                                    $raw_results4 = mysqli_query($conection, "select * from forma_pagos where estatus = 1") or die(mysqli_error($conection));
                                    while ($results = mysqli_fetch_array($raw_results4)) {
                                    ?>

                                        <option value=" <?php echo $results['id'] ?> ">
                                            <?php echo $results['descripcion']; ?>
                                        </option>

                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            

                           
                            <button type="submit" class="btn btn-primary mr-2">Finalizar</button>
                            <button class="btn btn-light">Cancelar</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
        <!-------------------------------------INICIO DEL FORMULARIO------------------------------------------------------------------->
        <?php include('../includes/footer_admin.php'); ?>

        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
        <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
        <script src="../node_modules/chosen-js/chosen.jquery.js"></script>
        <script>
            $(document).ready(function() {
                $(".chosen").chosen();
            });
        </script>
      
           