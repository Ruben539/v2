<?php

// print_r($_POST);
// exit();
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
    if (empty($_SESSION['active'])) {
        header('location: salir.php');
    }
} else {
    header('location: salir.php');
}

require_once('../Models/conexion.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class=" shadow-primary border-radius-lg pt-1 pb-1">
                            <h4 class="text-black text-capitalize ps-4 text-center">Registro de la Orden</h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php
//Datos para el detalle del paciente
            $fecha_nac   = $_POST['fecha']; 

//Item o valores para la tabla de comprobantes
            $id          = $_POST['id'];
            $ci          = $_POST['cedula'];
            $nombre      = $_POST['nombre'];    
            $doctor_id   = $_POST['doctor_id'];
            $comentario  = $_POST['comentario'];
           

//Item o valores para la tabla del detalle de comprobantes
            $descuento        = $_POST['descuento'];
            $seguro_id        = $_POST['seguro_id'];
            $forma_pago_id    = $_POST['forma_pago_id'];
            $estudios         = $_POST['estudios'];
            $nro_rayos        = $_POST['nro_rayos'];



            ?>
            <!-------------------------------------INICIO DEL FORMULARIO------------------------------------------------------------------->
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Detalle de la Orden</h2>
                        <p class="card-description">
                            Cedula : <code><?= $ci ?></code>
                        </p>
                        <p class="card-description">
                            Nombre : <code><?= $nombre ?></code>
                        </p>
                        <p class="card-description">
                            Fecha Nac. : <code><?= $fecha_nac ?></code>
                        </p>
                        

                        <div class="table-responsive pt-3">


                            <?php
                            echo "<form action='facturacion.php' method='post'>";
                            echo "<input type='hidden' name='ruc' value=" . $ci . ">";
                            echo "<input type='hidden' name='razon_social' value='" . $nombre . "'>";
                            echo "<input type='hidden' name='paciente_id' value='" . $id . "'>";
                            echo "<input type='hidden' name='doctor_id' value='" . $doctor_id . "'>";
                            echo "<input type='hidden' name='comentario' value='" . $comentario . "'>";
                           // echo "<input type='hidden' name='estudios[]' value='" . $estudios . "'>";
                          
                           // echo "<input type='hidden' name='estudios[]' value='" . $estudios . "'>";
                            $total = 0;
                            $estudio = '';
                            $monto = 0;
                            $items = '';
                            for ($i = 0; $i < count($estudios); $i++) {
                                $estudio =  $estudios[$i];
                        
                                echo "<table class='table table-bordered'>";
                                echo "<tbody>";
                                echo "<input type='hidden' name='estudios[]' value='" .trim($estudios[$i]). "'>";
                                $raw_results2 = mysqli_query($conection, "select id, nombre, seguro from estudios where id='" . trim($estudios[$i]) . "';") or die(mysqli_error($conection));
                                while ($results = mysqli_fetch_array($raw_results2)) {
                                    $monto +=  $results['seguro'];
                                    echo "<tr><td>Estudio: ".$results['nombre']." </td><td align='right'>";
                                   // echo "<input type='hidden' name='estudio_id[]' value='" .$results['id']. "'>";
                                   // echo "<input type='hidden' name='descripcion[]' value='" .$results['nombre']. "'>";
                                    //echo "<input type='hidden' name='monto[]' value='" .$results['seguro']. "'>";
                                    echo  number_format($results['seguro'], 0, '.', '.'). "</td></tr>";
                                    if ($results['nombre'] == 'Radiografias') {
                                        $total = $results['seguro'] * $nro_rayos;
                                    }else{
                                        $total +=  (int)$results['seguro'];
                                    }
                                    
                                }
                            }
                        
                            $total = $total - $descuento;
                            $total = number_format($total, 0, '.', '.');
                            if ($nro_rayos > 0) {

                                echo "<tr><td>Rayos X Numero de Posiciones:</td><td align='right'>" . $nro_rayos . "</td></tr>";
                                #$estudio=$estudio." Numero de Posiciones Rayos X: ". $rayosx. ".";
                            }
                            echo "<tr><td><b><i>Descuento:</td><td align='right'><b><i>" . number_format($descuento, 0, '.', '.')  . "</td></tr>";
                            echo "<tr><td><b><i>Total a Cobrar:</td><td align='right'><b><i>" . $total . "</td></tr>";
                            echo "</tbody>";
                            echo "</table>";
                            echo "<input type='hidden' name='seguro_id' value=" . $seguro_id . ">";
                            echo "<input type='hidden' name='forma_pago_id' value='" . $forma_pago_id . "'>";
                            echo "<input type='hidden' name='descuento' value='" . $descuento . "'>";
                            echo "<table class='table'><tr><td><input class='btn btn-primary' type='submit' value='Guardar'>&nbsp;&nbsp;&nbsp;<a class='btn btn-secondary' href='../Templates/orden.php'><i class='fa fa-fw fa-lg fa-times-circle'></i>Cancelar</a></td></tr></table>";
                            echo "</form>";
                            ?>
                        </div>
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