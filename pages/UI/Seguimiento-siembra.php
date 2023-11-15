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
  <title>AdminLTE 3 | Modals & Alerts</title>

<?php
include("../carpeta_css/stylesheet_css.php");
?>


  <style>
  .fila-seleccionada {
    background-color: #FF0000; /* Cambia el color a tu elección, en este caso rojo (#FF0000) */
    color: white; /* Cambia el color del texto para que sea legible */
  }
  </style>

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
              SIEMBRA
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Siembra</li>
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
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Siembra
                </h3>
              </div>             
              <div class="card-body">
                <p class="text-center font-weight-bolder"><span id="fechaDia"></span></p>
                <div class="justify-content-center align-content-center">
                  <label>Seleccionar pedido a sembrar :</label>
                </div>
                <button type="button" class="btn btn-outline-success" id="btn-primary" onclick="abrirAgregarInfoModal()" disabled>
                  <i class="fas fa-seedling"></i> Enviar a sembrar
                </button>
                <br><br>
                <div class="card-header bg-success">
                  <h4 class="card-title">Lista de pedidos planificados</h4>
                </div>
                <br>
                <div class="card-body table-responsive ">
                  <table id="example1" class="table table-bordered">
                    <thead>
                    <tr>
                      <th>N° Orden</th>
                      <th>Cliente</th>
                      <th>Producto</th>
                      <th>Tamaño</th>
                      <th>Plantas Reales</th>
                      <th>B. Plan</th>
                      <th>Cant. Semillas</th>    
                      <th>Estado</th>
                      <th>Accion</th>                                          
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                          $select = "SELECT p.PedidoID,
                          pl.PlanificacionPedidosID,
                          CONCAT(pc.nombre, ' ', pc.apellido) AS NombreCliente,
                          CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                          pl.plantasreales,
                          CONCAT( 'X',tb.Nombre ) AS Bandejas,
                          pl.CantidadBandejas,
                          pl.CantidadSemilla,
                          p.Estadopro
                          FROM Pedido p

                          JOIN cliente pc ON p.ClienteID = pc.id_cliente
                          JOIN PlanificacionPedidos pl ON p.PedidoID = pl.OrdenID
                          JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
                          JOIN tipobandeja tb ON tb.TipoBandejaID = pl.Bandejas
                          JOIN variedades v ON p.VariedadProductoPlantulas = v.VariedadID
                          WHERE p.Estadopro = 'Planificado'" ;

                          $resp = $db->query($select);
                          while($fila = $resp->fetch_array()){
                            $Estadopro = ($fila['Estadopro'] == "Planificado") ? '<span class="badge badge-warning">Planificado</span>'
                            : $fila['Estadopro'];
                      ?>
                      <tr class='fila-tabla' data-toggle='modal' data-target='#modal-siembra'>
                        <td><?php echo $fila['PedidoID']; ?></td>
                        <td><?php echo $fila['NombreCliente']; ?></td>
                        <td><?php echo $fila['Producto']; ?></td>
                        <td><?php echo $fila['Bandejas']; ?></td> 
                        <td><?php echo $fila['plantasreales']; ?></td>
                        <td><?php echo $fila['CantidadBandejas']; ?></td>  
                        <td><?php echo $fila['CantidadSemilla']; ?></td>
                        <td><?php echo $Estadopro; ?></td>
                        <td class="project-actions text-center">
                          <a href='../bd-archivo/ingreso-pedido.php?id=<?php echo $fila['PedidoID']; ?>' class="elimi"><button type="button" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                          </button></a>
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

      <div class="modal" id="modal-siembra" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header bg-gradient-success">
              <h3 class="modal-title">Siembra de semillas</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="form1" action="../bd-archivo/ingreso-siembra.php" method="post" >
            <div class="modal-body">
                  <!-- /.nombre y apellidos -->
                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Dia de siembra:</label>
                              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                  <input type="date" name="fechainicio" id="fechainicio" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Hora:</label>
                            <div class="input-group date" id="timepicker" data-target-input="nearest">
                            <input type="time" name="horainicio" id="horainicio" class="form-control datetimepicker-input" data-target="#timepicker"/>
                            </div>
                            <!-- /.input group -->
                          </div>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label>Marca sobre recibido: </label>
                            <input type="checkbox" id="recibido" name="recibido" value="recibido"  onclick="mostrarMensaje()">
                            <span id="mensajeRecibido" style="display: none;"> Recibido </span>
                          </div>
                        </div>
                      </div>                             
                    </div>                   
                  <!-- /.form group --> 
                  <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th >N° Orden</th>
                          <th>Cliente</th>
                          <th>Producto</th>
                          <th>Tamaño</th>
                          <th>Bandejas <br>
                            programadas</th>
                          <th>Bandejas <br> utilizadas</th>                                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <input type="hidden" name="numeroOrden" value="" id="numeroOrdenInput">
                          <td ><span name="numeroOrden" id="numeroOrden"></span></td>
                          <td><span name="cliente" id="cliente"></td>
                          <td><span name="producto" id="producto"></td>
                          <td><span name="tamaño" id="tamaño"></td>
                          <td><span name="bandejasplanificada" id="bandejasplanificada"></td>
                          <td><input type="number" class="form-control" name="bandejasutilizadas" id="bandejasutilizadas" ></td>              
                        </tr>
                      </tbody>
                    </table> 
                  </div>                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-outline-success"  onclick="guardar('form1', 'Ha sido agregado correctamente', 'modal-siembra')"
              id="btn-primary">
                  <i class="fas fa-seedling">
                  </i> Enviar a sembrar</button>
            </div>
            </form>
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
<?php
include("../carpeta_css/script_js.php");
?>


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
  // Inicializa DataTables para la tabla example1
    var table1 = $('#example1').DataTable($.extend({
      select: true
    }, commonOptions));
    var table2 = $('#example2').DataTable($.extend({
      select: true
    }, commonOptions));

    $('#example1 tbody').on('click', 'tr', function () {
      $(this).toggleClass('selected');
      $(this).toggleClass('fila-seleccionada');
      $('#btn-primary').prop('disabled', table1.rows('.selected').data().length === 0);

      if ($(this).hasClass('selected')) {
            var numeroOrden = $(this).find('td:eq(0)').text();  // Columna 1
            var cliente = $(this).find('td:eq(1)').text();      // Columna 2
            var producto = $(this).find('td:eq(2)').text();     // Columna 3
            var tamaño = $(this).find('td:eq(3)').text();     // Columna 4
            var bandejasplanificada = $(this).find('td:eq(5)').text();     // Columna 5

            $('#modal-siembra #numeroOrden').text(numeroOrden);
            $('#modal-siembra #numeroOrdenInput').val(numeroOrden);
            $('#modal-siembra #cliente').text(cliente);
            $('#modal-siembra #producto').text(producto);
            $('#modal-siembra #tamaño').text(tamaño);
            $('#modal-siembra #bandejasplanificada').text(bandejasplanificada);
        }
    });

    table1.on('draw', function () {
      $('#btn-primary').prop('disabled', true);
    });
});

