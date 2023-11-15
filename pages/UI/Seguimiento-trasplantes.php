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
  <title>AdminLTE 3 | DataTables</title>
  
  <?php
  include("../carpeta_css/stylesheet_css.php");
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
            <h1>Invernadero - Trasplante</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Trasplante</li>
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
            <!-- CARD 1 -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Plántulas
                </h3>
              </div>
              <div class="card-body">
                    <!-- PRINCIPAL -->
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>N° Orden</th>
                          <th>Ubicacion Mesada</th>
                          <th>Cliente</th>
                          <th>Producto</th>
                          <th>Días Transcurrido</th>
                          <th>Cant. Bandeja</th>
                          <th>Plantas pedidas</th>
                          <th>Plantas reales</th>
                          <th>Fecha siembra</th>
                          <th>Fecha camara</th>
                          <th>Fecha invernadero</th>
                          <th>Fecha estimada entrega</th>
                          <th>Actividades</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              $select = "SELECT p.PedidoID,
                              CONCAT(u.nombre, ' ', u.apellido) AS NombreCliente,
                              CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                              pl.plantasreales,
                              s.BandejasUtilizadas,
                              p.Estadopro,
                              p.Estado,
                              p.FechaEntrega,
                              s.FechaInicio AS Fechasiembra,
                              c.fecha AS Fechacamara,
                              m.Nombre AS Nombremesada,
                              i.fechainvernadero,
                              i.InvernaderoID,
                              m.MesadaID,
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
                              WHERE p.Estadopro = 'EnInvernadero' and p.Estado = 'Pendiente' " ;

                              $fechaActual = new DateTime();

                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                                $Estadopro = ($fila['Estadopro'] == "EnInvernadero") ? '<span class="badge badge-success">EnInvernadero</span>'
                                : $fila['Estadopro'];
                                
                                $fechaEntrega = new DateTime($fila['Fechasiembra']);
                                $diferencia = $fechaActual->diff($fechaEntrega);  // Calcula la diferencia entre la fecha actual y la fecha de entrega
                                $numDiasFaltantes = $diferencia->days;  // Obtiene el número de días de la diferencia
                          ?>
                          <tr class='fila-tabla' data-toggle='modal' data-target='#countPlantModal' data-pedidoid="<?php echo $fila['PedidoID']; ?>" data-invernaderoid="<?php echo $fila['InvernaderoID']; ?>">
                            <td><?php echo $fila['PedidoID']; ?></td>
                            <td><?php echo $fila['Nombremesada']; ?></td>
                            <td><?php echo $fila['NombreCliente']; ?></td>
                            <td><?php echo $fila['Producto']; ?></td>
                            <td><?php echo $numDiasFaltantes; ?> días</td>
                            <td><?php echo $fila['BandejasUtilizadas']; ?></td>
                            <td><?php echo $fila['CantidadPlantulas']; ?></td>
                            <td><?php echo $fila['plantasreales']; ?></td> 
                            <td><?php echo $fila['Fechasiembra']; ?></td>  
                            <td><?php echo $fila['Fechacamara']; ?></td>
                            <td><?php echo $fila['fechainvernadero']; ?></td>
                            <td><?php echo $fila['FechaEntrega']; ?></td> 
                            <td class="project-actions text-center">
                            <button type="button" class="btn btn-primary btn-sm agregarInfoButton" onclick="abrirAgregarInfoModal(<?php echo $fila['InvernaderoID']; ?>)">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm conteoPlantas"
                                    onclick="openCountPlantModal(<?php echo $fila['BandejasUtilizadas']; ?>, '<?php echo $fila['Nombremesada']; ?>',
                                                              <?php echo $fila['plantasreales']; ?>, <?php echo $fila['CantidadPlantulas']; ?>,
                                                              <?php echo $fila['InvernaderoID']; ?>, <?php echo $fila['PedidoID']; ?>)">
                              <i class="fa fa-book"></i>
                          </button>
                            </td>
                            <td><?php echo $Estadopro; ?></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
              </div>
              <!-- Modal para agregar información -->
              <div class="modal fade" id="modalAgregarInfo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarInfoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalAgregarInfoLabel">Agregar Información de Actividad</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="../bd-archivo/ingreso-actividad.php" method="post">
                    <div class="modal-body">
                      <div class="form-group">
                        <input type="hidden" id="InvernaderoID" value="">
                        <label for="fechaActividad">Fecha de Actividad:</label>
                        <input type="date" class="form-control" id="fechaActividad" placeholder="Ingrese la fecha de la actividad">
                      </div>
                      <div class="form-group">
                        <label for="nombreActividad">Nombre de Actividad:</label>
                        <input type="text" class="form-control" id="nombreActividad" placeholder="Ingrese el nombre de la actividad">
                      </div>
                      <div class="form-group">
                        <label for="observacion">Observación:</label>
                        <textarea class="form-control" id="observacion" rows="3" placeholder="Ingrese observaciones"></textarea>
                      </div>
                    </div>
                    <div class="card-body table-responsive ">
                      <div class="row justify-content-center align-items-center">
                        <label>ACTIVIDADES REALIZADAS</label>
                      </div>
                      <!-- Tabla para mostrar actividades anteriores -->
                      <table id="tabla2" class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Actividad</th>
                            <th>Observación</th>
                          </tr>
                        </thead>
                        <tbody id="tablaActividadesAnteriores">
                          <!-- Aquí se cargarán las actividades anteriores -->
                        </tbody>
                      </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-primary" onclick="guardarInformacion()">Guardar</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- MODAL PARA CONTEO DE PLANTULAS-->
              <div class="modal fade" id="countPlantModal" tabindex="-1" aria-labelledby="countPlantModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="countPlantModalLabel">Ingresar cantidad de plantulas contadas</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form id="formulario" action="../bd-archivo/ingreso_recolecta.php" method="post">
                    <div class="modal-body">
                      <input type="hidden" id="invernaderoID" name="invernaderoID">
                      <input type="hidden" id="pedidoID" name="pedidoID">
                        <div class="col-md-6">
                                  <label>Fecha:</label>
                                  <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="form-group">
                          <label for="countedPlants">Cantidad de plantulas contadas:</label>
                          <input type="number" class="form-control" id="countedPlants" name="countedPlants" placeholder="Ingrese la cantidad de plantulas contadas">
                        </div>
                        <div class="form-group">
                          <label for="mesada">Mesada:</label>
                          <input type="text" class="form-control" id="mesada" name="mesada" disabled>
                        </div>
                        <div class="form-group">
                          <label for="cantBandeja">Cantidad de bandejas:</label>
                          <input type="text" class="form-control" id="cantBandeja" name="cantBandeja" readonly>
                        </div>
                        <div class="form-group">
                          <label for="requestedPlants">Cantidad de plantulas pedidas:</label>
                          <input type="text" class="form-control" id="requestedPlants" disabled>
                        </div>
                        <div class="form-group">
                          <label for="approximatePlants">Cantidad de plantulas aproximadas:</label>
                          <input type="text" class="form-control" id="approximatePlants" disabled>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button id="guardarButton" type="button" class="btn btn-primary">Guardar</button>
                      </div>
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
<?php
include("../carpeta_css/script_js.php");
?>
<script>

  function abrirAgregarInfoModal(invernaderoID) {
    const fechaActual = new Date().toISOString().split('T')[0];

    $('#InvernaderoID').val(invernaderoID);  // Aquí se establece el ID
    // Establecer la fecha actual en el campo de fecha
    $('#fechaActividad').val(fechaActual);
    // Mostrar el modal para añadir información
    $('#modalAgregarInfo').modal('show');

    cargarActividadesAnteriores(invernaderoID);
  }

  document.addEventListener('DOMContentLoaded', function () {
  const guardarButton = document.getElementById('guardarButton');

  guardarButton.addEventListener('click', function () {
    const fecha = document.getElementById('fecha').value;
    const countedPlants = document.getElementById('countedPlants').value;

    if (fecha.trim() === '' || countedPlants.trim() === '') {
      Swal.fire('Error', 'Por favor, complete todos los campos', 'error');
    } else {
      Swal.fire({
        title: 'Guardado Exitoso',
        text: 'Los datos se han guardado exitosamente',
        icon: 'success'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirige al usuario cuando hacen clic en "OK"
          document.getElementById('formulario').submit();
        }
      });
    }
  });
});


  function guardarInformacion() {
    // Obtener los valores de los campos
    const InvernaderoID = $('#InvernaderoID').val();
    const fechaActividad = $('#fechaActividad').val().trim();
    const nombreActividad = $('#nombreActividad').val().trim();
    const observacion = $('#observacion').val().trim();

    // Validar que todos los campos estén completos
    if (fechaActividad === '' || nombreActividad === '' || observacion === '') {
      // Mostrar un mensaje de error si algún campo está vacío
      Swal.fire({
        icon: 'error',
        title: 'Campos Incompletos',
        text: 'Por favor, complete todos los campos.',
      });
      return;
  }

  // Crear un objeto con los datos a enviar
  const data = {
    InvernaderoID: InvernaderoID,
    fechaActividad: fechaActividad,
    nombreActividad: nombreActividad,
    observacion: observacion
  };

  // Enviar la solicitud AJAX POST
  $.ajax({
    url: '../bd-archivo/ingreso-actividad.php',
    type: 'POST',
    data: data,
    success: function(response) {
      Swal.fire({
        icon: 'success',
        title: 'Guardado exitosamente',
        text: 'La información ha sido guardada correctamente.',
      });

      // Después de guardar la información, puedes cerrar el modal
      $('#modalAgregarInfo').modal('hide');
    },
    error: function(error) {
      Swal.fire({
        icon: 'error',
        title: 'Error al guardar',
        text: 'Hubo un error al guardar la información.',
      });
    }
  });
}


