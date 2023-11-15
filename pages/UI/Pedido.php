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
            <h1>Pedidos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">PEDIDOS</li>
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
                  AGREGAR PEDIDO</h3>
                <div class="row">

                </div>
              </div>
              <!-- /.card-header -->
              <form id="pedido" method="POST" action="../bd-archivo/ingreso-pedido.php">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Cliente</label>
                          <select class="form-control select2bs4" id="cliente" name="cliente" style="width: 100%;">
                          <option value="" disabled selected>Seleccione un elemento</option> <!-- Opción por defecto -->
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
                        <!-- /.form-group -->
                      </div>
                      <!-- /.col -->
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Observaciones</label>
                          <textarea class="form-control" id="observaciones" name="observaciones" rows="1" placeholder="Ingrese la observación ..."></textarea>
                        </div>
                        <!-- /.form-group -->
                      </div>
                      <!-- /.col -->
                    </div>
                  </div>

                  <div id="mimodalpedido" class="modal" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content border-success">
                        <div class="modal-header bg-success">
                          <div class="modal-title">AGREGAR PEDIDO</div>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                      <label>Producto:</label>
                                      <select class="form-control select2bs4" id="producto" name="producto" style="width: 100%;" onchange="actualizarDias() ; actualizarVariedades() ">
                                      <option value="" disabled selected>Seleccione un elemento</option> <!-- Opción por defecto -->
                                        <?php
                                          // Realiza una consulta SQL para obtener los roles desde la tabla "roles"
                                          $query = "SELECT HortalizaID, NombreHortaliza,DiaProduccion FROM hortalizas";
                                          $result = $db->query($query);
                                          
                                          // Itera a través de los resultados y crea opciones para el campo select
                                          while ($row = $result->fetch_assoc()) {
                                              $id = $row['HortalizaID'];
                                              $nombrehortaliza = $row['NombreHortaliza'];
                                              $diasProduccion = $row['DiaProduccion'];
                                              echo "<option value='$id' data-dias='$diasProduccion'>$nombrehortaliza</option>";
                                          }
                                        ?>
                                      </select>
                                  </div>                                 
                                  <div class="col-md-6">
                                      <label>Variedad:</label>
                                      <select class="form-control select2bs4" id="variedadsemilla" name="variedadsemilla" style="width: 100%;" disabled>
                                        <option value="" disabled selected>Seleccione un elemento</option>
                                      </select>
                                  </div>
                                  <div class="col-md-12">
                                      <label>Cantidad de Plantas:</label>
                                      <input type="number" class="form-control" id="cantidadplantas" name="cantidadplantas"></input>
                                  </div>
                                  <div class="col-md-5">
                                      <label>Fecha Siembra:</label>
                                      <input type="date" class="form-control" id="fs-siembra" name="fs-siembra" onchange="calcularFechaEntrega()">
                                  </div>
                                  <div class="col-md-2">
                                      <label>Dias:</label>
                                      <input type="number" name="dias" id="dias" class="form-control" readonly></input>
                                  </div>
                                  <div class="col-md-5">
                                      <label>Fecha Entrega:</label>
                                      <input type="date" name="fe-pedido" id="fe-pedido" class="form-control">
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <button type="button" class="btn btn-outline-success" onclick="aparezcaModal()">AGREGAR PRODUCTO <i class="far fa-plus-square" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-outline-primary" onclick="guardar('pedido', 'Ha sido agregado correctamente.', 'mimodalpedido')">Guardar</button>
                  </div>
                </div>
              </form>
              <!-- /.card-body -->
            </div>
            <!--PRIMER MODAL-->
            
            <!-- /.card -->
    </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-warning card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-edit"></i>
                  LISTADO DE LOS PEDIDOS</h3>
                <div class="row">
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cant. Plantas Solicitadas</th>
                    <th>Variedad</th>
                    <th>Siembra Estimada</th>
                    <th>Fecha de Entrega</th>
                    <th>Estado Pedido</th>
                    <th>Estado</th>
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $select = "SELECT 
                      p.PedidoID, 
                      CONCAT(c.nombre, ' ', c.apellido) AS NombreCliente,
                      prod.NombreHortaliza,
                      variedad.NombreVariedad ,
                      p.CantidadPlantulas,
                      p.FechaSiembra,
                      p.FechaEntrega,
                      p.Observaciones,
                      p.DiasProduccion,
                      p.Estado,
                      p.Estadopro
                      FROM Pedido p
                      INNER JOIN cliente c ON p.ClienteID = c.id_cliente
                      INNER JOIN Hortalizas prod ON p.ProductoPlantulasID = prod.HortalizaID
                      INNER JOIN Variedades variedad ON p.VariedadProductoPlantulas = variedad.VariedadID;
                      ";
                    $resp = $db->query($select);

                    while ($fila = $resp->fetch_array()) {
                        // Assign the correct badge based on Estado
                        $estadoClass = '';
                        switch ($fila['Estado']) {
                          case 'ListoEntrega':
                              $estadoClass = 'badge-primary';
                              break;
                          case 'Entregado':
                              $estadoClass = 'badge-success';
                              break;
                          default:
                          $estadoClass = 'badge-secondary';
                          break;
                        }                 
                        // Assign the correct badge based on Estadopro
                        $estadoproClass = '';
                        switch ($fila['Estadopro']) {
                            case 'Solicitado':
                                $estadoproClass = 'badge-primary';
                                break;
                            case 'Planificado':
                                $estadoproClass = 'badge-warning';
                                break;
                            case 'EnSiembra':
                                $estadoproClass = 'badge-danger';
                                break;
                            case 'EnCamara':
                                $estadoproClass = 'badge-secondary';
                                break;
                            case 'EnInvernadero':
                                $estadoproClass = 'badge-success';
                                break;
                            default:
                                $estadoproClass = 'badge-secondary';
                                break;
                        }
                    echo '
                    <tr>
                      <td>' . $fila['PedidoID']. '</td>
                      <td>' . $fila['NombreCliente']. '</td>
                      <td>' . $fila['NombreHortaliza']. '</td>
                      <td>' . $fila['CantidadPlantulas']. '</td>
                      <td>' . $fila['NombreVariedad']. '</td>  
                      <td>' . $fila['FechaSiembra']. '</td>
                      <td>' . $fila['FechaEntrega']. '</td>
                      <td><span class="badge ' . $estadoClass . '">' . $fila['Estado'] . '</span></td>
                      <td><span class="badge ' . $estadoproClass . '">' . $fila['Estadopro'] . '</span></td>
                      <td class="project-actions text-center">
                          <button type="button" class="btn btn-danger btn-sm" onclick="eliminar(' . $fila['PedidoID'] . ')">
                              <i class="fas fa-trash">
                          </i></button>
                      </td>
                    </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
<?php
include("../carpeta_css/script_js.php");
?>
<!-- Page specific script -->
<script>
  function eliminar(id){
    Swal.fire({
        title: '¿Estás seguro de eliminar?',
        text: 'Una vez eliminado, no podrás recuperar este registro.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // El usuario confirmó la eliminación
            window.location.href = "../bd-archivo/ingreso-pedido.php?id=" + id;
        }
    });
  }
  
  function guardar(formId, successMessage, modalId) {
  const formulario = document.getElementById(formId);

  // Validar campos del formulario
  const campos = formulario.querySelectorAll('input, select');
  for (const campo of campos) {
    if (!campo.value.trim()) {
      Swal.fire({
        title: 'Error',
        text: 'Por favor, complete todos los campos.',
        icon: 'error'
      });
      return false;
    }
  }

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
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    $("#example1").DataTable({
      select:true,
      select: {items:'row'},
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print",]
      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function aparezcaModal(id, nom, cedu, fnaci){
		$("#mimodalpedido").modal("show");
	}

  function cerrarModal(){
		$("#mimodalpedido").modal("hide");
	}

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

  
  function actualizarDias() {
    var productoSelect = document.getElementById('producto');
    var selectedOption = productoSelect.options[productoSelect.selectedIndex];
    var diasProduccion = selectedOption.getAttribute('data-dias');

    if (diasProduccion) {
        document.getElementById('dias').value = diasProduccion;
    }
  }

  function calcularFechaEntrega() {
      var diasProduccion = parseInt(document.getElementById('dias').value);
      var fechaSiembra = document.getElementById('fs-siembra').value;

      if (fechaSiembra && diasProduccion) {
          var fechaEntrega = new Date(fechaSiembra);
          fechaEntrega.setDate(fechaEntrega.getDate() + diasProduccion);
          var formattedFechaEntrega = fechaEntrega.toISOString().split('T')[0];  // Formato: YYYY-MM-DD

          document.getElementById('fe-pedido').value = formattedFechaEntrega;
      }
  }

  function actualizarVariedades() {
  // Obtén el valor seleccionado en el primer select
  var hortalizaID = $("#producto").val();
  
  // Si se selecciona una hortaliza, habilita el segundo select
  if (hortalizaID) {
    $("#variedadsemilla").prop("disabled", false);
  } else {
    // Si no se selecciona ninguna hortaliza, deshabilita el segundo select y muestra el mensaje predeterminado
    $("#variedadsemilla").prop("disabled", true);
    $("#variedadsemilla").html('<option value="" disabled selected>Seleccione un elemento</option>');
    return;
  }

  // Realiza una solicitud AJAX para cargar las variedades de la hortaliza seleccionada
  $.ajax({
    url: '../bd-archivo/obtener_variedades.php', // Reemplaza con la URL de tu script PHP para obtener variedades
    type: 'POST',
    data: { hortalizaID: hortalizaID },
    success: function(data) {
      // Rellena el segundo select con las variedades obtenidas
      $("#variedadsemilla").html(data);
    }
  });
}

</script>
</body>
</html>