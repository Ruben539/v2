<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 ) {
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

                        <h4>Medicos del Sistema a Eliminar</h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr><th>ID</th>
                                        <th>Cedula</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Nro de Telefono</th>
                                        <th>Fecha Nacimiento</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = mysqli_query($conection, "SELECT m.id,m.nombre,m.usuario,m.correo,m.cedula,m.fecha_nac,m.telefono FROM medicos m 
                                        WHERE m.estatus = 2 ORDER BY  m.id DESC");
                                   
                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr class="text-center">

                                                 <td><?php echo $data['id']; ?></td>
                                                 <td><?php echo $data['cedula']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['usuario']; ?></td>
                                                <td><?php echo $data['correo']; ?></td>
                                                <td><?php echo $data['telefono']; ?></td>
                                                <td><?php echo $data['fecha_nac'] ?></td>

                                                <td>
                                                    <button class="btn btn-outline-danger" onclick="darBajaDoctor('<?php echo $data['id'] ?>')"><i class="typcn typcn-user-delete" aria-hidden="true"></i></button>

                                                </td>
                                            </tr>


                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
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
            <script src="../assets/js/Medicos/medicos.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnEditarPass').click(function() {
                        /* Act on the event */
                        darBajaDoctor();
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
                        text: 'No posee el permiso para eliminar un Medico',
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

