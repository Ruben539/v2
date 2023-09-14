<nav class="navbar-breadcrumb col-xl-12 col-12 d-flex flex-row p-0">
   
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item ml-0">
            <h4 class="mb-0">Dashboard</h4>
          </li>
          <li class="nav-item">
            <div class="d-flex align-items-baseline">
              <p class="mb-0">Sistema Diax</p>
              <i class="typcn typcn-chevron-right"></i>
              <p class="mb-0">Sistema web en Desarrollo</p>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-search d-none d-md-block mr-0">
            
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close typcn typcn-times"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div>
     
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../Templates/dashboard.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-group menu-icon"></i>
              <span class="menu-title">Usuarios</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/usuarios.php">Usuarios Activos</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/usuariosInactivos.php">Usuarios Inactivos</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="typcn typcn-vendor-android menu-icon"></i>
              <span class="menu-title">Roles</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="../Templates/roles.php">Roles del Sistema</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Clientes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/clientes.php">Buscar Cliente</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#fabiola" aria-expanded="false" aria-controls="fabiola">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Info. Fabiola</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="fabiola">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../Templates/listadoPacientesFabiola.php">Lista Paciente</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/buscarPacienteFabiola.php">Buscar Paciente </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/rendicionFabiola.php">Rendiciones </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#elena" aria-expanded="false" aria-controls="elena">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Info. Elena</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="elena">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/listadoPacientesElena.php">Lista Paciente</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/buscarPacienteElena.php">Buscar Paciente </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/rendicionElena.php">Rendiciones </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#comprobantes" aria-expanded="false" aria-controls="comprobantes">
              <i class=" typcn typcn-clipboard menu-icon"></i>
              <span class="menu-title">Comprobantes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="comprobantes">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/orden.php"> Registro de Paciente </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/ordenCanceladas.php"> Comprobante Cancelados</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/reporteDiario.php"> Reporte Diarios</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#medicos" aria-expanded="false" aria-controls="medicos">
              <i class="typcn typcn-group-outline menu-icon"></i>
              <span class="menu-title">Medicos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="medicos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/medicos.php">Lista de Medicos</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/medicosEliminados.php">Medicos Eliminados</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/rendicionesMedicos.php">Rendición de Medicos</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#especialidad" aria-expanded="false" aria-controls="especialidad">
              <i class="typcn typcn-flow-merge menu-icon"></i>
              <span class="menu-title">Especialidades</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="especialidad">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/especialidades.php">Especialidades</a></li>
                <li class="nav-item"> <a class="nav-link" href="../View/asignarEspecialidad.php">Asignar Especialidad</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/especialidadDoctor.php">Esp. Doctores</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <i class="typcn typcn-trash menu-icon"></i>
              <span class="menu-title">Eliminaciones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Extension/pedidoMedicos.php">Medicos</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Extension/pedidoGastos.php">Gastos</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Extension/OrdenesPendientes.php">Ordenes</a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/movimientosEliminados.php">Movimientos</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="typcn typcn-flow-children menu-icon"></i>
              <span class="menu-title">Estudios </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/estudios.php"> Lista de Estudios </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/estudiosEliminados.php"> Estudios Eliminados </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/rendicionEstudios.php"> Rendición de Estudios</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="typcn typcn-clipboard menu-icon"></i>
              <span class="menu-title">Gasto Diax</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/gastos.php"> Lista de Gastos </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/gastosCancelados.php"> Gastos Cancelados </a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#financiero" aria-expanded="false" aria-controls="financiero">
              <i class="typcn typcn-clipboard menu-icon"></i>
              <span class="menu-title">Mov. Financiero</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="financiero">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../Templates/movimientosFinacieros.php"> Lista de Movimientos </a></li>
                <li class="nav-item"> <a class="nav-link" href="../Templates/dashboardFinaciero.php"> Rendición Mensual </a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://bootstrapdash.com/demo/polluxui-free/docs/documentation.html">
              <i class="typcn typcn-mortar-board menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->