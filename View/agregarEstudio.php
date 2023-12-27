<?php
require_once("../includes/header_admin.php");
require_once('../Controllers/grabarEstudio.php');
?>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center">Agregar Estudio <i class="typcn typcn-flow-children"></i></h4>
              <p class="card-description text-center">
                Datos del estudio a grabar
              </p>
              <form class="forms-sample" method="POST" action="">
              <div class="form-group">
              <div class="form-group">
                  <label class="control-label">Estudio</label>
                  <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" required>
                </div>

                 <div class="form-group">
                    <label class="control-label">Precio Seguro</label>
                    <input class="form-control" type="text" name="seguro" id="seguro" placeholder="Ingrese el monto" required>
                  </div>



                <div class="form-group">
                  <label class="control-label">Precio Normal</label>
                  <input class="form-control" type="text" name="preferencial" id="preferencial" placeholder="Ingrese el monto" required>
                </div>

                <div class="form-group">
                  <label class="control-label">Precio Hospitalarios</label>
                  <input class="form-control" type="text"  name=" hospitalario" id=" hospitalario"  placeholder="Ingrese el monto">
                </div>

                <div class="form-group">
                  <label class="control-label">Categoria Estudio</label>
                  <select class="chosen form-control" name="categoria_id" id="categoria_id" required data-placeholder="Seleccione la Categoria">
                    <?php
                    $raw_results4 = mysqli_query($conection, "SELECT  * FROM  categoria_estudio WHERE estatus = 1") or die(mysqli_error($conection));
                    while ($results = mysqli_fetch_array($raw_results4)) {
                    ?>
                      <option value=" <?php echo $results['id'] ?> ">
                        <?php echo $results['descripcion']; ?>
                      </option>

                    <?php
                    }
                    ?>
                  </select>
                </div>

                  <input type="hidden" name="estatus" id="estatus" value="1">
                <button type="submit" class="btn btn-primary mr-2">Registrar</button>
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