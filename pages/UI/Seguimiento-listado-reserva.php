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
                  Almacenaje y reservas de plantulas</h3>
              </div>
              <!-- /.card-header -->
              <form id="pedido" method="POST" action="../bd-archivo/ingreso-pedido.php">
                <div class="card-body table-responsive ">
                      <!-- Tabla para mostrar actividades anteriores -->
                      <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>N° Reserva</th>
                            <th>F. Reserva</th>
                            <th>F.Entrega</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Mesada</th>
                            <th>Cant. Bandeja</th>
                            <th>Plantulas Reservadas</th>
                            <th>Estado Reservado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                              $select = "SELECT r.ID_Reserva,
                              CONCAT(u.nombre, ' ', u.apellido) AS NombreCliente,
                              CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                              r.Estado_Reserva,
                              m.Nombre AS Nombremesada,
                              rp.sobrantebandeja,
                              u.nombre,
                              u.apellido,
                              rp.RecolectaID,
                              rp.CantidadRecolectada,
                              m.MesadaID,
                              u.id_cliente,
                              r.Cantidad_Reservada,
                              tb.Nombre,
                              CONCAT( rp.sobrantebandeja,' ','X',tb.Nombre ) AS Bandejas,
                              r.Fecha_Reserva,
                              p.PedidoID,
                              r.Fecha_Entrega_Estimada
                              FROM reservas r
                              JOIN Cliente u ON r.ID_Cliente = u.id_cliente
                              JOIN Pedido p ON p.PedidoID = r.ID_Pedido
                              JOIN invernadero i ON p.PedidoID = i.PedidoID
                              JOIN mesada m ON m.MesadaID = i.MesadaID
                              JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
                              JOIN variedades v ON p.VariedadProductoPlantulas = v.VariedadID
                              JOIN PlanificacionPedidos pl ON p.PedidoID = pl.OrdenID
                              JOIN tipobandeja tb ON tb.TipoBandejaID = pl.Bandejas
                              JOIN recolectaplantas rp ON rp.PedidoID = p.PedidoID
                              WHERE Estado_Reserva = 'Reservado' " ;

                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                                $Estado = ($fila['Estado_Reserva'] == "Reservado") ? '<span class="badge badge-primary">Reservado</span>'
                                : $fila['Estado_Reserva'];
                                $CantidadRecolectada = $fila['CantidadRecolectada'];
                                $RecolectaID = $fila['RecolectaID'];
                                $sobrantebandeja = $fila['sobrantebandeja'];
                                $MesadaID = $fila['MesadaID'];
                                $NombreB = $fila['Nombre'];
                                $nombre= $fila['nombre'];
                                $apellido = $fila['apellido'];
                                $id_cliente = $fila['id_cliente'];
                                
                          ?>
                          <tr>
                            <td><?php echo $fila['ID_Reserva']; ?></td>
                            <td><?php echo $fila['Fecha_Reserva']; ?></td>
                            <td><?php echo $fila['Fecha_Entrega_Estimada']; ?></td>
                            <td><?php echo $fila['NombreCliente']; ?></td>
                            <td><?php echo $fila['Producto']; ?></td>
                            <td><?php echo $fila['Nombremesada']; ?></td>
                            <td><?php echo $fila['Bandejas']; ?></td>
                            <td><?php echo $fila['Cantidad_Reservada']; ?></td>
                            <td><?php echo $Estado; ?></td>
                            <td><button id="agregarInfoButton" type="button" class="btn btn-primary btn-sm entregar-button" data-toggle="modal" data-target="#infoModal"
                            data-pedido-id="<?php echo $fila['PedidoID']; ?>"
                            data-cliente-id="<?php echo $fila['id_cliente']; ?>"
                            data-nombre-completo="<?php echo $nombre . ' ' . $apellido; ?>"
                            data-nombre-bandeja="<?php echo $NombreB; ?>"
                            data-recolecta-id="<?php echo $RecolectaID; ?>"
                            data-cantidad-recolecta="<?php echo $CantidadRecolectada; ?>"
                            data-cantidad-reservada="<?php echo $fila['Cantidad_Reservada']; ?>"
                            data-sobrante-bandeja="<?php echo $fila['sobrantebandeja']; ?>"
                            data-mesada-id="<?php echo $fila['MesadaID']; ?>"
                            data-reserva-id="<?php echo $fila['ID_Reserva']; ?>">

                              Entregar
                            </button>
                            </td>
                          </tr>
                          <?php } ?>
                    </tbody>
                  </table>
                    </div>
              </form>
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
                          <form action="../bd-archivo/ingreso-pedidoentregado-reserva.php" method="POST">
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
                          <div id="modalDetails">

                              <input class="form-control" type="hidden" id="pedidoIdModal" name="pedidoIdModal" readonly>
                              <input class="form-control" type="hidden" id="clienteIdModal" name="clienteIdModal" readonly>
                              <input class="form-control" type="hidden" id="recolectaIdModal" name="recolectaIdModal" readonly>
                              <input class="form-control" type="hidden" id="mesadaIdModal" name="mesadaIdModal" readonly>
                              <input class="form-control" type="hidden" id="nombreBandejaModal" name="nombreBandejaModal" readonly>
                              <input class="form-control" type="text" id="reservaIdModal" name="reservaIdModal" readonly>
                              <input class="form-control" type="hidden" id="cantidadrecolectaIdModal" name="cantidadrecolectaIdModal" readonly>

                              <label for="nombreCompletoModal">Nombre del Cliente: </label>
                              <input class="form-control" type="text" id="nombreCompletoModal" name="nombreCompletoModal" readonly>
                              
                              <label for="cantidadReservadaModal">Cantidad Reservada: </label>
                              <input class="form-control" type="text" id="cantidadReservadaModal" name="cantidadReservadaModal" readonly>

                              <label for="sobranteBandejaModal">Sobrante de Bandeja: </label>
                              <input class="form-control" type="text" id="sobranteBandejaModal" name="sobranteBandejaModal" readonly>

                              
                          </div>
                              <div class="row">
                              
                                  <div class="form-group  col-md-6">
                                      <label for="cajasUtilizadas">Cajas Utilizadas:</label>
                                      <input class="form-control" type="number" id="cajasUtilizadas" name="cajasUtilizadas">
                                  </div>
                                  <div class="form-group  col-md-6">
                                      <label for="cajasUtilizadas">Cant. Desocupadas:</label>
                                      <input class="form-control" type="number" id="cantBandejasDesocupadas" name="cantBandejasDesocupadas">
                                  </div>
                              </div>
                              <div class="row">
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



  // Agrega un controlador de eventos clic a todos los botones "Entregar" con la clase "entregar-button"
  var entregarButtons = document.querySelectorAll('.entregar-button');
  entregarButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      // Obtén los datos de la fila correspondiente
      var pedidoId = this.getAttribute('data-pedido-id');
      var clienteId = this.getAttribute('data-cliente-id');
      var nombreCompleto = this.getAttribute('data-nombre-completo');
      var nombreBandeja = this.getAttribute('data-nombre-bandeja');
      var recolectaId = this.getAttribute('data-recolecta-id');
      var cantidadRecolectada = this.getAttribute('data-cantidad-recolecta');
      var cantidadReservada = this.getAttribute('data-cantidad-reservada');
      var sobranteBandeja = this.getAttribute('data-sobrante-bandeja');
      var mesadaId = this.getAttribute('data-mesada-id'); 
      var reservaId = this.getAttribute('data-reserva-id');

      
      // Actualiza los elementos en el modal con los datos de la fila
      document.getElementById('pedidoIdModal').value = pedidoId;
      document.getElementById('clienteIdModal').value = clienteId;
      document.getElementById('nombreCompletoModal').value = nombreCompleto;
      document.getElementById('nombreBandejaModal').value = nombreBandeja;
      document.getElementById('recolectaIdModal').value = recolectaId;
      document.getElementById('cantidadrecolectaIdModal').value = cantidadRecolectada;
      document.getElementById('cantidadReservadaModal').value = cantidadReservada;
      document.getElementById('sobranteBandejaModal').value = sobranteBandeja;
      document.getElementById('mesadaIdModal').value = mesadaId; 
      document.getElementById('reservaIdModal').value = reservaId;


    });
  });


</script>
</body>
</html>