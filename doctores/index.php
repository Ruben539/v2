<?php
    include('Controllers/inicioDoctoresController.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistema Diax</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
              <div class="brand-logo">
                <img src="../assets/images/logo.png" alt="logo">
              </div>
              <h2>Doctores Diax </h2>
              <h4 class="font-weight-light">Iniciar Sesión para Continuar.</h4>
              <form class="pt-3" method="POST" >
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="usuario" name="usuario" placeholder="Usuario" style="border: 1px solid black; color:black;">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Contraseña" style="border: 1px solid black; color:black;"> 
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">Iniciar Sesión</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                               
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
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <script src="../js/funcionesDoctores.js"></script>
  <!-- endinject -->
</body>

</html>
