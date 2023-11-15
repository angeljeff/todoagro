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
  
  <?php
  include("../carpeta_css/stylesheet_css.php");
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
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
            <h1>Productos Plántulas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Productos Plántulas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col ">
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Hortaliza</h3>
              </div>
              <!-- /.card-header -->
              <form id="form1" action="../bd-archivo/ingreso-hortaliza.php" method="post" onsubmit="return guardar('form1', 'Tipo de bandejas guardado correctamente.')">
              <input type="hidden" name="form_id" value="hortalizaForm">
                <div class="card-body">
                        <!-- text input -->
                        <div class="row">
                          <div class="form-group col">
                            <label>Hortaliza</label>
                            <input type="text" class="form-control" id="hortaliza" name="hortaliza" placeholder="Ingrese producto">
                          </div>
                          <div class="form-group col">
                            <br>
                            <button type="button" class="btn btn-light" id="btnAgregar" onclick="abrirModal('ingreso-variedad')">
                              <i class="fa fa-plus-square" aria-hidden="true"></i>
                            </button>
                          </div> 
                          <div class="form-group col">
                            <br>
                            <button type="button" class="btn btn-light" id="btnAgregarBandejas" onclick="abrirModal('Bandejas')">
                              <i class="fa fa-plus-square" aria-hidden="true"></i> Agregar Bandejas
                            </button>
                          </div>
                        </div>
                        <div class="row">
                        <div class="form-group col">
                          <label><i class="far fa-clock"></i> Dias de producción: </label>
                          <input type="number" class="form-control" id="diapro" name="diapro">
                        </div>
                        <div class="form-group col">
                          <label><i class="far fa-clock"></i> Dias en camara: </label>
                          <input type="number" class="form-control" id="diacamara" name="diacamara" >
                        </div> 
                        </div>           
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary"
                ><i class="fa fa-save" aria-hidden="true"></i> Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal" id="ingreso-variedad" aria-hidden="true" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success">
                <h3 class="card-title">Tipo de Hortaliza</h3>
              </div>
              <form id="form2" action="../bd-archivo/ingreso-variedad.php" method="post" onsubmit="return guardar('form2', 'Variedad de semillas guardada correctamente.')">
                <input type="hidden" name="form_id" value="variedad_semilla">
                  <!-- /.card-header -->
                  <div class="card-body">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Hortaliza</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="nombrehortaliza">
                            <option value="" disabled selected>Seleccione un elemento</option> <!-- Opción por defecto -->
                              <?php
                                // Realiza una consulta SQL para obtener los roles desde la tabla "roles"
                                $query = "SELECT HortalizaID, NombreHortaliza FROM hortalizas";
                                $result = $db->query($query);
                                
                                // Itera a través de los resultados y crea opciones para el campo select
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['HortalizaID'];
                                    $nombrehortalizas = $row['NombreHortaliza'];
                                    echo "<option value='$id'>$nombrehortalizas</option>";
                                }
                              ?>
                            </select>
                      </div>
                      <div class="form-group">
                      <label>Variedad de semillas</label>
                      <input type="text" id="variedadsemilla" name="variedadsemilla" class="form-control">    
                      </div> 
                      <div class="form-group">
                        <label>Color</label>
                        <input type="color" id="colorPicker" name="color" class="form-control">
                      </div>                
                  </div>
                  <!-- /.card-body -->
                  <div class="modal-footer d-flex justify-content-between">
                      <button type="button" class="btn btn-danger" onclick="cerrarModal()">
                          <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                      </button>
                      <button type="submit" class="btn btn-outline-primary"
                          onclick="return guardar('form2', 'Variedad de semillas guardada correctamente.')">
                          <i class="fa fa-save" aria-hidden="true"></i> Guardar
                      </button>
                  </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal" id="Bandejas" aria-hidden="true" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success">
                <h3 class="card-title">Bandejas</h3>
              </div>
              <form id="form3" action="../bd-archivo/ingreso-variedad.php" method="post" onsubmit="return guardar('form3', 'Tipo de bandejas guardado correctamente.')">
                <input type="hidden" name="form_id" value="tipo_bandejas">
                <div class="card-body">
                        <div class="form-group">
                          <label>Tipo de bandeja</label>
                          <input type="number" id="tipobandeja" name="tipobandeja" class="form-control"> 
                        </div>                
                  <div class="table-responsive ">
                          <table id="tabla2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>Nombre</th>
                              <th>Estado</th>                                    
                            </tr>
                            </thead>
                            <tbody>
                              <?php
                              $select = "select * from tipobandeja";
                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                              ?>
                              <tr>
                                <td><?php echo $fila['TipoBandejaID']; ?></td>
                                <td><?php echo $fila['Nombre']; ?></td>
                                <td class="project-actions text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarElemento(<?php echo $fila['TipoBandejaID']; ?>, 'tipobandeja')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                            
                          </table>               
                  </div>
                <!-- /.card-body -->
                  <div class="modal-footer d-flex justify-content-between">
                      <button type="submit" class="btn btn-outline-primary"> <i class="fa fa-save" aria-hidden="true"></i></button>
                      <button type="button" class="btn btn-danger" onclick="cerrarModalBandejas()">
                            <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                      </button>
                  </div>
                </div>             
              </form>  
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Datos de Productos</h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <div class="row">
          <div class="col">
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  LISTA DE PRODUCTOS
                </h3>
              </div>             
              <div class="card-body table-responsive ">
                    <table id="tabla1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Hortaliza</th>
                        <th>Variedad</th>
                        <th>Días Produccion</th>
                        <th>Días Camara</th>                                  
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                              $select = "select h.*,  
                              v.NombreVariedad
                              from hortalizas h 
                              INNER JOIN variedades v ON h.HortalizaID=v.HortalizaID "; 
                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                              ?>
                              <tr>
                                <td><?php echo $fila['NombreHortaliza']; ?></td>
                                <td><?php echo $fila['NombreVariedad']; ?></td>
                                <td><?php echo $fila['DiaProduccion']; ?></td>
                                <td><?php echo $fila['DiaCamara']; ?></td>
                              </tr>
                          <?php } ?>
                      </tbody>
                      
                    </table>               
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>   
  
      </div><!-- /.container-fluid -->
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
  <?php
  include("../carpeta_css/script_js.php");
  ?>
