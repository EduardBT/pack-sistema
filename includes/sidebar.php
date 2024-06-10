<body>
  <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
    <a class="btn w-full text-truncate rounded-0 py-2 border-0 position-relative"
      style="z-index: 1000; text-align: center; color:#fff; font-size: 20px;  height: 50px;">
      <i class="bi bi-laptop"></i>
      SISTEMA ADMINISTRATIVO PACK EXPRESS URUGUAY
    </a>

  </header>
  <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
    <!-- Vertical Navbar -->
    <nav
      class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg"
      id="navbarVertical">
      <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse"
          aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
          <img src="img/iso2.png" alt="..." id="logo"><span>Pack Express<span>
        </a>
        <!-- User menu (mobile) -->
        <div class="navbar-user d-lg-none">
          <!-- Dropdown -->
          <div class="dropdown">
            <!-- Toggle -->
            <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <div class="avatar-parent-child">
                <img alt="Image Placeholder"
                  src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                  class="avatar avatar- rounded-circle">
                <span class="avatar-child avatar-badge bg-success"></span>
              </div>
            </a>
            <!-- Menu -->
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
              <a href="#" class="dropdown-item">Profile</a>
              <a href="#" class="dropdown-item">Settings</a>
              <a href="#" class="dropdown-item">Billing</a>
              <hr class="dropdown-divider">
              <a href="#" class="dropdown-item">Logout</a>
            </div>
          </div>
        </div>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">
          <!-- Navigation -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="main.php" style="font-size:18px">
                <i class="bi bi-layout-wtf"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gestion.php" style="font-size:18px">
                <i class="bi bi-people"></i> Clientes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="destinatario.php" style="font-size:18px">
                <i class="bi bi-person-lines-fill"></i>Destinatarios
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="guia.php" style="font-size:18px">
                <i class="bi bi-truck"></i> Embarque
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manifiesto.php" style="font-size:18px">
                <i class="bi bi-people"></i> Manifiesto
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="navbar-divider my-5 opacity-20">
          <!-- User (md) -->
          <ul class="navbar-nav">
            <li class="nav-item">

              <a class="nav-link" href="#" role="button" style="font-size:18px">
                <!--mostrar nombre de usuario-->
                <i class="bi bi-person-circle" style="margin-right:10px"></i>
                <?php echo $_SESSION["nombre_usuario"]; ?>
              </a>
            </li>
            <!-- <li class="nav-item"><a class="nav-link" href="perfil.php" style="font-size:18px"><i
                  class="bi bi-person"></i>Perfil</a>
            </li> -->
            <li class="nav-item"><a class="nav-link" href="pass.php" style="font-size:18px"><i
                  class="bi bi-asterisk"></i>Cambiar contraseña</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php" style="font-size:18px"><i
                  class="bi bi-box-arrow-left"></i>Salir</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</body>
<!-- <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <a href="gestion.php" class="nav-link">
            <?php
            //mostrar imagen de usuario
            $id = $_SESSION['id_usuario'];
            $query = "SELECT imagen FROM usuario WHERE id_usuario = '$id'";
            $result = mysqli_query($conexion, $query);
            while ($row = mysqli_fetch_array($result)) { ?>
              <?php echo "<img src='" . $row['imagen'] . "' class='logo'>"; ?>
            <?php } ?>
          </a>
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Clientes</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="nuevo-cliente.php">
                <span data-feather="file-text"></span>
                Nuevo Cliente
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gestion.php">
                <span data-feather="file-text"></span>
                Cartera de Clientes
              </a>
            </li>
          </ul>
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Presupuesto</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Nuevo Presupuesto
              </a>
            </li>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Embarque</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="multi_embarque.php">
                  <span data-feather="file-text"></span>
                  Nuevo Embarque
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="guia.php">
                  <span data-feather="file-text"></span>
                  Registro de Embarques
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="guia-cerrado.php">
                  <span data-feather="file-text"></span>
                  Embarques Cerrados
                </a>
              </li>
            </ul>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Manifiesto</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="nuevo_manifiesto.php">
                  <span data-feather="file-text"></span>
                  Nuevo Manifiesto
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manifiesto.php">
                  <span data-feather="file-text"></span>
                  Registro de Manifiestos
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="manifiesto-cerrado.php">
                  <span data-feather="file-text"></span>
                  Manifiestos Cerrados
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cliente-cheque.php">
                  <span data-feather="file-text"></span>
                  Cheques por cliente
                </a>
              </li>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 px-3"> -->