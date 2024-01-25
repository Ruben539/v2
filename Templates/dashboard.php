<?php

require_once("../Models/conexion.php");
require_once("../includes/header_admin.php");
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Pacientes Totales Diax</p>
                <h1 class="mb-0" id="idPacienteDiax">0</h1>
              </div>
              <i class="typcn typcn-user icon-xl text-secondary"></i>
            </div>
            <canvas id="expense-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Pacientes Totales Paz</p>
                <h1 class="mb-0" id="idPacientePaz">0</h1>
              </div>
              <i class="typcn typcn-user icon-xl text-secondary"></i>
            </div>
            <canvas id="budget-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Cantidad Total de Pacientes</p>
                <h1 class="mb-0" id="idTotalPacientes">0</h1>
              </div>
              <i class="typcn typcn-group icon-xl text-secondary"></i>
            </div>
            <canvas id="balance-chart" height="80"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Ingresos Totales Diax</p>
                <h1 class="mb-0" id="idMontoDiax">0</h1>
              </div>
              <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
            </div>
            <canvas id="expense-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Ingresos Totales Paz</p>
                <h1 class="mb-0" id="idMontoPaz">0</h1>
              </div>
              <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
            </div>
            <canvas id="budget-chart" height="80"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
              <div>
                <p class="mb-2 text-md-center text-lg-left">Cantidad Total de Ingresos</p>
                <h1 class="mb-0" id="idTotalMonto">0</h1>
              </div>
              <i class="typcn typcn-credit-card icon-xl text-secondary"></i>
            </div>
            <canvas id="balance-chart" height="80"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!---Tabla de los pacientes que deriven de la consulta de PAZ--->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="titulos col-md-12 text-center">
            <h3>Lista de Pacientes ingresados por PAZ</h3>
          </div>
          <hr>
          <br>
          <div>
            <h3>EFECTIVO :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-stripedtext-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%PAZ%' AND dc.forma_pago_id = 1 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);
              
                $nro = 0;
                $monto = 0;
                $descripcion= '';
                $descuento = 0;
                $total = 0;
                $precio = 0;

             
                  if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                   

                    $precio = $data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <p class="alert alert-danger">Total: <span  style="text-align: right;"><?php echo number_format($total - $descuento, 0, '.', '.'); ?>.<b>GS</b></span></p>

            </section>
          </div>
          <hr>

          <div>
            <h3>POST :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%PAZ%' AND dc.forma_pago_id = 2 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuentoPaz = 0;
                $totalPaz = 0;
                $precio = 0;
                $generalPAZ = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuentoPaz += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $totalPaz += $monto;
                    $generalPAZ =  $totalPaz -$descuentoPaz;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <p>Ingreso total :</p>

              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalPaz - $descuentoPaz, 0, '.', '.'); ?>.<b>GS</b></p>

            </section>
          </div>
          <div>
            <h3>Tranferencia :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%PAZ%' AND dc.forma_pago_id = 3 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuentoPaz = 0;
                $totalPaz = 0;
                $precio = 0;
                $generalPAZ = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuentoPaz += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $totalPaz += $monto;
                    $generalPAZ =  $totalPaz -$descuentoPaz;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <p>Ingreso total :</p>

              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($totalPaz - $descuentoPaz, 0, '.', '.'); ?>.<b>GS</b></p>

            </section>
          </div>

          <hr>
          <br>
          <div>
            <h3>Seguro :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%PAZ%' AND dc.forma_pago_id = 4 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $total = 0;
                $precio = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <section>
              <p>Ingreso Total :</p>
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($total - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!---Fin de la tabla-------------------------------------------->
    <hr>
    <!---Tabla de los pacientes que deriven de la consulta de DIAX--->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="titulos col-md-12 text-center">
            <h3>Lista de Pacientes ingresados por Diax</h3>
          </div>
          <hr>

          <div>
            <h3>EFECTIVO :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%DIAX%' AND dc.forma_pago_id = 1 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $total = 0;
                $precio = 0;
                $general = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;
                    $general = $total - $descuento;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <br>
            <section>
              <table class="table table-striped text-center">
                <thead>
                <th class="alert alert-success">Total Diax</th>
                <th class="alert alert-info">Total Doctor</th>
                <th class="alert alert-warning">Total Ingresado</th>
                <th class="alert alert-warning">Total POST-PAZ</th>
                </thead>
                <tbody>
                  <tr>
                  <td><?php echo number_format((($general -  $generalPAZ) * 0.3),0,'.','.'); ?></td>
                  <td><?php echo number_format((($general -  $generalPAZ) * 0.7),0,'.','.');; ?></td>
                  <td><?php echo number_format($general -  $generalPAZ,0,'.','.'); ?></td>
                  <td><?php echo number_format($generalPAZ ,0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>

            </section>
          </div>

          <hr>

          <div>
            <h3>POST :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%DIAX%' AND dc.forma_pago_id = 2 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $total = 0;
                $precio = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <br>
            <section>
              <table class="table table-striped text-center">
                <thead>
                <th class="alert alert-success">Total Diax</th>
                <th class="alert alert-info">Total Doctor</th>
                <th class="alert alert-warning">Total Ingresado</th>
                </thead>
                <tbody>
                  <tr>
                  <td><?php echo number_format((($total - $descuento) * 0.3),0,'.','.'); ?></td>
                  <td><?php echo number_format((($total - $descuento) * 0.7),0,'.','.');; ?></td>
                  <td><?php echo number_format(($total - $descuento),0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
          <div>
            <h3>Tranferencia :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%DIAX%' AND dc.forma_pago_id = 3 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $total = 0;
                $precio = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuento += (int)$data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <br>
            <section>
              <table class="table table-striped text-center">
                <thead>
                <th class="alert alert-success">Total Diax</th>
                <th class="alert alert-info">Total Doctor</th>
                <th class="alert alert-warning">Total Ingresado</th>
                </thead>
                <tbody>
                  <tr>
                  <td><?php echo number_format((($total - $descuento) * 0.3),0,'.','.'); ?></td>
                  <td><?php echo number_format((($total - $descuento) * 0.7),0,'.','.');; ?></td>
                  <td><?php echo number_format(($total - $descuento),0,'.','.'); ?></td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>

          <hr>
          <br>
          <div>
            <h3>Seguro :</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">Nro Ticket</th>
                  <th>Ruc </th>
                  <th>Razon Social</th>
                  <th>Estudio</th>
                  <th>Monto</th>
                  <th>Monto Seguro</th>
                  <th>Descuento</th>
                  <th>Monto Cobrado</th>
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
                date_default_timezone_set('America/Asuncion');
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio,dc.descuento, m.nombre as doctor, 
                fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at,dc.monto_seguro,dc.nro_radiografias,c.estatus,
                IF(c.estatus = 1, dc.monto, 0) as monto,
                IF(c.estatus = 1, dc.descuento, 0) as descuento
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%DIAX%' AND dc.forma_pago_id = 4 AND c.created_at LIKE '%" . $fecha . "%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);

                $nro = 0;
                $monto = 0;
                $descuento = 0;
                $total = 0;
                $precio = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $precio = $data['monto'];
                    $descuento += $data['descuento'];
                    $nro++;

                    if ($data['estudio'] == 'Radiografias') {
                      $monto = $precio * $data['nro_radiografias'];
                    } else if ($data['estudio'] != 'Radiografias') {
                      $monto =  $precio;
                    }

                    $total += $monto;

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id']; ?></td>
                      <td><?php echo $data['ruc']; ?></td>
                      <td><?php echo $data['razon_social']; ?></td>
                      <td><?php echo $data['estudio']; ?></td>
                      <td><?php echo number_format($monto, 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['monto_seguro'], 0, '.', '.'); ?></td>
                      <td><?php echo number_format($data['descuento'], 0, '.', '.'); ?></td>
                      <td style="background-color: #02b102; color:aliceblue;"><b><?php echo number_format($monto - $data['descuento'], 0, '.', '.'); ?></b></td>
                      <td><?php echo $data['doctor'] ?></td>
                      <td><?php echo $data['forma_pago'] ?></td>
                      <td><?php echo $data['seguro'] ?></td>
                      <td><?php echo $data['comentario'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>

                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/cancelarOrden.php?id=<?php echo $data['id']; ?>" type="button" class="btn btn-danger btn-sm btn-icon-text">
                            Anular
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
            <br>
            <section>
            <table class="table table-striped text-center">
              <thead>
                <th class="alert alert-success">Total Diax</th>
                <th class="alert alert-info">Total Doctor</th>
                <th class="alert alert-warning">Total Ingresado</th>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo number_format((($total - $descuento) * 0.3),0,'.','.'); ?></td>
                  <td><?php echo number_format((($total - $descuento) * 0.7),0,'.','.');; ?></td>
                  <td><?php echo number_format(($total - $descuento),0,'.','.'); ?></td>
                </tr>
              </tbody>
             </table>
            </section>
          </div>
        </div>
      </div>
      
      <div class="table-responsive pt-3">
        <?php 
          date_default_timezone_set('America/Asuncion');
          $fecha =  date('Y-m-d');
          $query_paz = mysqli_query($conection,"SELECT count(DISTINCT(c.id)) AS cantidad  FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
          INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
          WHERE dc.forma_pago_id <> 4 AND c.created_at LIKE '%$fecha%' AND m.nombre like '%PAZ%' AND c.estatus = 1");

          $resultado_paz = mysqli_num_rows($query_paz);
          $cantidadPaz  = 0;
         
          while($data = mysqli_fetch_array($query_paz)){

              $cantidadPaz  = $data['cantidad'];
             

          }

          date_default_timezone_set('America/Asuncion');
          $fecha =  date('Y-m-d');
          $query_diax = mysqli_query($conection,"SELECT count(DISTINCT(c.id)) AS cantidad  FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
          INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
          WHERE dc.forma_pago_id <> 4 AND c.created_at LIKE '%$fecha%' AND m.nombre like '%DIAX%' AND c.estatus = 1");

          $resultado_diax = mysqli_num_rows($query_diax);
          $cantidadDiax  = 0;
        
          while($data = mysqli_fetch_array($query_diax)){

              $cantidadDiax  = $data['cantidad'];
            

          }


        ?>
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <th>Cantidad Bio Paz</th>
                <th>Monto Bio Paz</th>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $cantidadPaz; ?></td>
                  <td><?php echo number_format($cantidadPaz * 10000,0,'.','.'); ?></td>
                  <td><?php echo $cantidadDiax; ?></td>
                  <td><?php echo number_format($cantidadDiax * 10000,0,'.','.'); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
    </div>
    <!---Fin de la tabla-------------------------------------------->

    <?php include('../includes/footer_admin.php'); ?>