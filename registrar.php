<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PolluxUI Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
              <div class="brand-logo">
                <img src="assets/images/logo.png" alt="logo">
              </div>
              <h4>Aun no tienes una Cuenta. ?</h4>
              <h6 class="font-weight-light">Debes llenar todos los datos para registrarte.</h6>
              <form class="pt-3" >
              <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="cedula" name = "cedula"  placeholder="Ingrese su nro de Cedula">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="nombre" name = "nombre"  placeholder="Ingrese su nombre Completo">
                </div>
                <div class="form-group">
                  <input type="date" class="form-control form-control-lg" id="fecha_nac" name = "fecha_nac" placeholder="fecha de Nacimiento">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="correo" name = "correo"  placeholder="Ingrese su Correo">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="telefono" name="telefono" placeholder="Ingrese su numero de Telefono">
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="sexo" name="sexo">
                    <option value="">Seleccione una opción</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                  </select>
                </div>

                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Registrarme</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Ya tengo una Cuenta. ? <a href="index.php" class="text-primary">Inicio</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
