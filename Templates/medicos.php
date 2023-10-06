<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 5) {
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

                        <h4>Medicos del Sistema <a href="../View/agregarMedico.php" class="btn btn-primary mr-2"><i class="typcn typcn-user-add"></i> Registrar</a></h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Correo</th>
                                        <th>Telefono</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Editar</th>
                                        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2  ) { ?>
                                            <th>Agregar</th>
                                            <th>Eliminar</th>
                                        <?php } ?>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                 if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
                                    $sql = mysqli_query($conection, "SELECT m.id,m.nombre,m.cedula,m.correo,m.telefono,m.fecha_nac,m.usuario FROM medicos m 
                                            WHERE m.estatus = 1 ORDER BY  m.id DESC");
                                            
                                  } else if ($_SESSION['rol'] == 5) {
                    
                                    $sql = mysqli_query($conection, "SELECT m.id,m.nombre,m.cedula,m.correo,m.telefono,m.fecha_nac,m.usuario FROM especialidad_doctores ed
                                    INNER JOIN medicos m ON m.id = ed.doctor_id
                                    INNER JOIN especialidades e ON e.id = ed.especialidad_id
                                    WHERE e.id = 3 AND m.estatus = 1 AND e.estatus = 1 AND ed.estatus = 1");
                                  }
                                    $resultado = mysqli_num_rows($sql);

                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['usuario']; ?></td>
                                                <td><?php echo $data['correo']; ?></td>
                                                <td><?php echo $data['telefono']; ?></td>
                                                <td><?php echo $data['fecha_nac'] ?></td>
                                

                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2  || $_SESSION['rol'] == 3|| $_SESSION['rol'] == 5) { ?>
                                                    <td>
                                                        <a href="../View/modificarMedico.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-info" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-edit"></i></a>
                                                    </td>
                                                <?php } ?>


                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                                    <td>
                                                        <a href="../View/credencialesMedico.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-warning" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-user-add" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                <?php } ?>

                                                <?php if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 5 ) { ?>
                                                    <td>
                                                        <a href="#" onclick="permisoAuto()" class="btn btn-outline-warning" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px  rgba(0, 0, 0, 0.25);"><i class="typcn typcn-user-add"></i></a>
                                                    </td>
                                                <?php } ?>
                                                
                                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) { ?>
                                                <td>
                                                    <button class="btn btn-outline-danger" onclick="EliminarDoctor('<?php echo $data['id'] ?>')"><i class="typcn typcn-user-delete" aria-hidden="true"></i></button>

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
            <script src="../assets/js/Medicos/medicos.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnEditarPass').click(function() {
                        /* Act on the event */
                        EliminarDoctor();
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

