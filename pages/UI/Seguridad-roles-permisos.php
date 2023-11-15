<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Modals & Alerts</title>

  <link rel="icon" href="../img/logo.webp" type="image/x-icon">
  <script src="jquery-3.6.4.js"> </script> <!-- llamar archivos funciones -->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> 
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  
  <!-- Navbar -->
  <?php
  include("../menu/menu_arriba.php")
  ?>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <?php
  include("../menu/menu.php")
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              ROLES Y PERMISOS
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Roles y permisos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content overflow-auto">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Roles y permisos
                </h3>
              </div>             
              <div class="card-body">
                <button type="button" class="btn btn-default text-primary" onclick="crearRol()" >
                  Agregar nuevo rol 
                  <i class="nav-icon far fa-plus-square"></i>
                </button>
                <br> </br>
                <div class="card-body table-responsive p-0">
                  <table border=1 class="table table-bordered " id="tablita">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Acciones</th>                                          
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select = "SELECT * from rol ";
                          $resp = $db->query($select);
                          while($fila = $resp->fetch_array()){
                          ?>
                          <tr>
                            <td><?php echo $fila['id_rol']; ?></td>
                            <td><?php echo $fila['nombreid']; ?></td>
                            <td><?php echo $fila['desc']; ?></td>
                            <td class="project-actions text-center">
                            <!-- <button type="button" class="btn btn-light btn-sm" onclick="mostrarpermiso(<?php echo $fila['id_rol']; ?>)">
                              <i class="fas fa-key"></i> Permiso
                            </button> /.card -->
                            <button type="button" class="btn btn-info btn-sm" onclick="editarRol('Trident','Internet','gjyfh')">
                            <i class="fas fa-pencil-alt"></i>Editar     
                            </button>
                            </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                  </table> 
                </div>       
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->

      <div class="modal" id="modal-rol-agg" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Roles Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <!-- /.nombre y apellidos -->
                  <div class="form-group">
                    <label>Nombre rol:</label>
                    <div class="row">
                      <div class="input-group col-md-12">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" id="rol" name="Rrol">
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group --> 
                  <div class="form-group">
                    <label>Estado:</label>
                    <div class="row">
                      <div class="input-group col-md-12">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                        </div>
                        <select class="form-control select2" style="width: 70%;" id="estado" name="Restado">
                          <option>Activo</option>
                          <option>Inactivo</option>
                        </select> 
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>                 
                  <!-- /.Cedula -->
                  <div class="form-group">
                    <label>Descripción:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-audio-description"></i></span>
                      </div>
                      <textarea type="" class="form-control" id="desc" name="Ddesc"></textarea>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group --> 
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal" id="editar-rol" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Roles Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <!-- /.nombre y apellidos -->
                  <div class="form-group">
                    <label>Nombre rol:</label>
                    <div class="row">
                      <div class="input-group col-md-12">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" id="RrolR" name="Rrol">
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group --> 
                  <div class="form-group">
                    <label>Estado:</label>
                    <div class="row">
                      <div class="input-group col-md-12">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-tasks"></i></span>
                        </div>
                        <select class="form-control select2" style="width: 70%;" id="RestadoR" name="Restado">
                          <option>Activo</option>
                          <option>Inactivo</option>
                        </select> 
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>                 
                  <!-- /.Cedula -->
                  <div class="form-group">
                    <label>Descripción:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-audio-description"></i></span>
                      </div>
                      <textarea type="" class="form-control" id="RdescR" name="DdescR"></textarea>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group --> 
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal" id="modal-permiso" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Roles Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Permisos</h3>
                    </div>
                    <!-- /.card-header -->
                    <form id="permisosForm" method="POST">
                      <div class="card-body table-responsive p-0" style="height: 445px;">
                      <input type="hidden" id="rolId" name="rolId" value=""> 
                      <table class="table table-head-fixed text-nowrap">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Módulo</th>
                              <th>Ver</th>
                              <th>Crear</th>
                              <th>Actualizar</th>
                              <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>Dashborad</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_dashboard][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_dashboard][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_dashboard][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_dashboard][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Seguridad</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_seguridad][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguridad][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguridad][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguridad][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>Administrativo</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_administrativo][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_administrativo][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_administrativo][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_administrativo][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>Pedido</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_pedido][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_pedido][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_pedido][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_pedido][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>Planificación</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_planificacion][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_planificacion][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_planificacion][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_planificacion][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>Seguimiento</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_seguimiento][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguimiento][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguimiento][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_seguimiento][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>Reportes e informes</td>
                              <td>
                                <!-- Bootstrap Switch -->
                                <input type="checkbox" name="permisos[modulo_reportes][r]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">                                                             
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_reportes][w]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_reportes][u]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                              <td>
                                <input type="checkbox" name="permisos[modulo_reportes][d]" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </form>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" name="guardarPermisos">Guardar Permisos</button>
            </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Toastr -->
<script src="../../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  });


  var commonOptions = {
    "language": {
                "processing": "Procesando...",
                "lengthMenu": "Ver _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Sig.",
                    "previous": "Ant."
                },
    }
  };

$(document).ready(function() {
    $('#tablita').DataTable($.extend({}, commonOptions));
    // Agrega más tablas aquí si es necesario
});

  function eliminar(id){
  swal({
          title: 'Todo Agro',
          text: "Desea eliminar el registro?",
          type: "info",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#dd3333',
          confirmButtonText: 'Aceptar',
          cancelButtonText: 'Cancelar'
      },
      function() {
          window.location.href = "eliminarDatos.php?id=" + id;
      });
}

  function crearRol(){
  $("#modal-rol-agg").modal("show");
  }

  function mostrarpermiso(){
  $("#modal-permiso").modal("show");
  }


// Asocia la función a la acción del botón
$(document).ready(function() {
    $('button.btn-primary').click(function() {
        guardarPermisos();
    });
});


  function editarRol(Rrol,Restado,DdescR){
  $("#editar-rol").modal("show");
  $("#RrolR").val(Rrol);
  $("#RestadoR").val(Restado);
  $("#RdescR").val(DdescR);
  }

  $(function () {
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
</script>
<script>
    // Evitar que el usuario retroceda usando el botón del navegador
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };

    // Redirigir a dashboard.php cuando el usuario intenta retroceder
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        window.location.href = "../../dashboard.php";
    });
</script>
</body>
</html>
