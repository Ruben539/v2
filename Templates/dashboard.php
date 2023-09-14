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
                $fecha =  date('d-m-Y');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT DISTINCT(h.id),c.nombre,c.apellido,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
                       FROM historial h inner join clientes c on c.cedula = h.cedula where  h.Fecha like '%$fecha%' AND h.Atendedor like '%PAZ%' AND h.estatus = 1 ORDER BY  h.id ASC");

                $resultado = mysqli_num_rows($sql);
                $paz = 0;
                $nro = 0;
                if ($resultado > 0) {
                  while ($data = mysqli_fetch_array($sql)) {
                    $paz += (int)$data['Monto'];
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
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($paz, 3, '.', '.'); ?>.<b>GS</b></p>
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
          <div class="titulos col-md-3">
            <h3>Lista Diax <a class="btn btn-danger" href="../Reports/reporteDashboardDiario.php" target="_blank" rel="noopener noreferrer">
                <i class="typcn typcn-user-add"></i> Reporte PDF
              </a></h3>

          </div>
          <div class="table-responsive pt-3">
            <table class="table table-striped project-orders-table text-center">
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
                $fecha =  date('d-m-Y');
                //  echo $fecha1." ".$fecha2;
                //  exit;
                $sql = mysqli_query($conection, "SELECT DISTINCT(h.id),c.nombre,c.apellido,h.Estudio,h.Cedula,h.Atendedor,h.Fecha,h.Seguro,h.Monto,h.Descuento,h.MontoS,h.Comentario, h.fecha_2 
                       FROM historial h inner join clientes c on c.cedula = h.cedula where  h.Fecha like '%$fecha%' AND h.Atendedor like '%DIAX%' AND h.estatus = 1 ORDER BY  h.id ASC");

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
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($diax, 3, '.', '.'); ?>.<b>GS</b></p>
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
                      <td><?php echo $data['monto']; ?></td>
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
                  <?php echo number_format($gasto, 3, '.', '.'); ?>.<b>GS</b>
                </td>


              </tr>
            </table>
            <section>
              <?php
              $rendicion = $diax - $gasto;

              ?>
              <p>Rencion Final</p>
              <p style="text-align: right;" class="alert alert-danger"> <?php echo number_format($rendicion, 3, '.', '.'); ?>.<b>GS</b></p>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!---Fin de la tabla-------------------------------------------->
    <?php include('../includes/footer_admin.php'); ?>