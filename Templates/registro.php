<?php
require_once("../includes/header_admin.php");

if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
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
                        <div class=" shadow-primary border-radius-lg pt-1 pb-1">
                            <h4 class="text-black text-capitalize ps-4 text-center">Registro de Comprobantes</h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            
            if (empty($_REQUEST['id'])) {

                $sql = mysqli_query($conection, "SELECT c.id,c.cedula,c.nombre,c.apellido,c.celular,c.nacimiento FROM clientes c  order by id desc limit 1");

                //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


                $resultado = mysqli_num_rows($sql);

                if ($resultado == 0) {
                    header("location: ../Templates/usuarios.php");
                } else {
                    $option = '';
                    while ($data = mysqli_fetch_array($sql)) {

                        $iduser     = $data['id'];
                        $cedula     = $data['cedula'];
                        $nombre     = $data['nombre'];
                        $apellido   = $data['apellido'];
                        $telefono   = $data['celular'];
                        $fecha_nac  = $data['nacimiento'];
                    }
                }
            } else {

                $sql = mysqli_query($conection, "SELECT c.id,c.cedula,c.nombre,c.apellido,c.celular,c.nacimiento FROM clientes c WHERE id = '" . $_REQUEST['id'] . "'  ");

                //mysqli_close($conection);//con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php


                $resultado = mysqli_num_rows($sql);

                if ($resultado == 0) {
                    header("location: ../Templates/usuarios.php");
                } else {
                    $option = '';
                    while ($data = mysqli_fetch_array($sql)) {

                        $id         = $data['id'];
                        $cedula     = $data['cedula'];
                        $nombre     = $data['nombre'];
                        $apellido   = $data['apellido'];
                        $telefono   = $data['celular'];
                        $fecha_nac  = $data['nacimiento'];
                    }
                }
            }
            ?>
            <!-------------------------------------INICIO DEL FORMULARIO------------------------------------------------------------------->
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Datos del Paciente</h2>
                        <hr>
                        <p class="card-description">
                            <b>N° de Cedula :</b> <?= $cedula; ?>
                        </p>
                        <p class="card-description">
                            <b>Nombre y Apellido :</b> <?= $nombre.' '.$apellido; ?>
                        </p>
                        <p class="card-description">
                            <b>Nro de Telefono :</b> <?= $telefono; ?>
                        </p>
                        <p class="card-description">
                            <b>Fecha de Nacimiento :</b> <?= $fecha_nac; ?>
                        </p>
                        <hr>
                        <form class="forms-sample" action="comprobante.php" method="POST">
                            <input type="hidden" name="id"         id="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="cedula"     id="cedula" value="<?php echo $cedula; ?>">
                            <input type="hidden" name="nombre"     id="nombre" value="<?php echo $nombre .' '.$apellido; ?>">
                            <input type="hidden" name="nacimiento" id="nacimiento" value="<?php echo $fecha_nac; ?>">
                            <div class="form-group">
                                <label for="exampleInputName1">Estudio a Realizar</label>
                                <select name="ecografias[]" class="chosen form-control" data-placeholder="Elige uno o varios estudios" multiple>
                                        <option value=""></option>
                                        <?php
                                        $raw_results3 = mysqli_query($conection, "select * from tarifas where Estudio not like '%TAC%' and estatus = 1;") or die(mysqli_error($conection));
                                        while ($results = mysqli_fetch_array($raw_results3)) {
                                        ?>
                                            <option value=" <?php echo $results['Estudio'] ?> ">
                                                <?php echo $results['Estudio']; ?>
                                            </option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for="rayosx">Posición de Rayos</label>
                                <input type="number" class="form-control" name = "rayosx" id="rayosx">
                            </div>
                            <div class="form-group">
                                <label for="medico">Medico Tratante</label>
                                <select class="chosen form-control" name="medico" id="medico" required data-placeholder="Seleccione un Medico">
                                            <option value=""></option>
                                            <?php
                                            $raw_results4 = mysqli_query($conection, "select * from medicos;") or die(mysqli_error($conection));
                                            while ($results = mysqli_fetch_array($raw_results4)) {
                                            ?>

                                                <option value=" <?php echo $results['Nombre'] ?> ">
                                                    <?php echo $results['Nombre']; ?>
                                                </option>

                                            <?php
                                            }
                                            ?>
                                        </select>
                            </div>
                            <div class="form-group">
                                <label for="seguro">Tipo de Seguro</label>
                                <select class="form-control" name="seguro" id="seguro" required data-placeholder="Seleccione un Seguro" id="test" onchange="document.getElementById('text_content').value=this.options[this.selectedIndex].text">
                                            <option value="SinSeguro">Sin Seguro</option>
                                            <option value="Hospitalar">Hospitalario</option>
                                        </select>
                            </div>
                            <input type="hidden" name="texto" id="text_content" value=" " />
                            <div class="form-group">
                                <label>Descuento a Aplicar</label>
                                <input type="number" class="form-control"name="descuento" value="0">
                            </div>
                            <div class="form-group">
                                <label for="comentario">Observacion sobre la Orden</label>
                                <textarea class="form-control" name="comentario" style='width:100%;padding: 16px'></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Registrar</button>
                            <button class="btn btn-light">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-------------------------------------INICIO DEL FORMULARIO------------------------------------------------------------------->
            <?php include('../includes/footer_admin.php'); ?>

            <script type="text/javascript" src="../assets/js/jquery-3.3.1.min.js"></script>
            <script src="../assets/js/sweetalert2.min.js"></script>
            <script src="../assets/js/core/popper.min.js"></script>
            <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="../assets/js/dataTables.bootstrap.min.js"></script>
            <link rel="stylesheet" href="../node_modules/chosen-js/chosen.css" type="text/css" />
            <script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
            <script src="../node_modules/chosen-js/chosen.jquery.js"></script>
            <script>
                $(document).ready(function() {
                    $(".chosen").chosen();
                });
            </script>