<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1) {
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

            <h4>Panel de Ordenes a Cancelar <i class="typcn typcn-archive"></i></h4>

            <div class="table-responsive pt-3">
              <table class="table table-striped project-orders-table" id="tabla">
                <thead>
                  <tr>
                    <th class="ml-5">Nro</th>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Cedula</th>
                    <th>Estudio</th>
                    <th>Doctor/a</th>
                    <th>Seguro</th>
                    <th>Monto</th>
                    <th>Monto Seguro</th>
                    <th>Descuento</th>
                    <th>Comentario</th>
                    <th>Anular</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $fecha1 = "05-01-2023";
                  $fecha =  date('m-Y');
                  //  echo $fecha1." ".$fecha2;
                  //  exit;
                  $sql = mysqli_query($conection, "SELECT DISTINCT(h.id),c.nombre,c.apellido,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
                       FROM historial h inner join clientes c on c.cedula = h.cedula where  h.Fecha like '%$fecha%' AND h.estatus = 2 ORDER BY  h.id ASC");

                  $resultado = mysqli_num_rows($sql);
                  $diax = 0;
                  $nro = 0;
                  if ($resultado > 0) {
                    while ($data = mysqli_fetch_array($sql)) {
                      $diax += (int)$data['Monto'];
                      $nro++;
                  ?>
                      <tr class="text-center">

                        <td><?php echo $nro ?></td>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['Fecha']; ?></td>
                        <td><?php echo $data['nombre'] . ' ' . $data['apellido'];  ?></td>
                        <td><?php echo $data['Cedula']; ?></td>
                        <td><?php echo $data['Estudio']; ?></td>
                        <td><?php echo $data['Atendedor']; ?></td>
                        <td><?php echo $data['Seguro']; ?></td>
                        <td><?php echo $data['Monto'] ?></td>
                        <td><?php echo $data['MontoS'] ?></td>
                        <td><?php echo $data['Descuento'] ?></td>
                        <td><?php echo $data['Comentario'] ?></td>



                        <td>
                          <div class="d-flex align-items-center">

                            <button class="btn btn-outline-danger" onclick="dardeBajaOrden('<?php echo $data['id'] ?>')"><i class="typcn typcn-delete" aria-hidden="true"></i></button>

                          </div>
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
            <script src="../assets/js/Ordenes/cancelarOrden.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnEditarPass').click(function() {
                        /* Act on the event */
                        dardeBajaOrden();
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