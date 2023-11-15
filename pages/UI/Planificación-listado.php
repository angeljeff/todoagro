<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Planificación de Producción de Plántulas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Planificación</li>
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
            <div class="card card-green card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-edit"></i>
                  Añadir Planificación</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>N° Pl</th>
                    <th>Fecha de la planificación</th>
                    <th>Orden</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cant. solicitada</th>
                    <th>Cant. plantas aproximadas</th>
                    <th>Cant. Bandejas planificadas</th>
                    <th>Encargado de la producción</th>
                    
                    <th>Accion</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $select = "SELECT pl.*, 
                      CONCAT(c.nombre, ' ', c.apellido) AS NombreCliente,
                      CONCAT(h.NombreHortaliza, ' ', v.NombreVariedad) AS Producto,
                      CONCAT(u.nombre, ' ', u.apellido) AS NombreEmpleado

                      FROM 
                          planificacionpedidos pl

                      JOIN pedido p ON p.PedidoID = pl.OrdenID
                      JOIN cliente c ON p.ClienteID = c.id_cliente
                      JOIN usuarios u ON u.id_usu = pl.Empleado
                      JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
                      JOIN variedades v ON p.VariedadProductoPlantulas = v.VariedadID
                      JOIN tipobandeja tb ON tb.TipoBandejaID = pl.Bandejas
                      
                      
                      ";
                      $resp = $db->query($select);
                      while($fila = $resp->fetch_array()){
                        
                    ?>
                    <tr>
                      <td><?php echo $fila['PlanificacionPedidosID']; ?></td>
                      <td><?php echo $fila['FechaPlanificacion']; ?></td>
                      <td><?php echo $fila['OrdenID']; ?></td>
                      <td><?php echo $fila['NombreCliente']; ?></td>
                      <td><?php echo $fila['Producto']; ?></td>
                      <td><?php echo $fila['CantidadPlantas']; ?></td>
                      <td><?php echo $fila['plantasreales']; ?></td>
                      <td><?php echo $fila['CantidadBandejas']; ?></td>
                      <td><?php echo $fila['NombreEmpleado']; ?></td>
                      <td class="project-actions text-center">
                        <a href='../bd-archivo/eliminar-planificacion.php?id=<?php echo $fila['PlanificacionPedidosID']; ?>' class="elimi"><button type="button" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i>
                        </button></a>
                      </td>
                    </tr>
                    <?php } ?>
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

<!-- jQuery -->
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

  

  
</script>
</body>
</html>