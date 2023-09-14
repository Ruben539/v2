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
                <div class="col-md-12 grid-margin stretch-card">
                                <div class="col-md-6">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="" id="pdf">
                                            PDF
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="" id="excel">
                                            EXCEL
                                        </label>
                                    </div>
                                </div>
                                
                            </div>
  
                            <div class="card-body" id="formPDF" style="display: none;">
                        <form class="row" method="POST" action="../Reports/reporteMedicoPDF.php" target="_blank" >
                            <div class="col-md-6">
                                <div class="widget-small">
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 pb-3">
                                <div class="widget-small">
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="widget-small">
                                <select class="chosen form-control" name="medico" id="medico" required data-placeholder="Seleccione un Medico">
                                            <option value=""></option>
                                            <?php
                                            $raw_results4 = mysqli_query($conection, "select * from medicos;") or die(mysqli_error($conection));
                                            while ($results = mysqli_fetch_array($raw_results4)) {
                                            ?>

                                                <option value=" <?php echo $results['Nombre'] ?> ">
                                                    <?php echo $results['Nombre']; ?>
                                                </option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-2">

                                <button class="btn btn-danger" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>PDF

                            </div>
                        </form>
                    </div>


                    <div class="card-body" id="formExcel">
                        <form class="row" method="POST" action="../Reports/reporteMedicoExcel.php" target="_blank" >
                            <div class="col-md-6">
                                <div class="widget-small">
                                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 pb-3">
                                <div class="widget-small">
                                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="widget-small">
                                <select class="chosen form-control" name="medico" id="medico" required data-placeholder="Seleccione un Medico">
                                            <option value=""></option>
                                            <?php
                                            $raw_results4 = mysqli_query($conection, "select * from medicos;") or die(mysqli_error($conection));
                                            while ($results = mysqli_fetch_array($raw_results4)) {
                                            ?>

                                                <option value=" <?php echo $results['Nombre'] ?> ">
                                                    <?php echo $results['Nombre']; ?>
                                                </option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-2">

                                <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>Excel

                            </div>
                        </form>
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
        <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
        <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../node_modules/chosen-js/chosen.jquery.js"></script>
        <script>
           
                $(document).ready(function() {
                $(".chosen").chosen();
                
            });
            
           
        </script>

        <script type='text/javascript'>
           
           const pdf = document.getElementById('pdf');
            const excel = document.getElementById('excel');

            document.getElementById('formPDF').style.display = 'block';
            document.getElementById('formExcel').style.display = 'block';
           

            //pdf.checked = true;

            pdf.addEventListener('click', (e) => {
                
                excel.checked = false;
                if (e.target.checked) {
                  //  alert('Has seleccionado PDF');
                    
                    document.getElementById('formExcel').style.display = 'none';
                    document.getElementById('formPDF').style.display = 'block';
                   // document.getElementById('inptudNombre').value = '';
                }
            })

            excel.addEventListener('click', (e) => {
                
                pdf.checked = false;
                if (e.target.checked) {
                   // alert('Has seleccionado Excel');
                   
                    document.getElementById('formPDF').style.display = 'none';
                    document.getElementById('formExcel').style.display = 'block';
                   // document.getElementById('inptudNombre').value = '';
                }
            })

        </script>
       