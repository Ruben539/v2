<?php
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

                        <div class=" shadow-primary border-radius-lg pt-4 pb-3">
                            <h5 class="text-black text-capitalize ps-3">Buscar Cliente :</h5>
                        </div>

                    </div>
                    <div class="card-body">
                        <form method="POST" id='formPacientes' name='formPacientes'>
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="col-md-6">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="" id="cedula">
                                            Cedula
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="" id="nombre">
                                            Nombre
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="input-group input-group-outline mb-3"  id="carcedula">
                                <label class="form-label"></label>
                                <input type="text" class="form-control" placeholder="Ingrese la cedula del Paciente" id="inputCedula" name="inputCedula">
                            </div>

                            <div class="input-group input-group-outline mb-3" id="carnombre">
                                <label class="form-label"></label>
                                <input type="text" class="form-control" placeholder="Ingrese el nombre del Paciente" id="inptudNombre" name="inptudNombre">
                            </div>
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="table-responsive" id="tablaResultado">



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
        <script type="text/javascript">
            let cedula = document.getElementById('cedula');
            let nombre = document.getElementById('nombre');

            cedula.checked = true;
            document.getElementById('inputCedula').style.display = 'block';
            document.getElementById('inptudNombre').style.display = 'none';

            cedula.addEventListener('click', (e) => {
                nombre.checked = false;
                if (e.target.checked) {

                    document.getElementById('inptudNombre').style.display = 'none';
                    document.getElementById('inputCedula').style.display = 'block';
                    document.getElementById('inptudNombre').value = '';
                }
            })

            nombre.addEventListener('click', (e) => {
                cedula.checked = false;
                if (e.target.checked) {

                    document.getElementById('inptudNombre').style.display = 'block';
                    document.getElementById('inputCedula').style.display = 'none';
                    document.getElementById('inputCedula').value = '';
                }
            })
        </script>

        <script type="text/javascript">
            $('#formPacientes').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: '../Data/BuscarPacientes.php',
                    data: form.serialize(),
                    success: function(data) {
                        $('#tablaResultado').html('');
                        $('#tablaResultado').append(data);
                        console.log(data);
                    }

                });

            });
        </script>