<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
    date_default_timezone_set('America/Guayaquil');
  }
?>
<!DOCTYPE html>
<html lang="en">
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
                <h1>Cámara de Germinación</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Cámara</li>
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
                                Entrada de Plántula a la Cámara de Germinación
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6">
                                <button id="agregarInfoButton" type="button" class="btn btn-outline-primary btn-block" onclick="abrirAgregarInfoModal()" disabled><i class="fa fa-paper-plane"></i> Enviar a Cámara de Germinación</button>
                            </div>
                            </br>
                    
                            <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                <th>N° Orden</th>
                                <th>Clientes</th>
                                <th>Producto</th>
                                <th>Plantas</th>
                                <th>Semillas</th>
                                <th>Estado</th>
                                
                                
                                </tr>
                              </thead>
                              <tbody>
                              <?php 
                                $select = "SELECT s.IDPedido,
                                CONCAT(u.nombre, ' ', u.apellido) AS nombre, 
                                h.NombreHortaliza, pp.plantasreales, pp.CantidadSemilla, p.Estadopro
                                FROM siembra s
                                INNER JOIN planificacionpedidos pp ON pp.OrdenID = s.IDPedido
                                INNER JOIN pedido p ON p.PedidoID = pp.OrdenID
                                INNER JOIN hortalizas h ON h.HortalizaID = p.ProductoPlantulasID
                                JOIN Cliente u ON p.ClienteID = u.id_cliente
                                
                                 WHERE p.Estadopro = 'EnSiembra'";
                                $resp = $db->query($select);
                                while($fila = $resp->fetch_array()){
                                    $Estadopro = ($fila['Estadopro'] == "EnSiembra") ? '<span class="badge badge-danger">EnSiembra</span>'
                                    : $fila['Estadopro'];
                              ?>
                              <tr>
                                <td><?php echo $fila['IDPedido']?></td>
                                <td><?php echo $fila['nombre']?></td>
                                <td><?php echo $fila['NombreHortaliza']?></td>
                                <td><?php echo $fila['plantasreales']?></td>
                                <td><?php echo $fila['CantidadSemilla']?></td>
                                <td><?php echo $Estadopro; ?></td>
                              </tr>
                              <?php
                                }
                              ?>
                              </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="agregarInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning" >
                                        <h5 class="modal-title" id="exampleModalLabel">ÓRDENES A CÁMARA</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <form name="formEvento" id="formEvento" action="nuevoEvento.php" class="form-horizontal" method="POST">
                                          <div class="form-group">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <label for="evento" class="col-sm-12 control-label">Fecha de envió:</label>
                                                <input type="date" name="entr_camar" id="entr_camar" class="form-control">
                                              </div>
                                              <div class="col-md-6">
                                                <label>Hora:</label>
                                                <input type="time" name="entr_hora" id="entr_hora" class="form-control">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-12" id="grupoRadio">
                                              <input type="radio" name="color_evento" id="orange" value="#FF5722" checked>
                                              <label for="orange" class="color-label" style="background-color: #FF5722;"> </label>
                                  
                                              <input type="radio" name="color_evento" id="amber" value="#FFC107">  
                                              <label for="amber" class="color-label" style="background-color: #FFC107;"> </label>
                                  
                                              <input type="radio" name="color_evento" id="lime" value="#8BC34A">  
                                              <label for="lime" class="color-label" style="background-color: #8BC34A;"> </label>
                                  
                                              <input type="radio" name="color_evento" id="teal" value="#009688">  
                                              <label for="teal" class="color-label" style="background-color: #009688;"> </label>
                                  
                                              <input type="radio" name="color_evento" id="blue" value="#2196F3">  
                                              <label for="blue" class="color-label" style="background-color: #2196F3;"> </label>
                                  
                                              <input type="radio" name="color_evento" id="indigo" value="#9c27b0">  
                                              <label for="indigo" class="color-label" style="background-color: #9c27b0;"> </label>
                                          </div>
                                          <div class="modal-footer justify-content-between">   
                                              <button type="button" class="btn btn-primary" onclick="guardarInformacion()">Enviar</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                          </div>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                
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
<!-- ./wrapper -->

<!-- jQuery -->
<?php
include("../carpeta_css/script_js.php");
?>

<!-- Page specific script -->
<script>
  





  var selectedRowData; // Almacena los datos de la fila seleccionada
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
    var table = $('#example1').DataTable($.extend(commonOptions, {
        select: true
    }));

    // Deshabilitar el botón al principio
    $('#agregarInfoButton').prop('disabled', true);

    // Estilos CSS en línea para resaltar la fila seleccionada
    var selectedRowStyle = "background-color: #3498db; color: #ffffff;";

    // Evento para seleccionar una fila
    table.on('select', function(e, dt, type, indexes) {
        var selectedRowData = table.rows({ selected: true }).data();
        var hasData = selectedRowData.length > 0;

        // Habilitar el botón cuando se selecciona una fila
        $('#agregarInfoButton').prop('disabled', !hasData);
    });

    // Evento para deseleccionar una fila
    table.on('deselect', function(e, dt, type, indexes) {
        var selectedRowData = table.rows({ selected: true }).data();
        var hasData = selectedRowData.length > 0;

        // Deshabilitar el botón cuando se deselecciona una fila
        $('#agregarInfoButton').prop('disabled', !hasData);
    });

    // Aplicar estilos CSS en línea para resaltar la fila seleccionada
    table.on('draw', function() {
        var selectedRows = table.rows({ selected: true }).nodes();
        selectedRows.each(function() {
            $(this).attr('style', selectedRowStyle);
        });
    });
  });



    function abrirAgregarInfoModal() {
        // Mostrar el modal para añadir información
        $('#agregarInfoModal').modal('show');
    }

    function guardarInformacion() {
    // Obtener los datos del formulario de añadir información
    var entr_camar = $('#entr_camar').val();
    var entr_hora = $('#entr_hora').val();
    var color_evento = $('input[name="color_evento"]:checked').val();

    // Obtener los datos de la fila seleccionada
    var table = $('#example1').DataTable();
    var selectedRowData = table.row('.selected').data();

    // Comprobar si se ha seleccionado una fila válida
    if (selectedRowData && selectedRowData.length > 0) {
        var selectedRowId = selectedRowData[0];

        // Realiza la solicitud AJAX para guardar la información en la base de datos
        $.ajax({
            type: 'POST',
            url: '../bd-archivo/guardar_informacion.php', // Cambia esto al archivo PHP en tu servidor
            data: {
                id: selectedRowId,
                fecha: entr_camar,
                hora: entr_hora,
                color: color_evento
            },
            success: function(response) {
                // Aquí puedes manejar la respuesta del servidor si es necesario
                //alert('Información guardada: ' + response);
                $('#agregarInfoModal').modal('hide'); // Cierra el modal después de guardar
                window.location.href = '../UI/Seguimiento-camara-salida.php';
            },
            error: function(xhr, status, error) {
                // Manejar errores si es necesario
                console.error('Error al guardar la información: ' + error);
                alert('Error al guardar la información. Consulta la consola para más detalles.');
            }
        });
    } else {
        // No se ha seleccionado una fila válida, puedes mostrar un mensaje de error o tomar otra acción.
        console.error('No se ha seleccionado una fila válida.');
        alert('Selecciona una fila válida antes de guardar la información.');
    }
}



  
  function cerrarModal(){
		$("#agregarInfoModal").modal("hide");
	}

</script>
</body>
</html>
