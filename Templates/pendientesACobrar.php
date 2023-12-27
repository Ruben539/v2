<?php



require_once('../Models/conexion.php');

date_default_timezone_set('America/Asuncion');
$hoy = date('Y-m-d');

$query_comprobantes = mysqli_query($conection, "SELECT  DISTINCT(c.id),c.ruc, c.razon_social,dc.descripcion as estudio,
 dc.monto,dc.descuento, m.nombre as doctor,dc.cobertura,s.descripcion as seguro,c.comentario, c.created_at,dc.nro_radiografias
 FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
 INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN seguros s ON s.id = dc.seguro_id
 WHERE  c.estatus = 3 AND c.created_at LIKE '%" . $hoy . "%' GROUP BY c.id  ORDER BY  c.id ASC");

$resultado = mysqli_num_rows($query_comprobantes);

$monto = 0;
$descuento = 0;
$id = 0;

require_once("../includes/header_admin.php");
require_once('../Modals/modalFacturacion.php');
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="text-center">Pacientes Pendientes de Cobro </h4>
                        <hr>
                        <?php if ($resultado > 0) {
                            while ($data = mysqli_fetch_array($query_comprobantes)) {
                              

                                if ($data['estudio'] == 'Radiografias') {
                                    $monto = $data['monto'] * $data['nro_radiografias'];
                                } else {
                                    $monto = $data['monto'];
                                }

                                $descuento += (int)$data['descuento'];

                                $datos = $data[0]."||".
                                $data[1]."||".
                                $data[2]."||".
                                $data[3]."||".
                                $data[4]."||".
                                $data[5]."||".
                                $data[6]."||".
                                $data[7];
                                

                        ?>
                                <div class="card profile-card">
                                    <div class="card-body">
                                        <div class="row align-items-center h-100">
                                            <div class="col-md-4">
                                                <figure class="avatar mx-auto mb-4 mb-md-0">
                                                    <img src="../assets/images/logo.png" alt="avatar" style="width: 230px; height: 230px; border-radius: 100%; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1), 0 6px 20px  rgba(0, 0, 0, 0.25);">
                                                </figure>
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="text-black text-center text-md-left">Cedula : <?php echo $data[1]; ?></h5>
                                                <p class="text-black text-center text-md-left">Fecha : <?php echo $data['created_at']; ?></p>
                                                <p class="text-black text-center text-md-left">Paciente : <?php echo $data['razon_social']; ?></p>
                                                <p class="text-black text-center text-md-left">Medico : <?php echo $data['doctor']; ?></p>
                                                <p class="text-black text-center text-md-left">Seguro : <?php echo $data['seguro']; ?></p>
                                                <p class="text-black text-center text-md-left" style="font-size: 20px;"><b>Nro de Ticket : <?php echo $data['id']; ?></b></p>
                                                <div class="d-flex align-items-center justify-content-between info pt-2">
                                                    <div>
                                                        <?php if ($data['cobertura'] == 2) { ?>
                                                            <p class="text-black">Cobertura : Completa</p>

                                                        <?php } else { ?>
                                                            <p class="text-black">Cobertura : Preferencial</p>
                                                        <?php } ?>
                                                        <p class="text-black font-weight-bold">Estudio : <?php echo $data['estudio']; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-black"><?php echo number_format($monto - $descuento, 0, '.', '.'); ?></p>
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#modalEditar" onclick="editarDatosFactura('<?php echo $datos; ?>')">
                                                            Registrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                        <?php  }
                        } ?>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>
            <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
            <script src="../assets/js/sweetalert2.min.js"></script>
            <script src="../assets/js/core/popper.min.js"></script>
            <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript" src="../assets/js/Facturacion/facturacion.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#btnConfirmar').click(function() {
                        /* Act on the event */
                        forma_pago_id = $('#forma_pago_id').val();
                        id_referente = $('#id_referente').val();
                        forma_pago_id_2 = $('#forma_pago_id_2').val();
                        monto_2 = $('#monto_2').val();

                        /*confirmarDatosFacturacion(id, forma_pago_id, id_referente);*/
                    });

                    $('#btnEditarUsu').click(function() {
                        /* Act on the event */
                      
                        confirmarDatosFacturacion();
                    });



                });
              
            </script>