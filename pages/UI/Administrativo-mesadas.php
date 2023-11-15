<?php
  session_start();
  if(empty($_SESSION['id_usu'])) {
    header("location:../../index.php");
  }
?>
<!DOCTYPE html><html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Modals & Alerts</title>
  
  <?php
  include("../carpeta_css/stylesheet_css.php");
  ?>
  
  <!-- Mesadas -->
  <link rel="stylesheet" type="text/css" href="../../plugins/css-mesada/mesada.css">
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
            <h1>Mesadas en el Invernadero</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Mesada</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Agregar nueva mesada</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  id="mesonForm" action="../bd-archivo/ingreso-mesones.php" method="post"> 
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <label><i class="fa fa-table"></i> Mesada: </label>
                    </div>
                    <div class="col">
                      <label><i class="fas fa-pencil-alt"></i> Capacidad: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" id="mesada" name="mesada" placeholder="Ingrese mesada">
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" id="capacidad" name="capacidad" placeholder="Ingrese capacidad">
                    </div>
                  </div>             
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="button" class="btn btn-primary" onclick="guardar('mesonForm', 'La mesada ha sido agregada correctamente.')">Agregar Mesada </button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">MESONES</h3>
              </div>
              <div class="card-body">
                <?php
                  echo '<div class="card-container">';

                  // Consulta para obtener las mesadas existentes
                  $sql = "SELECT * FROM Mesada";
                  $result = $db->query($sql);
                  
                  // Verifica si la consulta se ejecutó correctamente antes de acceder a num_rows
                  if ($result === false) {
                      echo "Error al ejecutar la consulta: " . $db->error;
                  } else {
                      // Comprueba si hay resultados
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              // Mostrar cada mesada en un cuadrado
                              echo '<div  id="mesadaCard' . $row["MesadaID"] . '" class="mesada-card" onclick="abrirModalEdicion(' . $row["MesadaID"] . ', \'' . $row["Nombre"] . '\', ' . $row["CapacidadBandejas"] . ')">';
                              echo '<p class="mesada-id">' . $row["MesadaID"] . '</p>';
                              echo '<p class="mesada-nombre">' . $row["Nombre"] . '</p>';
                              echo '<br>';
                              echo '<p class="mesada-capacidad">Capacidad: ' . $row["CapacidadBandejas"] . '</p>';
                              echo '</div>';
                          }
                      } else {
                          echo "0 resultados";
                      }
                  }
                  
                  echo '</div>';  // Cierre del contenedor de cuadrados
                  
                ?>

              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="modal" id="modalEditarMesada" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog"  role="document">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title" id="modalEditarMesadaLabel">Cliente Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="editarMesadaForm" method="post">
              <div class="modal-body">
                <!-- Contenido del modal -->
                <div class="form-group">
                  <label for="editMesada">Mesada:</label>
                  <input type="text" class="form-control" id="editMesada" name="nuevoNombre" placeholder="Ingrese mesada">
                </div>
                <div class="form-group">
                  <label for="editCapacidad">Capacidad:</label>
                  <input type="number" class="form-control" id="editCapacidad" name="nuevoCapacidad" placeholder="Ingrese capacidad">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary"  id="guardarButton" >Guardar</button>
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
<?php
  include("../carpeta_css/script_js.php");
?>

<script>

  function abrirModalEdicion(id, nombre, capacidad) {
    // Obtén el cuadro correspondiente al MesadaID
    var cuadro = document.getElementById('mesadaCard' + id);

    // Almacena el color original y cambia el color al hacer clic
    cuadro.dataset.originalColor = cuadro.style.backgroundColor;
    cuadro.style.backgroundColor = 'red';

    // Rellenar los campos del modal con la información de la mesada
    document.getElementById('editMesada').value = nombre;
    document.getElementById('editCapacidad').value = capacidad;

    // Configurar la acción del formulario para editar la mesada
    var form = document.getElementById('editarMesadaForm');
    form.action = '../bd-archivo/editar-mesada.php?mesadaID=' + id;

    // Cambiar el tipo del botón "Guardar" a "submit"
    var guardarButton = document.getElementById('guardarButton');
    guardarButton.type = 'submit';

    // Restaurar el color original al cerrar el modal
    $('#modalEditarMesada').on('hidden.bs.modal', function (e) {
        cuadro.style.backgroundColor = cuadro.dataset.originalColor;
    });

    // Abrir el modal
    $('#modalEditarMesada').modal('show');
  }


  function guardar(formId, successMessage) {
    const formulario = document.getElementById(formId);
    const campo = formulario.querySelector('input[type="text"], input[type="number"], select, textarea');
    const valorCampo = campo.value.trim();

    if (!valorCampo) {
        Swal.fire({
            title: 'Error',
            text: 'Por favor, complete todos los campos.',
            icon: 'error'
        });
        return false;
    }

    Swal.fire({
        title: 'Guardado',
        text: successMessage,
        icon: 'success',
        timer: 1000, // La alerta se cierra después de 3 segundos (3000 ms)
        timerProgressBar: true,
        showConfirmButton: false // Oculta el botón de confirmación
    }).then(() => {
        formulario.submit();
    });
    return false;
  }


</script>
</body>
</html>
