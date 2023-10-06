<?php
require_once("../includes/header_admin.php");


require_once('../Models/conexion.php');

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4>Gastos del Sistema a Eliminar</h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Comentario</th>
                                        <th>Solicitado Por</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.usuario_1,g.created_at,g.comentario
                                       FROM gastos g  where  g.estatus = 2 ");
                                   
                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['created_at'] ?></td>
                                                <td><?php echo $data['descripcion']; ?></td>
                                                <td><?php echo $data['monto']; ?></td>
                                                <td><?php echo $data['comentario']; ?></td>
                                                <td><?php echo $data['usuario_1']; ?></td>

                                                <td>
                                                    <button class="btn btn-outline-danger" onclick="darBajaGasto('<?php echo $data['id'] ?>')"><i class="typcn typcn-user-delete" aria-hidden="true"></i></button>

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
            <script src="../assets/js/Gastos/gasto.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnEditarPass').click(function() {
                        /* Act on the event */
                        darBajaGasto();
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

