<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarUsuario.php');
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">Agregar Usuario <i class="typcn typcn-user"></i></h4>
              <p class="card-description text-center">
                Datos del Usuario a grabar
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
                  <label for="usuario">Usuario :</label>
                  <input type="text" class="form-control" id="usuario" name="usuario">
                </div>
                <div class="form-group">
                  <label for="pass">Password :</label>
                  <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <div class="form-group">
                  <label for="rol">Puesto :</label>
                  <?php
                  include "../Models/conexion.php";

                  $query_roles = mysqli_query($conection, "SELECT * FROM roles where id  > 1 AND estatus = 1");

                  mysqli_close($conection); //con esto cerramos la conexion a la base de datos una vez conectado arriba con el conexion.php
                  $resultado = mysqli_num_rows($query_roles);

                  ?>
                  <select name="rol" id="rol" class="form-control">
                    <option >Seleccione el rol asignar<option>
                    <?php

                    if ($resultado > 0) {
                      while ($rol = mysqli_fetch_array($query_roles)) {

                    ?>
                        <option value="<?php echo $rol["id"]; ?>"><?php echo
                        $rol["descripcion"] ?></option>

                    <?php


                      }
                    }

                    ?>
                  </select>
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