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
          <div class="titulos col-md-2">
            <h3>Lista Paz</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
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
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%PAZ%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);
                $paz = 0;
                $descuento = 0;
                $nro = 0;
                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $paz += (int)$data['monto'];
                    $descuento += (int)$data['descuento'];
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
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($paz - $descuento, 0, '.', '.'); ?>.<b>GS</b></p>
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
          <div class="titulos col-md-2">
            <h3>Lista Diax</h3>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
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
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT  c.id,c.ruc, c.razon_social,dc.descripcion as estudio, SUM(dc.monto) as monto,dc.descuento, m.nombre as doctor, fp.descripcion as forma_pago,s.descripcion as seguro,c.comentario, c.created_at
                FROM comprobantes c INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
                INNER JOIN medicos m ON m.id = c.doctor_id INNER JOIN forma_pagos fp ON fp.id = dc.forma_pago_id
                INNER JOIN seguros s ON s.id = dc.seguro_id
                WHERE m.nombre like '%DIAX%' AND c.estatus = 1 GROUP BY c.id  ORDER BY  c.id ASC");

                $resultado = mysqli_num_rows($sql);
                $diax = 0;
                $descuento = 0;
                $nro = 0;
                $total = 0;
                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $diax += (int)$data['monto'];
                    $descuento += (int)$data['descuento'];
                    $total = $diax - $descuento;
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
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($total, 0, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!---Fin de la tabla-------------------------------------------->
    <hr>
    <!---Tabla de los pacientes que deriven de la consulta de Gastos del Dia--->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="titulos col-md-2">
            <h4>Gastos Diarios</h4>
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
              <thead>
                <tr>
                  <th class="ml-5">ID</th>
                  <th>Fecha</th>
                  <th>Descripcion</th>
                  <th>Monto</th>
                  <th>Editar</th>
                  <th>Anular</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // $fecha1 = "05-01-2023";
                $fecha =  date('Y-m-d');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT g.id,g.descripcion,g.monto,g.created_at  FROM gastos g 
               where  g.created_at like '%" . $fecha . "%' and g.estatus = 1");

                $resultado = mysqli_num_rows($sql);
                $gasto = 0;

                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $gasto += (int)$data['monto'];

                ?>
                    <tr class="text-center">

                      <td><?php echo $data['id'] ?></td>
                      <td><?php echo $data['created_at'] ?></td>
                      <td><?php echo $data['descripcion']; ?></td>
                      <td><?php echo number_format($data['monto'], 0, '.', '.'); ?></td>
                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/modificarGasto.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-info"><i class="typcn typcn-edit"></i></a>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">

                          <a href="../View/gastosCancelacion.php?id=<?php echo $data['id']; ?>" class="btn btn-outline-danger"><i class="typcn typcn-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                  

                <?php }
                } ?>
              </tbody>
              <tr>
                <td><b>Total A Gastos : </b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="alert alert-success text-center">
                  <?php echo number_format($gasto, 0, '.', '.'); ?>.<b>GS</b>
                </td>


              </tr>
            </table>
            <section>
              <?php
              $rendicion = $total - $gasto;

              ?>
              <p>Rencion Final</p>
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($rendicion, 0, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!---Fin de la tabla-------------------------------------------->
    <?php include('../includes/footer_admin.php'); ?>