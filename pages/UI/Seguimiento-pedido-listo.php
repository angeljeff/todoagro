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
                  Despacho de plantulas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <div class="row col-4">
                  <button id="agregarInfoButton" type="button" class="btn btn-outline-primary btn-block" disabled>
                    <i class="fa fa-paper-plane"></i> Realizar entrega
                  </button>
                  </div>
                </div>
                <div class="card-header bg-success">
                  <h4 class="card-title">Pedido para entregar</h4>
                </div>
                <br>
                <div class="card-body table-responsive ">
                    <!-- Tabla para mostrar actividades anteriores -->
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Orden</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Mesada</th>
                            <th>Cant. Bandeja</th>
                            <th>Plantas pedidas</th>
                            <th>Estado Pedido</th>
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
                              WHERE p.Estado = 'ListoEntrega' " ;

                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                                $Estado = ($fila['Estado'] == "ListoEntrega") ? '<span class="badge badge-primary">ListaEntrega</span>'
                                : $fila['Estado'];
                                $CantidadRecolectada = $fila['CantidadRecolectada'];
                                $RecolectaID = $fila['RecolectaID'];
                                $MesadaID = $fila['MesadaID'];
                                
                          ?>
                          <tr class='fila-tabla' data-pedido='<?php echo json_encode($fila); ?>' data-target='#infoModal'>
                            <td><?php echo $fila['PedidoID']; ?></td>
                            <td><?php echo $fila['NombreCliente']; ?></td>
                            <td><?php echo $fila['Producto']; ?></td>
                            <td><?php echo $fila['Nombremesada']; ?></td>
                            <td><?php echo $fila['BandejasUtilizadas']; ?></td>
                            <td><?php echo $fila['CantidadPlantulas']; ?></td>
                            <td><?php echo $Estado; ?></td>
                          </tr>
                          <?php } ?>
                    </tbody>
                  </table>
                </div>
              <!-- /.card-body -->
            </div>
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="infoModalLabel">Detalles del Pedido</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div id="modalDetails"></div>
                          <form action="../bd-archivo/ingreso-pedidoentregado.php" method="POST">
                          <input  type="hidden" id="MesadaIDInput" name="MesadaID">
                          <input  type="hidden" id="RecolectaIDInput" name="RecolectaID">
                          <div class="form-group col-md-6 mx-auto text-center">
                            <label for="fecha" class="text-center">Fecha de Entrega:</label>
                            <input class="form-control text-center" type="datetime" id="fecha" name="fecha">
                            <?php
                              // Establecer la zona horaria
                              date_default_timezone_set('America/Guayaquil');

                              // Obtener la fecha y hora actual en el formato "Y-m-d\TH:i:s"
                              $fecha_y_hora_actual = date('Y-m-d\TH:i:s');

                              // Insertar el valor en el campo datetime-local
                              echo '<script>';
                              echo 'document.getElementById("fecha").value = "' . $fecha_y_hora_actual . '";';
                              echo '</script>';
                            ?>
                          </div>
                          <div class="form-group col-md-6 mx-auto text-center">
                          <label for="cantPlantulasRecolectadas">Cantidad de Plantas Recolectadas:</label>
                          <input id="CantidadRecolectadaInput" name="CantidadRecolectada" 
                          style="color: red; font-size: 18px; border: none; background: none;  text-align: center;" readonly>
                          </div>
                              <div class="row">
                                  <div class="form-group  col-md-6">
                                      <label for="cantPlantulas">Cantidad de Plantulas a Entregar:</label>
                                      <input class="form-control" type="number" id="cantPlantulas" name="cantPlantulas">
                                  </div>
                                  <div class="form-group  col-md-6">
                                      <label for="cantBandejasDesocupadas">Cantidad de Bandejas Desocupadas:</label>
                                      <input class="form-control" type="number" id="cantBandejasDesocupadas" name="cantBandejasDesocupadas">
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="form-group  col-md-6">
                                      <label for="cajasUtilizadas">Cajas Utilizadas:</label>
                                      <input class="form-control" type="number" id="cajasUtilizadas" name="cajasUtilizadas">
                                  </div>
                                  <div class="form-group  col-md-6">
                                      <label for="tipoEmpaque">Tipo de Empaque:</label>
                                      <select class="form-control select2bs4" id="tipoEmpaque" name="tipoEmpaque">
                                          <option value="cartonConSello">Cartón con Sello</option>
                                          <option value="cartonSinSello">Cartón sin Sello</option>
                                          <option value="gavetaConSello">Gaveta con Sello</option>
                                          <option value="gavetaSinSello">Gaveta sin Sello</option>
                                      </select>
                                  </div>
                              </div>
                              <div id="mensajeError" style="color: red;"></div>
                              <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                      <th>N°</th>
                                      <th>Cliente</th>
                                      <th>Producto</th>
                                      <th>Cant. Bandeja</th>
                                      <th>Plantas pedidas</th>                                       
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <tr >
                                  <input type="hidden" name="numeroOrden" value="" id="numeroOrdenInput">
                                      <td ><span name="numeroOrden" id="numeroOrden"></span></td>
                                      <td><span name="cliente" id="cliente"></td>
                                      <td><span name="producto" id="producto"></td>
                                      <td><span name="cantbandejas" id="cantbandejas"></td>
                                      <td><span name="plantaspedidas" id="plantaspedidas"></td>           
                                    </tr>
                                  </tbody>
                                </table> 
                              </div> 
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                  <button type="submit" class="btn btn-primary" onclick="guardarCantRecolectada()">Guardar</button>
                              </div>
                          </form>
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

