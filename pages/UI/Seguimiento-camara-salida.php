<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
  }

  include("../bd-archivo/consulta-calendario.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Calendar</title>

  <?php
    include("../carpeta_css/stylesheet_css.php");
  ?>
</head>

<body class="hold-transition sidebar-mini">
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
            <h1>Salida de Cámara de Germinación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Camara</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Modal para detalles de eventos -->
  <!-- Modal para detalles de eventos -->
    <div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="eventoModalLabel">Detalles del Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <!-- Mostrar detalles del evento en elementos HTML personalizados -->
                    <div class="evento-detalle">
                        <label>Título:</label>
                        <input type="text" class="form-control" id="eventoTitulo" disabled>
                    </div><br>

                    <div class="row justify-content-center evento-detalle">
                        <label for="input1">N°:</label>
                        <input style="width: 50px;" class="form-control" id="eventoId" name="eventoId"  disabled>
                        <input style="width: 50px;" class="form-control" id="eventoCamara" name="eventoCamara" disabled>
                    </div>
                    <div class="row evento-detalle">
                        <div class="col evento-detalle">
                            <label for="input2">Cliente:</label>
                            <input type="text" disabled  name="input1" id="eventoCliente" class="form-control">
                        </div>
                        <div class="col evento-detalle">
                            <label for="input3">Producto:</label>
                            <input type="text" disabled  name="input2" id="eventoProducto" class="form-control">
                        </div>
                        <div class="col evento-detalle">
                            <label for="input4">B.sembrada:</label>
                            <input type="text" disabled  name="input3" id="eventoSebradas" class="form-control">
                        </div>
                    </div>

                    <div class="row evento-detalle">
                        <div class="col">
                            <label for="input5">B.pedidas:</label>
                            <input type="text" disabled  name="input1" id="eventoBandeja" class="form-control">
                        </div>
                        <div class="col">
                            <label for="input6">Plantas:</label>
                            <input type="text" disabled  name="input2" id="eventoPlantas" class="form-control">
                        </div>
                        <div class="col">
                            <label for="input7">Semillas:</label>
                            <input type="text" disabled  name="input3" id="eventoSemillas" class="form-control">
                        </div>
                    </div>

                    <div class="row evento-detalle">
                        <div class="col">
                            <label for="input6">Fecha de ingreso a cámara:</label>
                            <input type="text" class="form-control" id="eventoFecha" name="eventoFecha" disabled>
                        </div>
                        <div class="col">
                            <label for="input7">Dias Transcuridos:</label>
                            <input type="text" disabled  name="input1" id="diasTranscurridos" class="form-control">
                        </div>
                        <div class="modal-body d-flex justify-content-center align-items-center">
                            <div class="row justify-content-center">
                              <div class="col-md-6">
                                  <br>
                                  <button type="button" class="btn btn-outline-warning" onclick="faltagerminar()">
                                  <i class="fa fa-exclamation-circle"></i> Falta  germinar
                                  </button>
                              </div>
                              <div class="col-md-6">
                                  <br>
                                  <button type="button" class="btn btn-outline-success" onclick="enviarMesada()">
                                    <i class="fas fa-paper-plane"></i> Enviar mesada
                                  </button>
                              </div>
                            </div>
                        </div>
                    </div>

                    <!-- Agrega más detalles según tus necesidades -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

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
  document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
          locale: 'es',
          headerToolbar: {
              left  : 'prev,next today',
              center: 'title',
              right : 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          themeSystem: 'bootstrap',
          events: <?php echo json_encode($events); ?>,
          editable  : true,
          eventClick: function(info) {
              // Cuando se hace clic en un evento, muestra los detalles en el modal
              $('#eventoId').val(info.event.id);
              $('#eventoCamara').val(info.event.extendedProps.Camara);
              $('#eventoTitulo').val(info.event.title);
              $('#eventoFecha').val(info.event.start.toLocaleDateString() + ' ' + info.event.start.toLocaleTimeString());
              $('#eventoCliente').val(info.event.extendedProps.cliente);
              $('#eventoProducto').val(info.event.extendedProps.producto);
              $('#eventoBandeja').val(info.event.extendedProps.bandejas);
              $('#eventoPlantas').val(info.event.extendedProps.plantas);
              $('#eventoSemillas').val(info.event.extendedProps.semillas);
              $('#eventoSebradas').val(info.event.extendedProps.sembradas);
              

              // Calcular los días transcurridos
              var fechaEvento = moment(info.event.start); // Convierte la fecha a un objeto moment.js
              var fechaActual = moment(); // Obtiene la fecha y hora actual
              var diasTranscurridos = fechaActual.diff(fechaEvento, 'days');

              // Formatear la fecha para mostrarla en el campo correspondiente
              var fechaFormateada = fechaEvento.format('YYYY-MM-DD HH:mm:ss');

              // Mostrar los días transcurridos y la fecha formateada en los campos correspondientes
              $('#diasTranscurridos').val(diasTranscurridos + ' días');
              $('#eventoFecha').val(fechaFormateada);

              // Abre el modal
              $('#eventoModal').modal('show');
          }
      });

      calendar.render();
  });
  
  $('#faltagerminarBtn').click(function() {
    // Ejecuta la función para enviar a invernadero
    faltagerminar();
  });
  
  function faltagerminar() {
    // Aquí realizamos la solicitud AJAX
    $.ajax({
      type: 'POST', // O el método que necesites (GET, POST, etc.)
      url: '../bd-archivo/manejar_eventos.php', // Reemplaza con la URL de tu script PHP
      data: {
          codigo_pedido: $('#eventoId').val() // Puedes enviar datos adicionales si es necesario
      },
      success: function(data) {

        // La solicitud AJAX se completó con éxito
        // Puedes realizar acciones adicionales aquí si es necesario
        Swal.fire({
          icon: 'info', // Ícono de éxito
          title: 'Falta Germinar por lo que se queda en Cámara',
          showConfirmButton: false, // No mostrar el botón "Aceptar" (puede cambiarlo si lo deseas)
          timer: 3000 // Tiempo en milisegundos que se muestra la notificación (1.5 segundos en este ejemplo)
        });
        $('#eventoModal').modal('hide'); // Cierra el modal

      

      },
      error: function(xhr, status, error) {
          // Ocurrió un error durante la solicitud AJAX
          alert('Error al enviar el pedido a Cámara: ' + error);
      }
    });
  }

  function enviarMesada() {
  const numBandejas = document.getElementById('eventoBandeja').value;
  const pedidoId = document.getElementById('eventoId').value;  // Obtener el ID del pedido
  // Redirigir a Mesadas-inverndaero.php y enviar la cantidad de bandejas como parámetro de URL
  window.location.href = `../UI/Mesadas-invernadero.php?numBandejas=${numBandejas}&pedidoId=${pedidoId}`;
}


</script>
</body>
</html>

