<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/modificarEstudios.php');
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">Modificar Estudio <i class="typcn typcn-flow-children"></i></h4>
              <p class="card-description text-center">
                Datos del estudio a modificar
              </p>
              <form action="" method="POST">
                  <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                <div class="form-group">
                  <label class="control-label"> Estudio</label>
                  <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" required
                  value="<?php echo $nombre; ?>">
                </div>
                
                <div class="form-group">
                  <label class="control-label">Precio Seguro</label>
                  <input class="form-control" type="text" name="seguro" id="seguro" placeholder="Ingrese el monto" required 
                  value="<?php echo $seguro; ?>">
                </div>

              

                <div class="form-group">
                  <label class="control-label">Precio Preferencial</label>
                  <input class="form-control" type="text" name="preferencial" id="preferencial" placeholder="Ingrese el monto" required
                  value="<?php echo $preferencial; ?>">
                </div>


                <div class="form-group">
                  <label class="control-label">Precio Hospitalarios</label>
                  <input class="form-control" type="number" name="hospitalario" id="hospitalario" placeholder="Ingrese el monto"
                  value="<?php echo $hospitalario; ?>">
                </div>

                <button type="submit" class="btn btn-primary mr-2">Actualizar</button>
                <a class="btn btn-light" href="../Templates/estudios.php">Cancelar</a>
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