<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
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
                    <th>Ruc </th>
                    <th>Razon Social</th>
                    <th>Estudio</th>
                    <th>Monto</th>
                    <th>Descuento</th>
                    <th>Doctor</th>
                    <th>Forma de Pago</th>
                    <th>Seguro</th>
                    <th>Comentario</th>
                    <th>Fecha</th>
                    <th>Anular</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $fecha1 = "05-01-2023";
                  $fecha =  date('m-Y');
                  //  echo $fecha1." ".$fecha2;
                  //  exit;
                  $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto)
                   as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.motivo_anulado, c.created_at
                  FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                  INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                  INNER JOIN seguros s ON s.id = dc.seguro_id
                  WHERE  c.estatus = 2 GROUP BY c.id  ORDER BY  c.id ASC");

                  $resultado = mysqli_num_rows($sql);
                  $diax = 0;
                  $nro = 0;
                  if ($resultado > 0) {
                    while ($data = mysqli_fetch_array($sql)) {
                      $diax += (int)$data['monto'];
                      $nro++;
                  ?>
                      <tr class="text-center">

                        <td><?php echo $nro ?></td>
                        <td><?php echo $data['ruc']; ?></td>
                        <td><?php echo $data['razon_social']; ?></td>
                        <td><?php echo $data['estudio']; ?></td>
                        <td><?php echo number_format($data['monto'],0, '.', '.'); ?></td>
                        <td><?php echo number_format($data['descuento'],0, '.', '.'); ?></td>
                        <td><?php echo $data['doctor'] ?></td>
                        <td><?php echo $data['forma_pago'] ?></td>
                        <td><?php echo $data['seguro'] ?></td>
                        <td><?php echo $data['motivo_anulado'] ?></td>
                        <td><?php echo $data['created_at'] ?></td>



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