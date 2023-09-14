<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/credencialesMedico.php');
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">Medico a Asignar <i class="typcn typcn-user"></i></h4>
              <p class="card-description text-center">
                <?php echo $nombre;?>
              </p>
              <form class="forms-sample" method="POST" action="">
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" >
                  <label for="usuario">usuario :</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario;?>">
                </div>
                <div class="form-group">
                  <label for="pass">Contraseña :</label>
                  <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $pass;?>">
                </div>
                <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                <a class="btn btn-light" href="../Templates/medicos.php">Cancelar</a>
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