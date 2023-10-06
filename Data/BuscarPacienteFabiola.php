<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
    if (empty($_SESSION['active'])) {
        header('location: ../Templates/salir.php');
    }
} else {
    header('location: ../Templates/salir.php');
}

require_once('../Models/conexion.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class=" shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-black text-capitalize ps-3 text-center">Resultado de la Busqueda :</h5>
                        </div>

                    </div>
                    <div class="card-body">
                    <?php
                $query = $_POST['id'];
                $min_length = 1;
                if (strlen($query) >= $min_length) { // if query length is more or equal minimum length then
                    $query = htmlspecialchars($query);
                    // $query = mysqli_real_escape_string($query);
                    $raw_results = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at
                    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                    INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                    INNER JOIN seguros s ON s.id = dc.seguro_id
                    WHERE c.paciente_id = '".$query."' AND c.estatus = 1 AND c.informante_id is NULL GROUP BY c.id  ORDER BY  c.id ASC") or die(mysqli_error($conection));
                    #WHERE (`Cedula` LIKE '%".$query."%')") or die(mysql_error());
                    echo "<div class='bs-component'>";
                    echo "<div class='card'>";
                    echo "<h3 class='card-header text-center alert alert-info'>Datos del Paciente <i class='fa fa-user'></i></h3>";
                    if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following
                        while ($results = mysqli_fetch_array($raw_results)) {
                            echo '<div class="card-body">';
                            echo '<div class="row align-items-center h-100">';
                              echo '<div class="col-md-4">';
                                echo '<figure class="avatar mx-auto mb-4 mb-md-0">';
                                  echo '<img src="../assets/images/logo.png" alt="avatar" style="width:150px;
                                  height:150px;
                                  border-radius: 100%;
                                  border: 1px solid white;
                                  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.3), 0 3px 10px  rgba(0, 0, 0, 0.25)
                                  ">';
                                echo '</figure>';
                              echo '</div>';
                              echo '<div class="col-md-8">';
                                echo '<h5 class="text-black text-center text-md-left">CI: ' . $results['ruc'] . '</h5>';
                                echo '<p class="text-black text-center text-md-left">Nombre: '. $results['razon_social'] .'</p>';
                                echo '<div class="d-flex align-items-center justify-content-between info pt-2">';
                                  echo '<div>';
                                    echo '<p class="text-black font-weight-bold">Doctor/a : ' . $results['doctor'] . '</p>';
                                    echo '<p class="text-black font-weight-bold">ID : '. $results['id'] .'</p>';
                                  echo '</div>';

                                  echo '<div>';
                                    echo '<p class="text-black">
                                    <a href="../View/asignarInformanteFabiola.php?id='. $results['id'].' " class="btn btn-outline-primary" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25)"><i class="fa fa-user-md"></i> Asingar Informante</a>
                                    </p>';
                                   
                                  echo '</div>';
                                echo '</div>';
                              echo '</div>';
                            echo '</div>';
                         echo '</div>'; 
                         echo '<hr>';
                           
                        }
                    } else { // if there is no matching rows do following
                        echo "No results";
                    }
                } else { // if query length is less than minimum
                    echo "Minimum length is " . $min_length;
                }
                ?>
                    </div>

                </div>
            </div>
        </div>

        <?php include('../includes/footer_admin.php'); ?>

        <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
        <script src="../assets/js/sweetalert2.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <!-- echo "<p><h4>CI: " . $results['ruc'] . "</h4></p>";
                            echo "<p><h4>Nombre: " . $results['razon_social'] . "</h4></p>";
                            echo "<p><h4>Doctor : " . $results['doctor'] . "</h4></p>";
                            $nombre = $results['razon_social'];
                            echo "</div>";
                            echo'<p>
                                echo '<td>
                                     <a href="../View/asignarInformanteElena.php?id='. $results['id'].' " class="btn btn-outline-primary" target="_blank"><i class="fa fa-user-md"></i> Asingar Informante</a></td>
                                </td></p>';
                            echo "</div>"; -->