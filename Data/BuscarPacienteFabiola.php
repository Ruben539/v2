<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 5) {
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
                    $raw_results = mysqli_query($conection, "SELECT h.id,h.Cedula,c.Nombre,c.Apellido,c.Celular,c.Nacimiento FROM historial h INNER JOIN clientes c on c.cedula = h.cedula
                     WHERE h.id = $query") or die(mysqli_error($conection));
                    #WHERE (`Cedula` LIKE '%".$query."%')") or die(mysql_error());
                    echo "<div class='bs-component'>";
                    echo "<div class='card'>";
                    echo "<h3 class='card-header text-center alert alert-info'>Datos del Paciente <i class='fa fa-user'></i></h3>";
                    echo "<legend >Datos del Paciente :</legend>";
                    if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following

                        while ($results = mysqli_fetch_array($raw_results)) {
                           
                            echo "<p><h4>CI: " . $results['Cedula'] . "</h4></p>";
                            echo "<p><h4>Nombre: " . $results['Nombre'] . " " . $results['Apellido'] . "</h4></p>";
                            echo "<p><h4>Celular: " . $results['Celular'] . "</h4></p>";
                            $nombre = $results['Nombre'] . " " . $results['Apellido'];
                            $nacimiento = $results['Nacimiento'];
                            echo "</div>";
                            echo'<p>
                                <td>
                                     <a href="../View/asignarInformanteElena.php?id='. $results['id'].' " class="btn btn-outline-primary" target="_blank"><i class="fa fa-user-md"></i> Asingar Informante</a></td>
                                </td></p>';
                            echo "</div>";
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
    