<!-- jQuery -->
<?php
include("../carpeta_css/script_js.php");
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
    }
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



  $(document).ready(function () {
  // Variable para almacenar los detalles del pedido seleccionado
  var selectedPedido = null;

  // Al hacer clic en una fila de la tabla example1
  $('#example1 tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected btn-primary');
      selectedPedido = null;
      // Deshabilita el botón de "Realizar entrega" si no hay fila seleccionada
      $('#agregarInfoButton').prop('disabled', true);
    } else {
      // Deselecciona otras filas previamente seleccionadas
      $('#example1 tbody tr.selected').removeClass('selected btn-primary');
      $(this).addClass('selected btn-primary');

      selectedPedido = $(this);

      var fila = selectedPedido.data('pedido');

      // Llenar los campos ocultos con los valores de RecolectaID y PedidoID
      $('#RecolectaIDInput').val(fila.RecolectaID);
      $('#MesadaIDInput').val(fila.MesadaID);
      $('#CantidadRecolectadaInput').val(fila.CantidadRecolectada);

      var data = $('#example1').DataTable().row(this).data();
      // Almacena los detalles del pedido seleccionado
      selectedPedido = {
        numeroOrden: data[0],
        cliente: data[1],
        producto: data[2],
        cantbandejas: data[4],
        plantaspedidas: data[5]
      };
      // Habilita el botón de "Realizar entrega" al seleccionar una fila
      $('#agregarInfoButton').prop('disabled', false);
    }
  });

  // Al hacer clic en el botón "Realizar entrega"
  $('#agregarInfoButton').click(function () {
    if (selectedPedido !== null) {
      // Abre el modal aquí
      abrirModal(selectedPedido);
    }
  });

  // Función para abrir el modal con los detalles del pedido seleccionado
  function abrirModal(pedido) {
    $('#numeroOrden').text(pedido.numeroOrden);
    $('#numeroOrdenInput').val(pedido.numeroOrden);
    $('#cliente').text(pedido.cliente);
    $('#producto').text(pedido.producto);
    $('#cantbandejas').text(pedido.cantbandejas);
    $('#plantaspedidas').text(pedido.plantaspedidas);
    // Abre el modal
    $('#infoModal').modal('show');
  }
});




function guardarCantRecolectada() {
    // Obtén los valores de los campos
    var cantidadPlantulasEntregar = document.getElementById('cantPlantulas').value.trim();
    var cantBandejasDesocupadas = document.getElementById('cantBandejasDesocupadas').value.trim();
    var cajasUtilizadas = document.getElementById('cajasUtilizadas').value.trim();
    var tipoEmpaque = document.getElementById('tipoEmpaque').value;
    
    // Obtén el elemento donde mostrarás los mensajes de error
    var mensajeError = document.getElementById('mensajeError');
    
    // Realiza las validaciones
    if (cantidadPlantulasEntregar === '' || cantBandejasDesocupadas === '' || cajasUtilizadas === '' || tipoEmpaque === '') {
        // Muestra un mensaje de error con SweetAlert si los campos están incompletos
        Swal.fire({
            icon: 'error',
            title: 'Campos Incompletos',
            text: 'Por favor, completa todos los campos antes de guardar.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });
    } else {
        cantidadPlantulasEntregar = parseInt(cantidadPlantulasEntregar);
        if (isNaN(cantidadPlantulasEntregar) || cantidadPlantulasEntregar < 0 || cantidadPlantulasEntregar > cantidadPlantulasRecolectadas) {
            mensajeError.innerHTML = 'La cantidad a entregar es inválida o excede la cantidad recolectada.';
            mensajeError.style.color = 'red';
            return;
        }

        if (isNaN(cantidadPlantulasEntregar) || cantidadPlantulasEntregar < 0 || cantidadPlantulasEntregar > cantidadPlantulasRecolectadas) {
        mensajeError.innerHTML = 'La cantidad a entregar es inválida o excede la cantidad recolectada.';
        mensajeError.style.color = 'red';
        return;
        }
        
        if (isNaN(cantBandejasDesocupadas) || cantBandejasDesocupadas < 0) {
            mensajeError.innerHTML = 'La cantidad de bandejas desocupadas es inválida.';
            mensajeError.style.color = 'red';
            return;
        }
        
        if (isNaN(cajasUtilizadas) || cajasUtilizadas < 0) {
            mensajeError.innerHTML = 'La cantidad de cajas utilizadas es inválida.';
            mensajeError.style.color = 'red';
            return;
        }
        
        // Si todas las validaciones pasan, quita cualquier mensaje de error anterior
        mensajeError.innerHTML = '';
        
        // Muestra un mensaje de éxito con SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Guardado Exitoso',
            text: 'Los datos han sido guardados exitosamente.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        });

        // Ahora puedes enviar los datos al servidor si es necesario
        // ... Agregar el código para enviar los datos al servidor ...
    }
}

</script>
</body>
</html>