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
require_once('../Modals/modalAsignarMonto.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4>Estudios del Sistema <a href="../View/agregarEstudio.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> Registrar</a>
                        <a href="../Reports/estudioPDF.php" class="btn btn-outline-danger" target="_blank" >PDF</a></h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Estudio</th>
                                        <th>Seguro</th>
                                        <th>Normal</th>
                                        <th>Hospitalario</th>
                                        <th>Categoria</th>
                                        <th>Pago Estudio</th>
                                        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 5 ) { ?>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                            <th>Asignar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $sql = mysqli_query($conection, "SELECT e.id,e.nombre,e.seguro,e.preferencial,e.hospitalario,ce.descripcion,pem.monto
                                    FROM estudios e LEFT JOIN pago_estudio_medicos pem ON pem.estudio_id = e.id
                                    LEFT JOIN categoria_estudio ce ON ce.id = e.categoria_id
                                    WHERE e.estatus = 1 ORDER BY e.id DESC");

                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($ver = mysqli_fetch_array($sql)) {
                                            $datos = $ver[0]."||".
                                            $ver[1]."||".
                                            $ver[2]."||".
                                            $ver[3]."||".
                                            $ver[4]."||".
                                            $ver[5]."||".
                                            $ver[6];

                                    ?>
                                            <tr class="text-center">

                                                <td><?= $ver[0]; ?></td>
                                                <td><?= $ver[1]; ?></td>
                                                <td><?= number_format($ver[2],0,'.','.'); ?></td>
                                                <td><?= number_format($ver[3],0,'.','.'); ?></td>
                                                <td><?= number_format($ver[4],0,'.','.'); ?></td>
                                                <td><?= $ver[5]; ?></td>
                                                <td><?= number_format($ver[6],0,'.','.'); ?></td>
                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                                    <td>
                                                        <a href="../View/modificarEstudios.php?id=<?php echo $ver[0]; ?>" class="btn btn-outline-info" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-edit"></i></a>
                                                    </td>
                                                <?php } ?>
                                                <?php if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 5) { ?>
                                                    <td>
                                                        <a href="#" onclick="permisoEditar()" class="btn btn-outline-danger" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-trash"></i></a>
                                                    </td>
                                                <?php } ?>
                                                
                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                                <td>
                                                    <button class="btn btn-outline-danger" onclick="EliminarEstudio('<?php echo $ver[0] ?>')"><i class="typcn typcn-trash" aria-hidden="true"></i></button>

                                                </td>
                                                <?php } ?>


                                                <?php if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 5) { ?>
                                                    <td>
                                                        <a href="#" onclick="permisoEliminar()" class="btn btn-outline-danger" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-trash"></i></a>
                                                    </td>
                                                <?php } ?>

                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                                    <td>
                                                        <button href="#" data-toggle="modal" data-target="#modalEditar"  onclick="asignarMonto('<?php echo $datos; ?>')" class="btn btn-outline-warning" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);">
                                                             <i class="typcn typcn-credit-card"></i>
                                                        </button>
                                                    </td>
                                                <?php } ?>
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
            <script src="../assets/js/Estudios/estudios.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnEditarPass').click(function() {
                        /* Act on the event */
                        EliminarEstudio();
                    });

                    $('#btnAsignarMonto').click(function() {
                        /* Act on the event */
                        confirmacionMontoAsignado();
                    });
                });
            </script>
            <!--Srcip para vaildar el boton de Usuarios-->
            <script>
                function permisoEditar() {
                    Swal.fire({
                        /*toast: true,*/
                        position: 'center',
                        title: 'Mensaje del Sistema !',
                        text: 'No posee el permiso para editar un Medico',
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
            <script>
                function permisoEliminar() {
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