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
                <h3 class="card-title">Envio de bandejas a invernadero</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  id="tuFormulario" action="../bd-archivo/ingresoinver-actumesada.php" method="post"> 
                <div class="card-body">
                  
                  <div class="row">
                    <div class="col">
                      <label><i class="fa fa-table"></i> Mesada: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                    <?php
                    $numBandejas = isset($_GET['numBandejas']) ? $_GET['numBandejas'] : '';
                    $pedidoId = isset($_GET['pedidoId']) ? $_GET['pedidoId'] : '';
                    $mesadaId = isset($_GET['mesadaId']) ? $_GET['mesadaId'] : '';
                    ?>
                    
                    <input type="hidden" id="pedidoId" name="pedidoId" value="<?php echo $pedidoId; ?>">
                    <input type="hidden" id="mesadaId" name="mesadaId" value="">
                    <input type="text" class="form-control" id="mesada" name="mesada" placeholder="Ingrese bandejas" value="<?php echo $numBandejas; ?>">
                    <input type="date" id="fechaActual" name="fechaActual" value="">
                  </div>
                    <div class="col">
                    <button type="button" class="btn btn-primary" onclick="confirmarEnvioInvernadero()"><i class="fas fa-paper-plane"
                    ></i> Enviar a invernadero </button>
                    </div>
                  </div>             
                </div>
              </form>
                <!-- /.card-body -->
              
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
                              echo '<div  id="mesadaCard' . $row["MesadaID"] . '" class="mesada-card" onclick="mesadaClicked(' . $row["MesadaID"] . ', ' . $row["CapacidadBandejas"] . ')" >';
                              echo '<p class="mesada-id">' . $row["MesadaID"] . '</p>';
                              echo '<p class="mesada-nombre">' . $row["Nombre"] . '</p>';
                              echo '<br>';
                              echo '<p class="mesada-capacidad">Capacidad: ' . $row["CapacidadBandejas"] . '</p>';
                              echo '<br>';
                              echo '<p class="mesada-libre">Libre: ' . $row["Libre"] . '</p>';
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

<!-- Add this script block at the end of your HTML file -->

var selectedMesadaId = null;  // Variable para almacenar la mesada seleccionada
  // Function to handle the click event on a Mesada
  function mesadaClicked(mesadaId, capacidadBandejas) {
  // Get the numBandejas value
  var numBandejas = parseInt(document.getElementById('mesada').value, 10);

  // Compare numBandejas with capacidadBandejas
  if (numBandejas > capacidadBandejas) {
    Swal.fire({
      icon: 'error',
      title: 'No hay suficiente capacidad en esta mesada',
      text: 'No se pueden enviar ' + numBandejas + ' bandejas.'
    });
  } else {
     // Limpiamos el color de fondo de la mesada anteriormente seleccionada, si hay alguna
     if (selectedMesadaId !== null) {
      var previousMesadaCard = document.getElementById('mesadaCard' + selectedMesadaId);
      previousMesadaCard.style.backgroundColor = '';  // Restablecer el color
    }

    // Actualizamos la mesada seleccionada
    selectedMesadaId = mesadaId;

    Swal.fire({
      icon: 'success',
      title: 'Mesada seleccionada',
      text: 'Se pueden enviar ' + numBandejas + ' bandejas.'
    });

    document.getElementById('mesadaId').value = mesadaId;

    // Enviar el ID de la mesada al servidor usando AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log("Respuesta del servidor: " + this.responseText);
      }
    };
    xhttp.open("POST", "ruta/a/ingresoinver-actumesada.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "mesadaId=" + mesadaId + "&pedidoId=" + <?php echo $pedidoId; ?> + "&numBandejas=" + numBandejas;
    xhttp.send(params);

    // Cambiar el color de fondo de la Mesada clickeada
    var mesadaCard = document.getElementById('mesadaCard' + mesadaId);
    mesadaCard.style.backgroundColor = 'green'; // Cambia esto al color deseado
  }
}

function confirmarEnvioInvernadero() {
  if (selectedMesadaId === null) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Seleccione una mesada antes de enviar.'
    });
    return; // No se puede enviar sin mesada seleccionada
  }

  // Obtener la cantidad de bandejas seleccionada
  var numBandejas = parseInt(document.getElementById('mesada').value, 10);

  if (numBandejas <= 0) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'La cantidad de bandejas debe ser mayor que 0.'
    });
    return; // No se puede enviar con cantidad de bandejas no válida
  }

  Swal.fire({
    title: 'Confirmación',
    text: '¿Desea enviar al invernadero?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, enviar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('tuFormulario').submit();
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  var fechaActual = new Date().toISOString().slice(0, 10); // Obtén la fecha actual en formato 'yyyy-mm-dd'
  document.getElementById('fechaActual').value = fechaActual;
});




</script>

</body>
</html>