<!-- Page specific script -->
<script>

  function crearHortaliza() {
    // Tu código para mostrar el modal, por ejemplo:
      $('#modal-hortaliza-agg').modal('show');
  }


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
    // Inicializa TinyColorPicker en el campo de entrada de color
    $("#colorPicker").minicolors({
        control: "wheel", // Cambia el tipo de selector de colores según tus preferencias
        format: "hex", // Formato preferido para almacenar el color en la base de datos
    });

    $('#tabla1').DataTable($.extend({}, commonOptions));
    $('#tabla2').DataTable($.extend({}, commonOptions));
    // Agrega más tablas aquí si es necesario
});


function guardar(formId, successMessage) {
  const formulario = document.getElementById(formId);
  const campo = formulario.querySelector('input[type="text"], input[type="number"], select, textarea');
  const valorCampo = campo.value.trim();

  if (!valorCampo) {
    Swal.fire({
      title: 'Error',
      text: 'Por favor, complete todos los campos.',
      icon: 'error'
    });
    return false;
  }

  // Realiza una solicitud AJAX para enviar los datos al servidor
  $.ajax({
    type: "POST",
    url: formulario.action,
    data: new FormData(formulario),
    processData: false,
    contentType: false,
    success: function (response) {
      // Muestra un mensaje de éxito
      Swal.fire({
        title: 'Guardado',
        text: successMessage,
        icon: 'success',
        timer: 1000, // La alerta se cierra después de 1 segundo (1000 ms)
        timerProgressBar: true,
        showConfirmButton: false // Oculta el botón de confirmación
      }).then(() => {
        var modal = document.getElementById(formId === 'form2' ? 'ingreso-variedad' : 'Bandejas');
        modal.style.display = 'none';
        formulario.reset(); // Limpia el formulario
        setTimeout(function() {
        location.reload();
      }, 1000); 
      });
    },
    error: function (error) {
      // Muestra un mensaje de error si la solicitud falla
      Swal.fire({
        title: 'Error',
        text: 'Hubo un problema al guardar los datos.',
        icon: 'error'
      });
    }
  });

  return false;
}


  function eliminarElemento(id, tipo) {
      // Mostrar un mensaje de confirmación usando SweetAlert2
      Swal.fire({
          title: '¿Estás seguro?',
          text: 'Esta acción eliminará el elemento. ¿Estás seguro de que deseas continuar?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar'
      }).then((result) => {
          if (result.isConfirmed) {
              // Realizar una solicitud POST para eliminar el elemento
              const xhr = new XMLHttpRequest();
              xhr.open('POST', '../bd-archivo/eliminar-plantulas.php');
              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              xhr.onload = function () {
                  if (xhr.status === 200) {
                      // La respuesta se mostrará en la consola o en un mensaje en la interfaz de usuario
                      console.log(xhr.responseText);
                      Swal.fire({
                          title: 'Eliminado',
                          text: 'El elemento ha sido eliminado correctamente.',
                          icon: 'success',
                          timer: 3000,  // La alerta se cierra después de 3 segundos (3000 ms)
                          timerProgressBar: true
                      }).then(() => {
                          window.location.reload("../UI/Administrativo-productos-plantulas.php");
                      });
                  } else {
                      console.error('Error al eliminar el elemento');
                      Swal.fire({
                          title: 'Error',
                          text: 'Hubo un error al eliminar el elemento.',
                          icon: 'error',
                          timer: 3000,  // La alerta se cierra después de 3 segundos (3000 ms)
                          timerProgressBar: true
                      });
                  }
              };
              xhr.send('id=' + id + '&tipo=' + tipo);
          }
      });
  }


  $(function () {
  bsCustomFileInput.init();
  });


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

  function abrirModal(modalId) {
  var modal = document.getElementById(modalId);
  modal.style.display = 'block';
}

function cerrarModal() {
  var modal = document.getElementById('ingreso-variedad'); 
  modal.style.display = 'none';
}

function cerrarModalBandejas() {
  var modal = document.getElementById('Bandejas'); 
  modal.style.display = 'none';
}


</script>
</body>
</html>
