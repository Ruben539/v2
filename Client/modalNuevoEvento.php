<link rel="stylesheet" href="../node_modules/chosen-js/chosen.min.css" type="text/css" />
<script src="../assets/js/jquery-3.3.1.min.js"></script>
<script src="../node_modules/chosen-js/chosen.jquery.min.js"></script>
<script src="../node_modules/chosen-js/chosen.jquery.js"></script>
<script>
  $(document).ready(function() {
    $(".chosen").chosen();

  });
</script>
<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Agendimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="formEvento" id="formEvento" action="nuevoEvento.php" class="form-horizontal" method="POST">
        <div class="form-group">
          <label for="evento" class="col-sm-12 control-label">Medico Tratante</label>
          <div class="col-sm-10">
            <select class="chosen form-control" name="doctor_id" id="doctor_id" required data-placeholder="Seleccione un Medico">
              <option value="" id="nombre" name='nombre'></option>
              <?php
              $raw_results4 = mysqli_query($conection, "select * from medicos;") or die(mysqli_error($conection));
              while ($results = mysqli_fetch_array($raw_results4)) {
              ?>

                <option value=" <?php echo $results['id'] ?> ">
                  <?php echo $results['nombre']; ?>
                </option>

              <?php
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="nombre" class="col-sm-12 control-label">Nombre del Paciente</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Paciente" required />
          </div>
        </div>

        <div class="form-group">
          <label for="agenda" class="col-sm-12 control-label">Motivo de la consulta</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="agenda" id="agenda" placeholder="Motivo de la consulta" required />
          </div>
        </div>
        <div class="form-group">
          <label for="fecha_inicio" class="col-sm-12 control-label">Fecha Inicio</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio">
          </div>
        </div>
        <div class="form-group">
          <label for="fecha_fin" class="col-sm-12 control-label">Fecha Final</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final">
          </div>
        </div>

        <div class="col-md-12" id="grupoRadio">

          <input type="radio" name="color_evento" id="orange" value="#FF5722" checked>
          <label for="orange" class="circu" style="background-color: #FF5722;"> </label>

          <input type="radio" name="color_evento" id="amber" value="#FFC107">
          <label for="amber" class="circu" style="background-color: #FFC107;"> </label>

          <input type="radio" name="color_evento" id="lime" value="#8BC34A">
          <label for="lime" class="circu" style="background-color: #8BC34A;"> </label>

          <input type="radio" name="color_evento" id="teal" value="#009688">
          <label for="teal" class="circu" style="background-color: #009688;"> </label>

          <input type="radio" name="color_evento" id="blue" value="#2196F3">
          <label for="blue" class="circu" style="background-color: #2196F3;"> </label>

          <input type="radio" name="color_evento" id="indigo" value="#9c27b0">
          <label for="indigo" class="circu" style="background-color: #9c27b0;"> </label>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Registrar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        </div>
      </form>

    </div>
  </div>
</div>