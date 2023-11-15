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
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="jquery-3.6.4.js"> </script> <!-- llamar archivos funciones -->
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


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
              Cámara Germinación
            </h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Camara</li>
            </ol>
          </div>
          
        </div>
        <div class="justify-content-center align-content-center">
          <label>Seleccionar pedido a sembrar :</label>
        </div>
        <button type="button" class="btn btn-outline-success"  onclick="crearSiembra()">
          <i class="fas fa-seedling">
          </i> Enviar a sembrar</button>
        <br><br>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content overflow-auto">
      <div class="modal" id="modal-camara" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            
            <div class="modal-header bg-gradient-success">
              <h5 class=" modal-title">Cámara de germinación</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
                  <!-- /.nombre y apellidos -->
                  <div class="form-group">
                    <div class="row justify-content-center">
                      <label for="input1">N°:</label>
                          <input style="width: 50px;" type="text" disabled ="input1" name="input1" class="form-control">
                    </div>
                    <div class="row">
                      <div class="col">
                          <label for="input2">Cliente:</label>
                          <input type="text" disabled ="input2" name="input1" class="form-control">
                      </div>
                      <div class="col">
                          <label for="input3">Producto:</label>
                          <input type="text" disabled id="input3" name="input2" class="form-control">
                      </div>
                      <div class="col">
                          <label for="input4">B.sembrada:</label>
                          <input type="text" disabled id="input4" name="input3" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                          <label for="input5">B.pedidas:</label>
                          <input type="text" disabled ="input5" name="input1" class="form-control">
                      </div>
                      <div class="col">
                          <label for="input6">Plantas:</label>
                          <input type="text" disabled id="input6" name="input2" class="form-control">
                      </div>
                      <div class="col">
                          <label for="input7">Semillas:</label>
                          <input type="text" disabled id="input7" name="input3" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                          <label for="input6">Fecha ingreso cámara:</label>
                          <input type="date" disabled ="input6" name="input1" class="form-control">
                      </div>
                      <div class="col">
                        <label for="input7">Dias Transcuridos:</label>
                        <input type="text" disabled ="input7" name="input1" class="form-control">
                    </div>
                    <div class="modal-body d-flex justify-content-center align-items-center">
                      <div class="row justify-content-center">
                        <div class="col">
                            <br>
                            <button type="button" class="btn btn-outline-danger" onclick="crearSiembra()">
                                <i class="fa fa-ban"></i> Sacar de cámara
                            </button>
                        </div>
                        <div class="col">
                          <br>
                            <button type="button" class="btn btn-outline-warning" onclick="crearSiembra()">
                              <i class="fa fa-exclamation-circle"></i> Falta germinar
                            </button>
                        </div>
                        <div class="col">
                            <br>
                            <button type="button" class="btn btn-outline-success" onclick="crearSiembra()">
                              <i class="fas fa-paper-plane"></i> Enviar a invernadero
                            </button>
                        </div>
                      </div>
                    </div>
                  </div>              
                  <!-- /.form group -->   
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary">Sembrar</button>
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
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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
      $('#example1').DataTable($.extend({}, commonOptions));
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

  function crearSiembra(){
  $("#modal-camara").modal("show");
  }


  $(function () {
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  })

  function mostrarFechaDia() {
            var fechaActual = new Date();
            var opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var formatoFecha = fechaActual.toLocaleDateString(undefined, opcionesFecha);

            // Obtener el día de la semana en mayúsculas
            var diaSemana = formatoFecha.split(',')[0].toUpperCase();
            var restoFormato = formatoFecha.split(',').slice(1).join(',');

            var formatoFinal = diaSemana + restoFormato;

            document.getElementById("fechaDia").textContent = formatoFinal;
  }

  // Llama a la función para mostrar la fecha y día actual al cargar la página
  mostrarFechaDia();
  
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })
</script>
</body>
</html>
