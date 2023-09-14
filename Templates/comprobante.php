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

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class=" shadow-primary border-radius-lg pt-1 pb-1">
                            <h4 class="text-black text-capitalize ps-4 text-center">Registro de Comprobantes</h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            $id          = $_POST['id'];
            $ci          = $_POST['cedula'];
            $nombre      = $_POST['nombre'];
            $nacimiento  = $_POST['nacimiento'];
            $seguro      = $_POST['seguro'];
            $segurot     = $_POST['texto'];
            $medico      = $_POST['medico'];
            $descuento   = $_POST['descuento'];
            $comentario  = $_POST['comentario'];
            $ecografias  = $_POST['ecografias'];
            $rayosx      = $_POST['rayosx'];



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
                            Fecha Nac. : <code><?= $nacimiento ?></code>
                        </p>
                        <p class="card-description">
                            Medico Atendedor : <code><?= $medico ?></code>
                        </p>

                        <div class="table-responsive pt-3">


                            <?php
                            echo "<form action='facturacion.php' method='post'>";
                            echo "<input type='hidden' name='seguro' value=" . $seguro . ">";
                            echo "<input type='hidden' name='ci' value=" . $ci . ">";
                            echo "<input type='hidden' name='nombre' value='" . $id . "'>";
                            echo "<input type='hidden' name='medico' value='" . $medico . "'>";
                            echo "<input type='hidden' name='descuento' value='" . $descuento . "'>";
                            echo "<input type='hidden' name='comentario' value='" . $comentario . "'>";
                            $total = 0;
                            $estudio = '';
                            $results[$seguro] = 0;
                            for ($i = 0; $i < count($ecografias); $i++) {
                                $estudio = trim($estudio . $ecografias[$i]) . ".";
                                $e2 = trim($ecografias[$i]);
                                echo "<table class='table table-bordered'>";
                                echo "<tbody>";
                                echo "<tr><td>Estudios a Realizar:" . $ecografias[$i] . "</td><td align='right'>";
                                $raw_results2 = mysqli_query($conection, "select " . $seguro . " from tarifas where Estudio='" . trim($ecografias[$i]) . "';") or die(mysqli_error($conection));
                                while ($results = mysqli_fetch_array($raw_results2)) {
                                    echo $results[$seguro] . "</td></tr>";
                                    if ($e2 == 'Radiografias') {
                                        $results[$seguro] = $results[$seguro] * $rayosx;
                                    }
                                    $total = ((int)$total + (int)$results[$seguro]);
                                }
                            }

                            $total = $total - $descuento;
                            $total = number_format($total, 3, '.', '.');
                            if ($rayosx > 0) {

                                echo "<tr><td>Rayos X Numero de Posiciones:</td><td align='right'>" . $rayosx . "</td></tr>";
                                #$estudio=$estudio." Numero de Posiciones Rayos X: ". $rayosx. ".";
                            }
                            echo "<tr><td><b><i>Descuento:</td><td align='right'><b><i>" . $descuento . "</td></tr>";
                            echo "<tr><td><b><i>Total a Cobrar:</td><td align='right'><b><i>" . $total . "</td></tr>";
                            echo "</tbody>";
                            echo "</table>";
                            echo "<input type='hidden' name='estudio' value='" . $estudio . "'>";
                            echo "<input type='hidden' name='monto' value=" . $total . ">";
                            echo "<input type='hidden' name='nacimiento' value=" . $nacimiento . ">";
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