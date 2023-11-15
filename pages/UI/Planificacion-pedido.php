<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
    date_default_timezone_set('America/Guayaquil');
  }

  include('../bd-archivo/buscar_datos_planificacion.php');
  
  $codigo_pedido = "";
  $datosPedido = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $codigo_pedido = $_POST["codigo_pedido"];
      $datosPedido = obtenerDatosPedido($codigo_pedido);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Advanced form elements</title>

  <link rel="icon" href="../img/logo.webp" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!--       DATATABLES           -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  
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
              <form id="pplanificado" method="POST" action="../bd-archivo/ingreso-planificacion-pedido.php">
                <div class="form-group">
                  <!--CARD 1-->
                  <div class="card-body">
                    <div class="card">
                        <div class="card-header bg-gradient-cyan">
                          <div class="card-title"><i class="nav-icon fas fa-pen"></i>  DATOS DE INGRESO</div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-5">
                            </div>
                            
                              <div class="col-md-7">
                                <div class="row justify-content-end">
                                  <div class="col-md-3">
                                    <label>Orden N°: </label>
                                  </div>
                                  <div class="col-md-2">
                                    <input type="text" class="form-control" id="codigo_pedido" name="codigo_pedido" onchange="cargarDatosAutomaticamente()" required></input>                                
                                  </div>
                                  <!--<div class="col-md-2">
                                    <button type="submit" value="Buscar Pedido" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>                               
                                  </div>-->
                                </div>
                              </div>

                              <div class="col-md-12 ">
                                  <label>Cliente</label>
                                  <input type="text" class="form-control" name="campo1" id="campo1" readonly></input>
                              </div>

                              <div class="col-md-6">
                                  <label>Producto:</label>
                                  <input type="text" class="form-control" name="campo2" id="campo2" readonly></input>
                              </div>
                              <div class="col-md-6">
                                <label>Cantidad de Plantas Solicitada:</label>
                                <input type="text" class="form-control" name="campo3" id="campo3" readonly></input>
                              </div>

                            <div class="col-md-6">
                                <label>Fecha de Planificación:</label>
                                <input type="date" class="form-control" id="fecha_plan" name="fecha_plan">
                            </div>

                            <div class="col-md-6">
                              <label>Hora:</label>
                              <div class="input-group date" id="timepicker" data-target-input="nearest">
                                <input type="text" id="hora" name="hora" class="form-control datetimepicker-input" data-target="#timepicker" onkeypress="bloquearEntrada(event)"/>
                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                              </div>
                              <span class="text-muted">Formato: HH:MM (por ejemplo, 09:30)</span>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <!--CARD 2-->
                  <div class="card-body">
                    <div class="card">
                        <div class="card-header bg-gradient-cyan">
                          <div class="card-title"><i class="nav-icon fas fa-address-book"></i> ASIGNACIÓN DE MATERIALES Y TRABAJADOR</div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Empleado:</label>
                                <select class="form-control select2" id="empleado" name="empleado" style="width: 100%;">
                                <option value="" disabled selected>Seleccione un elemento</option> <!-- Opción por defecto -->
                                  <?php
                                    // 
                                    $query = "SELECT u.nombre, u.id_usu, u.apellido FROM usuarios u INNER JOIN rol r ON u.rol_ID = r.id_rol where r.nombreid = 'empleado' ";
                                    $result = $db->query($query);
                                    
                                    // Itera a través de los resultados y crea opciones para el campo select
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id_usu'];
                                        $nombreempleado = $row['nombre'];
                                        $apellidoempleado = $row['apellido'];
                                        $Completoempleado =  $nombreempleado.' '.$apellidoempleado;
                                        echo "<option value='$id'>$Completoempleado</option>";
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                              <label>Codigo de sobre:</label>
                              <input type="text" id="codsobre" name="codsobre" class="form-control"></input>
                            </div>
                            <div class="col-md-3">
                                <label>Tipo de Bandeja:</label>
                                <select class="form-control select2" id="bandejas" name="bandejas" style="width: 100%;" >
                                <option value="" disabled selected>Seleccione</option> <!-- Opción por defecto -->
                                  <?php
                                    // 
                                    $query = "SELECT TipoBandejaID, Nombre FROM tipobandeja";
                                    $result = $db->query($query);
                                    // Itera a través de los resultados y crea opciones para el campo select
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['TipoBandejaID'];
                                        $tipobandeja = $row['Nombre'];
                                        echo "<option value='$id|$tipobandeja'>$tipobandeja</option>";
                                    }
                                  ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                              <label>Cant. de Bandejas:</label>
                              <div class="input-group date" id="timepicker" data-target-input="nearest">
                              <input type="number" id="cantBand" name="cantBand" class="form-control"  onchange="calcularPlantas()">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label>Cant. plantulas aproximadas a obtener:</label>
                              <div class="input-group date" id="timepicker" data-target-input="nearest">
                              <input type="number" id="cantplantasreales" name="cantplantasreales" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label>Cant. de Semilla:</label>
                              <input type="number" id="cantSemilla" name="cantSemilla" class="form-control"></input>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="card-footer text-center bg-transparent">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-primary" onclick="guardar('pplanificado', 'Ha sido agregado correctamente.')">GENERAR ORDEN DE SIEMBRA <i class="fa fa-save" aria-hidden="true"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- /.card-body -->
            </div>
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
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                      $select = "SELECT 
                      p.PedidoID, 
                      CONCAT(u.Nombre, ' ', u.Apellido) AS NombreCliente,
                      prod.NombreHortaliza,
                      variedad.NombreVariedad ,
                      p.CantidadPlantulas,
                      p.FechaSiembra,
                      p.FechaEntrega,
                      p.Observaciones,
                      p.DiasProduccion,
                      p.Estadopro
                      FROM Pedido p
                      INNER JOIN cliente u ON p.ClienteID = u.id_cliente
                      INNER JOIN Hortalizas prod ON p.ProductoPlantulasID = prod.HortalizaID
                      INNER JOIN Variedades variedad ON p.VariedadProductoPlantulas = variedad.VariedadID
                      WHERE p.Estadopro = 'Solicitado'";
                    $resp = $db->query($select);

                    while ($fila = $resp->fetch_array()) {
                        // Assign the correct badge based on Estado
                        $estadoClass = ($fila['Estadopro'] == 'Solicitado') ? 'badge-danger' : 'badge-secondary';
                    echo '
                    <tr>
                      <td>' . $fila['PedidoID']. '</td>
                      <td>' . $fila['NombreCliente']. '</td>
                      <td>' . $fila['NombreHortaliza']. '</td>
                      <td>' . $fila['CantidadPlantulas']. '</td>
                      <td>' . $fila['NombreVariedad']. '</td>  
                      <td>' . $fila['FechaSiembra']. '</td>
                      <td>' . $fila['FechaEntrega']. '</td>
                      <td><span class="badge ' . $estadoClass . '">' . $fila['Estadopro'] . '</span></td>
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

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- DATATABLES & PLUGINS-->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Page specific script -->
<script>

  function cargarDatosAutomaticamente() {
    var codigo_pedido = document.getElementById("codigo_pedido").value;
    var xhr = new XMLHttpRequest();
            
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var datos = JSON.parse(xhr.responseText);

                // Verificar si se recibieron datos válidos
                if (datos && datos.campo1 !== undefined && datos.campo2 !== undefined && datos.campo3 !== undefined) {
                    
                    document.getElementById("campo1").value = datos.campo1;
                    document.getElementById("campo2").value = datos.campo2;
                    document.getElementById("campo3").value = datos.campo3;
                } else {
                    // Mostrar un mensaje de error
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error',
                        text: 'Los datos no están disponibles o son inválidos.',
                    });
                    // Limpiar los campos
                    document.getElementById("campo1").value = "";
                    document.getElementById("campo2").value = "";
                    document.getElementById("campo3").value = "";
                }
            } else {
                // Manejar errores de solicitud (puedes mostrar un mensaje de error aquí)
                console.error("Error en la solicitud: " + xhr.status);
            }
        }
    };
            
    xhr.open("GET", "../bd-archivo/recuperar_datos.php?codigo_pedido=" + codigo_pedido, true);
    xhr.send();
  }

  function guardar(formId, successMessage) {
    const formulario = document.getElementById(formId);
    const campos = formulario.querySelectorAll('input[type="text"], input[type="number"], select, textarea');

    for (const campo of campos) {
        const valorCampo = campo.value.trim();

        if (!valorCampo) {
            const labelCampo = campo.closest('.form-group').querySelector('label').innerText;
            Swal.fire({
                title: 'Error',
                text: `Por favor, complete todos los campos`,
                icon: 'error'
            });
            return false;
        }
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres guardar los cambios?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Guardado',
                text: successMessage,
                icon: 'success',
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {
                formulario.submit();
            });
        }
    });

    return false;
}


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

  })



