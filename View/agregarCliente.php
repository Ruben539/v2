<?php
require_once("../Controllers/grabarPaciente.php");
require_once("../includes/header_admin.php");

?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Agregar Cliente <i class="typcn typcn-user"></i></h4>
                            <p class="card-description text-center">
                                Datos del Cliente a grabar
                            </p>
                            <form class="forms-sample" method="POST" action="">
                                <div class="form-group">
                                    <label for="cedula">Cedula :</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula">
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre :</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo :</label>
                                    <input type="email" class="form-control" id="correo" name="correo">
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Nro de Telefono :</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono">
                                </div>
                                <div class="form-group">
                                    <label for="pass">Sexo :</label>
                                    <select name="sexo" id="sexo" class="form-control">
                                        <option value="">Seleccione el Sexo.....</option>
                                        <option value="Masculino">Maculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_nac">Fecha de Nacimiento :</label>
                                    <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                                </div>
                                
                                <button type="submit" class="btn btn-primary mr-2">Registrar</button>
                                <a class="btn btn-light" href="../Templates/usuarios.php">Cancelar</a>
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