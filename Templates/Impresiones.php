<?php

require_once("../Models/conexion.php");
require_once("../includes/header_admin.php");


date_default_timezone_set('America/Asuncion');
$id =  $_REQUEST['id'];
 $hoy =  date('Y-m-d');

$sql = mysqli_query($conection, "SELECT c.id FROM comprobantes c WHERE  c.id = '".$id."' ");


$resultado = mysqli_num_rows($sql);

if ($resultado == 0) {

 // header("location: ./dashboard.php");
} else {
  $option = '';
  while ($data = mysqli_fetch_array($sql)) {

    $id   = $data['id'];
  }
}

//echo $id;

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class=" shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-black text-capitalize ps-3 text-center">Impresiones de Comprobantes</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                                            <div>
                                                <p class="mb-2 text-md-center text-lg-left">Recibo</p>
                                                <hr>
                                                <h3 class="mb-0">Imprimir Recibo</h3>
                                            </div>
                                            <br>
                                            <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
                                        </div>
                                        <a href="../Reports/Factura.php" class="btn btn-outline-success" target="_blank">Recibo</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                                            <div>
                                                <p class="mb-2 text-md-center text-lg-left">Factura</p>
                                                <hr>
                                                <h3 class="mb-0">Imprimir Factura</h3>
                                            </div>
                                            <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
                                        </div>
                                        <a href="../Reports/Recibo.php" class="btn btn-outline-danger" target="_blank">Factura</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                                            <div>
                                                <p class="mb-2 text-md-center text-lg-left">Comprobante</p>
                                                <hr>
                                                <h3 class="mb-0">Imprimir Reporte</h3>
                                            </div>
                                            <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
                                        </div>
                                        <form action="../Reports/Reporte.php" target="_blank">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                                            <button type="submit" class="btn btn-outline-info">Reporte</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                         
                            

                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                                            <div>
                                                <p class="mb-2 text-md-center text-lg-left">Ticket</p>
                                                <hr>
                                                <h3 class="mb-0">Imprimir Ticket</h3>
                                            </div>
                                            <i class="typcn typcn-document-text icon-xl text-secondary"></i>
                                        </div>
                                        <form action="../Tickets/ticket.php" target="_blank">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
                                            <button type="submit" class="btn btn-outline-warning">Ticket</button>
                                        </form>
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