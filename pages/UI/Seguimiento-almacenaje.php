<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
    date_default_timezone_set('America/Guayaquil');
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Advanced form elements</title>

<?php
include("../carpeta_css/stylesheet_css.php")
?>
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
            <h1>Pedidos listos para ser entregados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Despacho</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-edit"></i>
                  Almacenaje y reservas de plantulas</h3>
              </div>
              <!-- /.card-header -->
              <form id="pedido" method="POST" action="../bd-archivo/ingreso-pedido.php">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row col-5">
                    <button id="agregarInfoButton" type="button" class="btn btn-outline-primary btn-block" data-target="#infoModal" disabled>
                      <i class="fa fa-paper-plane"></i> Realizar reservas
                    </button>
                    </div>
                </div>
                <div class="card-body table-responsive ">
                      <!-- Tabla para mostrar actividades anteriores -->
                      <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Orden</th>
                            <th>Producto</th>
                            <th>Mesada</th>
                            <th>Bandejas</th>
                            <th>Plantulas Disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                              $select = "SELECT DISTINCT p.PedidoID,
                              CONCAT(u.nombre, ' ', u.apellido) AS NombreCliente,
                              CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                              pl.plantasreales,
                              s.BandejasUtilizadas,
                              p.Estadopro,
                              p.Estado,
                              m.Nombre AS Nombremesada,
                              i.InvernaderoID,
                              m.MesadaID,
                              rp.CantidadRecolectada,
                              rp.sobrantebandeja,
                              rp.RecolectaID,
                              p.CantidadPlantulas
                              FROM Pedido p
                              JOIN Cliente u ON p.ClienteID = u.id_cliente
                              JOIN PlanificacionPedidos pl ON p.PedidoID = pl.OrdenID
                              JOIN siembra s ON p.PedidoID = s.IDPedido
                              JOIN camaragerminacion c ON p.PedidoID = c.id_orden
                              JOIN invernadero i ON p.PedidoID = i.PedidoID
                              JOIN mesada m ON m.MesadaID = i.MesadaID
                              JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
                              JOIN variedades v ON p.VariedadProductoPlantulas = v.VariedadID
                              JOIN recolectaplantas rp ON rp.PedidoID = p.PedidoID
                              WHERE p.Estado = 'Entregado' " ;

                              $resp = $db->query($select);
                              while ($fila = $resp->fetch_array()) {
                                  $Estado = ($fila['Estado'] == "Entregado") ? '<span class="badge badge-primary">Entregado</span>' : $fila['Estado'];
                                  $PedidoID = $fila['PedidoID'];
                                  $RecolectaID = $fila['RecolectaID'];
                                  
                                  if ($fila['CantidadRecolectada'] != 0) {
                                      echo "<tr class='fila-tabla' data-pedido='" . json_encode($fila) . "' data-target='#infoModal'>";
                                      echo "<td>" . $fila['PedidoID'] . "</td>";
                                      echo "<td>" . $fila['Producto'] . "</td>";
                                      echo "<td>" . $fila['Nombremesada'] . "</td>";
                                      echo "<td>" . $fila['sobrantebandeja'] . "</td>";
                                      echo "<td>" . $fila['CantidadRecolectada'] . "</td>";
                                      echo "</tr>";
                                  }
                              }
                          ?>
                    </tbody>
                  </table>
                    </div>
              </form>
              <!-- /.card-body -->
            </div>
            <!--PRIMER MODAL-->
            <!-- Modal for displaying information and input -->
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Reservas</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div id="modalDetails"></div>
                            <form id="reservaForm" action="../bd-archivo/realizar-reserva.php" method="post">
                            <input type="text" id="RecolectaIDInput" name="RecolectaID">
                            <input type="text" id="PedidoIDInput" name="PedidoID">
                              <div class="form-group text-center">
                                    <label for="fechaActual">Fecha de Reserva:</label>
                                    <div class="input-group"> <!-- Usamos la clase input-group para controlar el ancho del campo de entrada -->
                                      <input type="date" class="form-control" id="fechaReserva" name="fechaReserva" >
                                    </div>
                              </div>
                              <div class="form-group">
                                <label>Cliente</label>
                                <select class="form-control select2bs4" id="cliente" name="cliente" style="width: 100%;">
                                <option value="" disabled selected>Seleccione un cliente</option> <!-- Opción por defecto -->
                                  <?php
                                    // Realiza una consulta SQL para obtener los roles desde la tabla "roles"
                                    $query = "SELECT nombre, id_cliente ,apellido FROM cliente 
                                    ";
                                    $result = $db->query($query);
                                    
                                    // Itera a través de los resultados y crea opciones para el campo select
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_cliente'];
                                        $nombrecliente = $row['nombre'];
                                        $apellidocliente = $row['apellido'];
                                        $nombreCompleto = $nombrecliente . ' ' . $apellidocliente;
                                        echo "<option value='$id'>$nombreCompleto</option>";
                                    }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="cantidadReservada">Cantidad Reservada:</label>
                                <input type="number" class="form-control" id="cantidadReservada" name="cantidadReservada" placeholder="Ingrese la cantidad reservada">
                              </div>
                              <div class="form-group">
                                <label for="fechaEntregaEstimada">Fecha de Entrega Estimada:</label>
                                <input type="date" class="form-control" id="fechaEntregaEstimada" name="fechaEntregaEstimada">
                              </div>
                            </form>
                      </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button id="btnGuardarReserva" class="btn btn-primary" onclick="guardarreserva()">Guardar Reserva</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
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

