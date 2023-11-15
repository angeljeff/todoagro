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
            <div class="card card-warning card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-edit"></i>
                  LISTADO DE LOS PEDIDOS</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>Fecha Entrego</th>
                          <th>N° Orden</th>
                          <th>Cliente</th>
                          <th>Producto</th>
                          <th>Plantas Entregadas</th>
                          <th>Total de Cajas</th>
                          <th>Empaque</th>
                          <th>Estado Pedido</th>
                      </tr>
                    </thead>
                  <tbody>
                  <?php
                              $select = "SELECT DISTINCT p.PedidoID,
                              CONCAT(u.nombre, ' ', u.apellido) AS NombreCliente,
                              CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                              pe.FechaEntrega,
                              pe.PlantulasEntregadas,
                              pe.CajasUtilizadas,
                              pe.TipoEmpaque,
                              p.Estado

                              FROM Pedido p
                              JOIN Cliente u ON p.ClienteID = u.id_cliente
                              JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
                              JOIN variedades v ON p.VariedadProductoPlantulas = v.VariedadID
                              JOIN pedidoentregado pe ON pe.PedidoID = p.PedidoID                             
                              WHERE p.Estado = 'Entregado'  " ;

                              $resp = $db->query($select);
                              while($fila = $resp->fetch_array()){
                                $Estado = ($fila['Estado'] == "Entregado") ? '<span class="badge badge-primary">Entregado</span>'
                                : $fila['Estado'];
                                
                          ?>
                          <tr class='fila-tabla' data-pedido='<?php echo json_encode($fila); ?>' data-toggle='modal' data-target='#infoModal'>
                            <td><?php echo $fila['FechaEntrega']; ?></td>  
                            <td><?php echo $fila['PedidoID']; ?></td>
                            <td><?php echo $fila['NombreCliente']; ?></td>
                            <td><?php echo $fila['Producto']; ?></td>
                            <td><?php echo $fila['PlantulasEntregadas']; ?></td>
                            <td><?php echo $fila['CajasUtilizadas']; ?></td>
                            <td><?php echo $fila['TipoEmpaque']; ?></td>
                            <td><?php echo $Estado; ?></td>
                          </tr>
                          <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
<!-- ./wrapper -->

<?php
include("../carpeta_css/script_js.php");
?>
<!-- Page specific script -->
<script>

  $('.elimi').on('click', function(e) {
    e.preventDefault();
    const href= $(this).attr('href')
    Swal.fire({
      title: 'Está seguro de borrar el producto?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar'
    }).then((result) => {
      if (result.value ) {
        document.location.href= href;
      }else{
                
        }
    })
  })
  
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
    $('#example2').DataTable($.extend({}, commonOptions));
    // Agrega más tablas aquí si es necesario
});

  function aparezcaModal(){
		$("#mimodalpedido").modal("show");
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

</script>
</body>
</html>