function calcularPlantas() {
    const selectedValue = document.getElementById('bandejas').value;
    
    // Separar el valor en ID y Nombre
    const [id, nombre] = selectedValue.split('|');

    // Usar el ID y el Nombre según sea necesario
    console.log('ID del tipo de bandeja:', id);
    console.log('Nombre del tipo de bandeja:', nombre);

    const cantBandejas = parseInt(document.getElementById('cantBand').value, 10);

    if (!isNaN(id) && !isNaN(cantBandejas) && id !== '0') {
        const cantPlantasReales = nombre * cantBandejas;
        document.getElementById('cantplantasreales').value = cantPlantasReales;
    }
}


// Llama a calcularPlantas cuando se cambia el tipo de bandeja
document.getElementById('bandejas').addEventListener('change', calcularPlantas);

// Llama a calcularPlantas cuando se cambia la cantidad de bandejas
document.getElementById('cantBand').addEventListener('change', calcularPlantas);

const today = new Date().toISOString().split('T')[0]; 
// Establecer la fecha actual en el campo de fecha
document.getElementById('fecha_plan').value = today;

function bloquearEntrada(event) {
    const charCode = event.which || event.keyCode;
    // Bloquear números (0-9) y letras (a-zA-Z)
    if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122)) {
        event.preventDefault();
    }
}
</script>
</body>
</html>