    <?php
    $desde = $_POST['fecha_desde'].' 00:00:00';
    $hasta = $_POST['fecha_hasta'].' 23:00:00';

    require_once("../Models/conexion.php");
    //TODO: Condultas para traer el monto total ingresa por la fecha buscada.
    $sqlPaz = mysqli_query($conection, "SELECT SUM(IF(dc.nro_radiografias <> 0, (dc.monto * dc.nro_radiografias) , dc.monto)) as monto,dc.descuento
     FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
     INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
     WHERE m.nombre LIKE '%PAZ%' AND c.created_at BETWEEN '$desde' AND '$hasta'  AND c.estatus = 1");

    $resultado = mysqli_num_rows($sqlPaz);

    if ($resultado == 0) {
        header("location: ../Templates/rendicionMensual.php");
    } else {
        $montoPaz = 0;
        while ($data = mysqli_fetch_array($sqlPaz)) {
            $montoPaz += $data['monto'];
            $ingresoPaz = number_format($montoPaz - $data['descuento'], 0, '.', '.');
        }
    }


    $sqlDiax = mysqli_query($conection, "SELECT SUM(IF(dc.nro_radiografias <> 0, (dc.monto * dc.nro_radiografias) , dc.monto)) as monto,dc.descuento 
      FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
      INNER JOIN detalle_comprobantes dc ON c.id = dc.comprobante_id
      WHERE m.nombre LIKE '%DIAX%' AND c.created_at BETWEEN '$desde' AND '$hasta'  AND c.estatus = 1");

    $resultado = mysqli_num_rows($sqlDiax);

    if ($resultado == 0) {
        header("location: ../Templates/rendicionMensual.php");
    } else {
        $montoDiax = 0;
        while ($data = mysqli_fetch_array($sqlDiax)) {
            $montoDiax = $data['monto'];
            $ingresoDiax = number_format($montoDiax - $data['descuento'], 0, '.', '.');
        }
    }

    $total = 0;
    $total = number_format($montoPaz + $montoDiax,0,'.','.');

    //TODO:Condulta para la cantidad de pacientes del rango seleccionado.
    $pacientePaz = mysqli_query($conection,"SELECT count(*) AS pacientes  FROM comprobantes c 
    INNER JOIN medicos m ON m.id = c.doctor_id
    WHERE m.nombre LIKE '%PAZ%' AND c.created_at BETWEEN '$desde' AND '$hasta'  AND c.estatus = 1");

    $resultado = mysqli_num_rows($pacientePaz);

    if ($resultado == 0) {
        header("location: ../Templates/rendicionMensual.php");
    } else {
        $cantidadPaz = 0;
        while ($data = mysqli_fetch_array($pacientePaz)) {
            $cantidadPaz = $data['pacientes'];
        
        }
    }

    $pacienteDiax = mysqli_query($conection,"SELECT count(*) AS pacientes  FROM comprobantes c 
    INNER JOIN medicos m ON m.id = c.doctor_id
    WHERE m.nombre LIKE '%DIAX%' AND c.created_at BETWEEN '$desde' AND '$hasta'  AND c.estatus = 1");

    $resultado = mysqli_num_rows($pacienteDiax);

    if ($resultado == 0) {
        header("location: ../Templates/rendicionMensual.php");
    } else {
        $cantidadDiax = 0;
        while ($data = mysqli_fetch_array($pacienteDiax)) {
            $cantidadDiax = $data['pacientes'];
        
        }
    }

    $totalPacientes = $cantidadPaz + $cantidadDiax;

    //TODO: Consulta para traer los medicos de que atendieron en el rango de fecha.
    $sqlmedicoPaz = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre 
    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
    INNER JOIN medicos m ON m.id = c.doctor_id 
    WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
    AND m.nombre LIKE '%PAZ%' AND c.created_at BETWEEN '$desde' AND '$hasta'  
    AND c.estatus = 1 GROUP BY m.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($sqlmedicoPaz);
    $nroPaz = 0;


    $sqlmedicoDiax = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, m.nombre 
    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
    INNER JOIN medicos m ON m.id = c.doctor_id 
    WHERE  c.id IN (SELECT comprobante_id FROM detalle_comprobantes) 
    AND m.nombre LIKE '%DIAX%' AND c.created_at BETWEEN '$desde' AND '$hasta'  
    AND c.estatus = 1 GROUP BY m.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($sqlmedicoDiax);
    $nroDiax = 0;

    //TODO: Consulta para traer el total de pacientes por especialidad.
    $especialidad = mysqli_query($conection, "SELECT COUNT(DISTINCT(c.id)) AS cantidad, e.descripcion AS especialidad
    FROM comprobantes c INNER JOIN medicos m ON m.id = c.doctor_id 
    INNER JOIN especialidad_doctores ed ON ed.doctor_id = m.id
    INNER JOIN especialidades e ON e.id = ed.especialidad_id
    WHERE  c.created_at BETWEEN '$desde' AND '$hasta'  
    AND c.estatus = 1 GROUP BY m.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($especialidad);
    $nro = 0;


    //TODO: Consulta para traer el total de estudios por el rango seleccionado.
    $estudios = mysqli_query($conection,"SELECT COUNT(c.id) AS cantidad, e.nombre,e.id as estudio_id,
    SUM(IF(dc.nro_radiografias <> 0, (dc.monto * dc.nro_radiografias) , dc.monto)) as monto,
    SUM(IF(dc.nro_radiografias <> 0, (dc.monto_seguro * dc.nro_radiografias) , dc.monto_seguro)) as monto_seguro,
    dc.descuento
    FROM comprobantes c INNER JOIN detalle_comprobantes dc ON dc.comprobante_id = c.id
    INNER JOIN estudios e ON e.id = dc.estudio_id
    WHERE  c.created_at BETWEEN '$desde' AND '$hasta'  
    AND c.estatus = 1 GROUP BY e.nombre ORDER BY cantidad DESC");

    $resultado = mysqli_num_rows($estudios);
    $nroEstudio = 0;

    echo '
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Monto Ingresado Paz</p>
                                    <h1 class="mb-0">'. $ingresoPaz.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                                <p class="mb-2 text-md-center text-lg-left">Monto Ingresado Diax</p>
                                <h1 class="mb-0">'.$ingresoDiax.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                                <p class="mb-2 text-md-center text-lg-left">Monto Ingresado Diax</p>
                                <h1 class="mb-0">'.$total.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                    </div>
                        <canvas id="budget-chart" height="80"></canvas>
                    </div>
                </div>
            </div>
    </div>
    </div>';


    echo '
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                            <div>
                                <p class="mb-2 text-md-center text-lg-left">Cantidad de Pacientes Paz</p>
                                    <h1 class="mb-0">'.$cantidadPaz.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                                <p class="mb-2 text-md-center text-lg-left">Cantidad de Pacientes Diax</p>
                                <h1 class="mb-0">'.$cantidadDiax.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
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
                                <p class="mb-2 text-md-center text-lg-left">Cantidad total de Pacientes</p>
                                <h1 class="mb-0">'.$totalPacientes.'</h1>
                            </div>
                            <i class="typcn typcn-calculator icon-xl text-secondary"></i>
                    </div>
                        <canvas id="budget-chart" height="80"></canvas>
                    </div>
                </div>
            </div>
    </div>
    </div>';

    echo'
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="titulos col-md-3">
                    <h3>Medicos Paz</h3>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center" id="tabla">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Nombre del Medico</th>
                                <th>Cantidad de Paciente</th>
                            </tr>
                        </thead>
                        <tbody>
                </div>';
    while($data = mysqli_fetch_array($sqlmedicoPaz)){
    $nroPaz++;
    echo '
        <tr>
            <td>'. $nroPaz .'</td>
            <td>'.  $data['nombre'] .'</td>
            <td>'.  $data['cantidad'] .'</td>
        </tr>
    ';
    }
    echo'
                        </tbody>
                    </table>
        </div>
    </div>';

    echo'<hr>';
    echo'
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="titulos col-md-3">
                    <h3>Medicos Diax</h3>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center" id="tabla">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Nombre del Medico</th>
                                <th>Cantidad de Paciente</th>
                            </tr>
                        </thead>
                        <tbody>
                </div>';
    while($data = mysqli_fetch_array($sqlmedicoDiax)){
    $nroDiax++;
    echo '
        <tr>
            <td>'. $nroDiax .'</td>
            <td>'.  $data['nombre'] .'</td>
            <td>'.  $data['cantidad'] .'</td>
        </tr>
    ';
    }
    echo'
                        </tbody>
                    </table>
        </div>
    </div>';
    echo'<hr>';

    echo'
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="titulos col-md-3">
                    <h3>Especialidad</h3>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center" id="tabla">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Especialidad</th>
                                <th>Cantidad de Paciente</th>
                            </tr>
                        </thead>
                        <tbody>
                </div>';
    while($data = mysqli_fetch_array($especialidad)){
    $nro++;
    echo '
        <tr>
            <td>'. $nro .'</td>
            <td>'.  $data['especialidad'] .'</td>
            <td>'.  $data['cantidad'] .'</td>
        </tr>
    ';
    }
    echo'
                        </tbody>
                    </table>
        </div>
    </div>';
    echo'<hr>';

    echo'
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="titulos col-md-3">
                    <h3>Estudios</h3>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-bordered text-center" id="tabla">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Estudio</th>
                                <th>Cantidad</th>
                                <th>Monto Total</th>
                                <th>Monto Seguro</th>
                                <th>Ver Pacientes</th>
                            </tr>
                        </thead>
                        <tbody>
                </div>';

    while($data = mysqli_fetch_array($estudios)){
    $nroEstudio++;

    echo '
        <tr>
            <td>'. $nroEstudio .'</td>
            <td>'.  $data['nombre'] .'</td>
            <td>'.  $data['cantidad'] .'</td>
            <td>'.  number_format($data['monto'] - $data['descuento'],0,'.','.') .'</td>
            <td>'.  number_format($data['monto_seguro'] - $data['descuento'],0,'.','.') .'</td>
            <td>
                <a class="btn btn-outline-success" target="_blank" href="../Templates/infoRendicionMensual.php?id='. $data['estudio_id'].'"><i class="typcn typcn-eye-outline"></i></a>
            </td>
        </tr>
    ';
    }
    echo'
                        </tbody>
                    </table>
        </div>
    </div>';

    ?>