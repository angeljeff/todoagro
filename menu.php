<?php
include_once("bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$nombreUsuario = $_SESSION['usuario'];
$rol = $_SESSION['id_rol'];

// Restringir acceso según el rol
if ($rol == 1) {
  $allowedModules = [
    'Dashboard',
    'Seguridad',
    'Administrador',
    'Pedido',
    'Planificación',
    'Seguimiento de producción',
    'Plagas y Enfermedades',
    'Entregados'
  ];
} elseif ($rol == 2) {
  $allowedModules = [
    'Seguimiento de producción',
    'Plagas y Enfermedades',
    'Entregados'
  ];
}  else {
  // Otros roles tendrán acceso a todos los módulos
  $allowedModules = [
  ];
}
$select = "SELECT u.*, r.nombreid AS nombrerol, r.id_rol
           FROM usuarios u 
           INNER JOIN rol r ON u.rol_Id = r.id_rol 
           WHERE u.usuario = '$nombreUsuario'";  // Filtrar por el nombre de usuario

$resp = $db->query($select);
while ($fila = $resp->fetch_array()) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $nombreCompleto = $nombre . " " . $apellido;
    $nombreRol = $fila['nombrerol'];
    $id = $fila['id_rol'];
}
?>
<aside class="main-sidebar sidebar-dark-teal elevation-4" >
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="pages/img/logo.webp" alt="Logo TODOAGRO" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light ">TODO AGRO</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $nombreCompleto ?></a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <?php
        foreach ($allowedModules as $module) {
          echo '<li class="nav-item">';
          if ($module == 'Dashboard') {
            echo '<a href="dashboard.php" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
            </ul>
          </li>';

          } elseif ($module == 'Seguridad') {
            echo '<li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Seguridad
                    <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pages/UI/Seguridad-roles-permisos.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rol y Permiso</p>
                      </a>
                    </li>
                  </ul>
                  </li>';
          } elseif ($module == 'Administrador') {
            echo '<li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tree"></i>
                    <p>Administrador
                    <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pages/UI/Administrativo-usuarios.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Empleado y usuarios</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Administrativo-insumo.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Insumos</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Administrativo-productos-plantulas.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Producto plántulas</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Administrativo-variedad.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tipo y variedad de plántulas - Bandejas</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Administrativo-mesadas.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Mesones</p>
                      </a>
                    </li>
                  </ul>
                  </li>';
          } elseif ($module == 'Pedido') {
            echo '<li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>Pedido
                    <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pages/UI/Pedido.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Agregar Pedido</p>
                      </a>
                    </li>
                  </ul>
                  </li>';
          } elseif ($module == 'Planificación') {
            echo '<li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-calendar-minus"></i>
                    <p>Planificación
                    <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pages/UI/Planificacion-pedido.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Agregar Planificación</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Planificación-listado.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listado Planificación</p>
                      </a>
                    </li>
                  </ul>
                  </li>';
          } elseif ($module == 'Seguimiento de producción') {
            echo '<li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>Seguimiento de producción
                    <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="pages/UI/Seguimiento-siembra.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Siembra</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Seguimiento-camara-entrada.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cámara de germinación</p>
                        <i class="fas fa-angle-left right"></i>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="../UI/Seguimiento-camara-entrada.php" class="nav-link">
                            <p>Entrada</p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="../UI/Seguimiento-camara-salida.php" class="nav-link">
                            <p>Salida</p>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="pages/UI/Seguimiento-trasplantes.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transplante/Invernadero</p>
                      </a>
                    </li>
                  </ul>
                  </li>';
          } elseif ($module == 'Entregados') {
            echo '<li class="nav-header">Entregados</li>
                  <li class="nav-item">
                  <a href="pages/UI/Seguimiento-pedido-listo.php" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>Enviar Entrega</p>
                  </a>
                  </li>';
            echo '<li class="nav-item">
                  <a href="../gallery.php" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <p>Lista de Entregados</p>
                  </a>';
          }
          echo '</li>';
        }
        ?>

      </ul>
    </nav>
  </div>
</aside>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