<?php
include("../carpeta_css/script_js.php")
?>
<!-- Page specific script -->
<script>


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
                "select":{
                  "rows":{
                    "_":"Ud. seleccionó %d registros",
                    "0": "Haga clic en una fila",
                    "1": " %d Fila seleccionada"
            }
          }
    },
  };
  $(document).ready(function() {
    $('#example1').DataTable($.extend({}, commonOptions));
    $('#example2').DataTable($.extend({}, commonOptions));

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

  
  $(document).ready(function() {
  var filaSeleccionada = null; // Variable para mantener un seguimiento de la fila seleccionada

  // Cuando se hace clic en una fila de la tabla "example1"
  $('.fila-tabla').click(function() {
    if (filaSeleccionada !== null) {
      // Restablecer el color de la fila previamente seleccionada
      filaSeleccionada.removeClass('btn-primary');
    }

    // Resaltar la fila seleccionada en azul
    $(this).addClass('btn-primary');
    filaSeleccionada = $(this);
 
    var fila = filaSeleccionada.data('pedido');

    // Llenar los campos ocultos con los valores de RecolectaID y PedidoID
    $('#RecolectaIDInput').val(fila.RecolectaID);
    $('#PedidoIDInput').val(fila.PedidoID);

    // Habilitar el botón de reservas
    $('#agregarInfoButton').prop('disabled', false);
  });

  // Cuando se hace clic en el botón de reservas
  $('#agregarInfoButton').click(function() {
    // Verificar si hay una fila seleccionada
    if (filaSeleccionada !== null) {
      var fila = filaSeleccionada.data('pedido');
      // Construir el contenido HTML con la información de la fila en tres columnas y dos filas
      var modalContent = '<div class="row">';

      modalContent += '<div class="col-sm-6">';
      modalContent += '<h6 class="text-center text-primary font-weight-bold">Cant. Bandeja:</h6><p class="text-center">' + fila.sobrantebandeja + '</p>';
      modalContent += '</div>';

      modalContent += '<div class="col-sm-6">';
      modalContent += '<h6 class="text-center text-primary font-weight-bold">Plantulas Disponibles:</h6><p class="text-center" id="cantidadRecolectada">' + fila.CantidadRecolectada + '</p>';
      modalContent += '</div>';

      modalContent += '</div>'; // Cierre del div de la fila

      // Actualizar el contenido del div "modalDetails"
      $('#modalDetails').html(modalContent);

      // Mostrar el modal
      $('#infoModal').modal('show');
    }
  });

  // Cuando se cierra el modal, deshabilitar el botón de reservas y restablecer el color de las filas
  $('#infoModal').on('hidden.bs.modal', function() {
    if (filaSeleccionada !== null) {
      filaSeleccionada.removeClass('btn-primary');
    }
    $('#agregarInfoButton').prop('disabled', true);
    filaSeleccionada = null;
  });
});



// Obtén el campo de entrada por su id
var fechaInput = document.getElementById("fechaReserva");
// Crea una instancia de la fecha actual
var fechaActual = new Date();
// Formatea la fecha actual en el formato "YYYY-MM-DD"
var formattedFechaActual = fechaActual.toISOString().split('T')[0];
// Establece el valor del campo de entrada con la fecha actual formateada
fechaInput.value = formattedFechaActual;


function guardarreserva() {
  // Obtén los valores de los campos del formulario
  var fechaReserva = document.getElementById("fechaReserva").value;
  var cliente = document.getElementById("cliente").value;
  var cantidadReservada = parseInt(document.getElementById("cantidadReservada").value);

  // Obtén el valor de CantidadRecolectada desde el modal
  var cantidadRecolectada = parseInt($('#cantidadRecolectada').text());

  // Validación de campos incompletos
  if (fechaReserva === "" || cliente === "" || isNaN(cantidadReservada) || cantidadReservada <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Campos Incompletos',
      text: 'Por favor, complete todos los campos correctamente.'
    });
    return;
  }

  if (isNaN(cantidadRecolectada) || cantidadRecolectada <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Cantidad de plantulas recolectadas no válida.'
    });
    return;
  }

  // Validación de plantulas disponibles
  if (cantidadReservada > cantidadRecolectada) {
    Swal.fire({
      icon: 'error',
      title: 'No hay suficientes plantulas disponibles',
      text: 'La cantidad reservada supera la cantidad de plantulas recolectadas.'
    });
    return;
  }

  // Mostrar mensaje de éxito y realizar la acción de guardar la reserva
  Swal.fire({
    icon: 'success',
    title: 'Reserva Exitosa',
    text: 'La reserva se ha guardado exitosamente.',
    showConfirmButton: false,
    timer: 1500 // Cerrar automáticamente después de 1.5 segundos
  });

  $('#reservaForm').submit();
}

</script>
</body>
</html>