function cargarActividadesAnteriores(invernaderoID) {
  // Realizar una llamada AJAX para obtener las actividades anteriores
  $.ajax({
    url: '../bd-archivo/actividad_invernadero.php', // Cambia por la ruta correcta para obtener las actividades
    method: 'POST',
    data: { InvernaderoID: invernaderoID },
    success: function(response) {
      // Parsear la respuesta a JSON
      const actividades = JSON.parse(response);

      // Limpiar la tabla de actividades anteriores
      $('#tablaActividadesAnteriores').empty();

      // Agregar las actividades anteriores a la tabla
      actividades.forEach(function(actividad) {
        const row = `
          <tr>
            <td>${actividad.fecha}</td>
            <td>${actividad.nombre}</td>
            <td>${actividad.observacion}</td>
          </tr>
        `;
        $('#tablaActividadesAnteriores').append(row);
      });
    },
    error: function() {
      console.error('Error al cargar las actividades anteriores.');
    }
  });
}


  $(function () {
    $.extend($.fn.dataTable.defaults, {
      "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Seleccionar el N°:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

    $("#example1").DataTable({
      select:true,
      select: {items:'row'},
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print",]
      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#tabla2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
  });

  function openCountPlantModal(bandejas, mesada, cantPlantulas, cantPedida,invernaderoID, pedidoID, mesadaID) {
    // Populate the modal with the extracted information
    document.getElementById('requestedPlants').value = cantPedida;  // Set the requested plant value
    document.getElementById('mesada').value = mesada;
    document.getElementById('cantBandeja').value = bandejas; 
    document.getElementById('approximatePlants').value = cantPlantulas;  
    console.log('mesadaID:', mesadaID);
    // Colocar los IDs en los campos ocultos del modal
    $('#invernaderoID').val(invernaderoID);
    $('#pedidoID').val(pedidoID);

    // Open the modal
    $('#countPlantModal').modal('show');
}

const today = new Date().toISOString().split('T')[0]; 
// Establecer la fecha actual en el campo de fecha
document.getElementById('fecha').value = today;


</script>
</body>
</html>

