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
                            <h4 class="card-title text-center">Asignar Informante <i class="typcn typcn-user"></i></h4>
                            <p class="card-description text-center">
                                Asignar Informante a la Orden de
                            </p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="Informa" id="Informa" placeholder="Ingrese el Informa" value="<?php echo $Informa; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Medico Informante</label>
                                    <?php
                                    include "../Models/conexion.php";

                                    $query_medicos = mysqli_query($conection, "SELECT * FROM medicos where Especialidad like '%Informante%'");

                                    mysqli_close($conection); //con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
                                    $resultado = mysqli_num_rows($query_medicos);

                                    ?>
                                    <select name="Informa" id="Informa" class="chosen form-control">
                                        <?php

                                        if ($resultado > 0) {
                                            while ($medico = mysqli_fetch_array($query_medicos)) {

                                        ?>
                                                <option value="<?php echo $medico["Nombre"]; ?>"><?php echo
                                                                                                    $medico["Nombre"] ?></option>

                                        <?php


                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Numero de Placas</label>
                                    <input class="form-control" type="number" name="Placas" id="Placas" placeholder="Ingrese el numero de Placas">
                                </div>


                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Asignar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="../Templates/listadoPacientesFabiola.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>

                                </div>
                            </form>
                            <br>
                            <?php if (isset($alert)) { ?>
                                <div class="alert alert-info text-center"><?php echo  $alert; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../includes/footer_admin.php'); ?>