function abrirAgregarInfoModal() {
  var selectedRows = $('#example1').DataTable().rows('.selected').data();

  if (selectedRows.length > 0) {
    $('#modal-siembra').modal('show');
  } else {
    alert('Por favor, seleccione una fila.');
  }
}



  function guardar(formId, successMessage, modalId) {
  const formulario = document.getElementById(formId);

  // Validar campos específicos del formulario
  const camposValidar = ['fechainicio', 'horainicio', 'recibido', 'bandejasutilizadas'];

  for (const campoId of camposValidar) {
    const campo = document.getElementById(campoId);
    if (!campo.value.trim()) {
      Swal.fire({
        title: 'Error',
        text: 'Por favor, complete todos los campos.',
        icon: 'error'
      });
      return false;
    }
  }

  // Si todos los campos están completos, mostrar mensaje de éxito y enviar formulario
  Swal.fire({
    title: 'Guardado',
    text: successMessage,
    icon: 'success',
    timer: 1000,
    timerProgressBar: true,
    showConfirmButton: false
  }).then(() => {
    const modal = document.getElementById(modalId);
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.hide();
    formulario.submit();
  });

  return false;
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

  function mostrarMensaje() {
            const mensajeRecibido = document.getElementById('mensajeRecibido');
            const checkbox = document.getElementById('recibido');
  }
</script>
</body>
</html>
