<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/AsignarInformanteFabiola.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Asignar Informante<i class="typcn typcn-calculator"></i></h4>
                            <p class="card-description text-center">
                            datos del informante a seleccionar
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                                <div class="form-group">
                                    <label class="control-label">Medico Informante</label>
                                    <?php
                                    include "../Models/conexion.php";

                                    $query_medicos = mysqli_query($conection, "SELECT m.id,m.nombre,e.descripcion FROM especialidad_doctores ed
                                    INNER JOIN medicos m ON m.id = ed.doctor_id
                                    INNER JOIN especialidades e ON e.id = ed.especialidad_id
                                    WHERE e.id = 4 AND m.estatus = 1 AND e.estatus = 1 AND ed.estatus = 1");

                                    mysqli_close($conection); //con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
                                    $resultado = mysqli_num_rows($query_medicos);

                                    ?>
                                    <select name="informante_id" id="informante_id" class="chosen form-control">
                                        <?php

                                        if ($resultado > 0) {
                                            while ($medico = mysqli_fetch_array($query_medicos)) {

                                        ?>
                                                <option value="<?php echo $medico["id"]; ?>"><?php echo
                                                     $medico["nombre"] ?></option>

                                        <?php


                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Nro de Palcas</label>
                                    <input class="form-control" type="number" name="nro_placas" id="nro_placas" placeholder="Ingrese el monto">
                                </div>


                                <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                                <a class="btn btn-light" href="../Templates/listadoPacientesFabiola.php">Cancelar</a>
                                <br>
                                <?php if ($alert != "") {  ?>
                                    <div class="btn btn-outline-primary btn-lg w-100 mt-4 mb-0">
                                        <p style="color:#fff;">
                                            <?php echo $alert; ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>