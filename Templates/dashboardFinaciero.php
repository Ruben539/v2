<?php

    require_once("../includes/header_admin.php");
    require_once("../Models/conexion.php");
?>
    <?php
      $sql = mysqli_query($conection,"SELECT SUM(MONTO) as monto FROM empresa_movimientos where tipo_salida LIKE '%Ingreso%' AND estatus = 1");   

      //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
      
      
      $resultado = mysqli_num_rows($sql);
      
      if ($resultado == 0) {
        header("location: ../Templates/dashboardFinaciero.php");
      }else{
        $montoIngreso = 0;
        while ($data = mysqli_fetch_array($sql)) {
             $montoIngreso = $data['monto'];
              $ingreso = number_format($data['monto'], 0,'.','.');
                  
        }
      }
    ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Ingresos Totales</p>
                      <h1 class="mb-0"><?php echo $ingreso; ?> .GS</h1>
                    </div>
                    <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                  </div>
                  <canvas id="expense-chart" height="80"></canvas>
                </div>
              </div>
            </div>

            <?php
      $sql = mysqli_query($conection,"SELECT SUM(MONTO) as monto FROM empresa_movimientos where tipo_salida LIKE '%Egreso%' AND estatus = 1;");   

      //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
      
      
      $resultado = mysqli_num_rows($sql);
      
      if ($resultado == 0) {
        header("location: ../Templates/dashboardFinaciero.php");
      }else{
        $montoEgreso = 0;
        while ($data = mysqli_fetch_array($sql)) {
              $montoEgreso = $data['monto'];
              $egreso = number_format($data['monto'], 0,'.','.');
                  
        }
      }
    ?>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Egresos Totales</p>
                      <h1 class="mb-0"><?php echo $egreso; ?> .GS</h1>
                    </div>
                    <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                  </div>
                  <canvas id="budget-chart" height="80"></canvas>
                </div>
              </div>
            </div>

            <?php
                $diferencia = 0;
                $diferencia = (int)$montoIngreso - (int)$montoEgreso;
            ?>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                      <p class="mb-2 text-md-center text-lg-left">Diferencia Total</p>
                      <h1 class="mb-0"><?php echo number_format($diferencia, 0,'.','.'); ?> .GS</h1>
                    </div>
                    <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                <h3>Ingresos</h3>
                </div>
                <div class="table-responsive pt-3">
                <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Fecha de Movimiento</th>
                                        <th>Forma de Pago</th>
                                        <th>Nro Cheque/ Transferencia</th>
                                        <th>Tipo de Movimiento</th>
                                        <th>Monto</th>
                                        <th>Concepto</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,
                                       c.monto,c.concepto,c.usuario,c.created_at,fecha,c.aprobado,c.observacion
                                       FROM empresa_movimientos c where tipo_salida LIKE '%Ingreso%' AND c.estatus = 1 ");
                                  
                                    $resultado = mysqli_num_rows($sql);
                                    $row = 0;
                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $row++;
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $row; ?></td>
                                                <td><?php echo $data['fecha']; ?></td>
                                                <td><?php echo $data['forma_pago']; ?></td>
                                                <td><?php echo $data['nro_cheque']; ?></td>
                                                <td><?php echo $data['tipo_salida']; ?></td>
                                                <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                                                <td><?php echo $data['concepto'] ?></td>
                                                
                                            </tr>


                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
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
                <h4>Egresos</h4>
                </div>
                <div class="table-responsive pt-3">
                <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Fecha de Movimiento</th>
                                        <th>Forma de Pago</th>
                                        <th>Nro Cheque/ Transferencia</th>
                                        <th>Tipo de Movimiento</th>
                                        <th>Monto</th>
                                        <th>Concepto</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,
                                       c.monto,c.concepto,c.usuario,c.created_at,fecha,c.aprobado,c.observacion
                                       FROM empresa_movimientos c where tipo_salida LIKE '%Egreso%' AND c.estatus = 1 ");
                                  
                                    $resultado = mysqli_num_rows($sql);
                                    $row = 0;
                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $row++;
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $row; ?></td>
                                                <td><?php echo $data['fecha']; ?></td>
                                                <td><?php echo $data['forma_pago']; ?></td>
                                                <td><?php echo $data['nro_cheque']; ?></td>
                                                <td><?php echo $data['tipo_salida']; ?></td>
                                                <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                                                <td><?php echo $data['concepto'] ?></td>
                                                
                                            </tr>


                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
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
                <h4>Deposito</h4>
                </div>
                <div class="table-responsive pt-3">
                <table class="table table-bordered" id="tabla">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Fecha de Movimiento</th>
                                        <th>Forma de Pago</th>
                                        <th>Nro Cheque/ Transferencia</th>
                                        <th>Tipo de Movimiento</th>
                                        <th>Monto</th>
                                        <th>Concepto</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $sql = mysqli_query($conection, "SELECT c.id,c.forma_pago,c.nro_cheque,c.tipo_salida,
                                       c.monto,c.concepto,c.usuario,c.created_at,fecha,c.aprobado,c.observacion
                                       FROM empresa_movimientos c where tipo_salida LIKE '%Deposito%' AND c.estatus = 1 ");
                                  
                                    $resultado = mysqli_num_rows($sql);
                                    $row = 0;
                                    if ($resultado > 0) {
                                        while ($data = mysqli_fetch_array($sql)) {
                                            $row++;
                                    ?>
                                            <tr class="text-center">

                                                <td><?php echo $row; ?></td>
                                                <td><?php echo $data['fecha']; ?></td>
                                                <td><?php echo $data['forma_pago']; ?></td>
                                                <td><?php echo $data['nro_cheque']; ?></td>
                                                <td><?php echo $data['tipo_salida']; ?></td>
                                                <td><?php echo number_format($data['monto'],0,'.','.'); ?></td>
                                                <td><?php echo $data['concepto'] ?></td>
                                                
                                            </tr>


                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                </div>
              </div>
            </div>
          </div>
<!---Fin de la tabla-------------------------------------------->

<?php include('../includes/footer_admin.php');?>