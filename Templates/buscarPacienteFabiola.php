<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 5) {
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
                        <form action="../Data/BuscarPacienteFabiola.php" method="POST">
                            <div class="form-group">
                                <label class="control-label">Busqueda del Paciente <i class="typcn typcn-user"></i></label>
                                <input class="form-control" type="text" name="id" id="id" placeholder="Ingrese el id deL Registro">
                            </div>
                   
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Comenzar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Historial/PendientesAsignacion.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
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
        <script src="../assets/js/Usuarios/usuario.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('#btnEditarPass').click(function() {
                    /* Act on the event */
                    EliminarUsuario();
                });
            });
        </script>
        <!--Srcip para vaildar el boton de Usuarios-->
        <script>
            function permisoAuto() {
                Swal.fire({
                    /*toast: true,*/
                    position: 'center',
                    title: 'Mensaje del Sistema !',
                    text: 'No posee el permiso para eliminar un Usuario',
                    footer: 'Contactar con el administrador del sistema!',
                    imageUrl: '../assets/images/logo.png',
                    imageWidth: 300,
                    imageHeight: 200,
                    imageAlt: 'Custom image',
                    showConfirmButton: false,
                    timer: 5000,

                })
            }
        </script>