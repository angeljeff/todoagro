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
  <title>AdminLTE 3 | Modals & Alerts</title>
  <?php
  include("../carpeta_css/stylesheet_css.php")
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
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
              Clientes
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modulo Administrativo</li>
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
            
            <div class="card card-warning card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Clientes
                </h3>
              </div>             
              <div class="card-body">
                <button type="button" class="btn btn-default text-primary" onclick="crearcliente()" >
                  Agregar nuevo cliente
                  <i class="nav-icon far fa-plus-square"></i>
                </button>
                <br> </br>
                <div class="card">
                  <div class="card-header bg-gradient-warning">
                    <h4 class="card-title">DATOS DE CLIENTES DE LA EMPRESA</h4>
                  </div>
                  <br>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table id="example2" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre y apellido</th>
                        <th>Cedula</th>
                        <th>Celular</th> 
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Acción</th>                                            
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                          $select = "select * 
                          FROM cliente";
                          $resp = $db->query($select);
                          while($fila = $resp->fetch_array()){
                          ?>
                          <tr>
                            <td><?php echo $fila['id_cliente']; ?></td>
                            <td><?php echo $fila['nombre'].' '.$fila['apellido']; ?></td>
                            <td><?php echo $fila['cedula']; ?></td>
                            <td><?php echo $fila['celular']; ?></td>
                            <td><?php echo $fila['correo']; ?></td>
                            <td><?php echo $fila['direccion']; ?></td>
                            <td class="project-actions text-center">
                              <button type="button" class="btn btn-info btn-sm" onclick="editarcliente('<?php echo $fila['id_cliente']; ?>','<?php echo $fila['nombre']; ?>','<?php echo $fila['apellido']; ?>','<?php echo $fila['cedula']; ?>','<?php echo $fila['celular']; ?>','<?php echo $fila['correo']; ?>','<?php echo $fila['direccion']; ?>')">
                              <i class="fas fa-pencil-alt"></i>     
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('<?php echo $fila['id_cliente']; ?>')">
                              <i class="fas fa-trash">
                              </i></button>
                            </td>
                          </tr>
                        <?php } ?>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                
              </div>
              <!-- /.card -->
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div><!-- /.container-fluid -->
      
      <div class="modal" id="modal-cliente-agg" aria-hidden="true" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Cliente Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" id="cliente" method="POST" action="../bd-archivo/ingreso-cliente.php">
              <div class="modal-body">
                    <!-- /.Cedula -->
                    <div class="form-group">
                      <label>Cedula:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Cedula" id="cedula" name="cedula" onkeypress="return validarNumeros(event)">
                      </div>
                      <div class="input-group col">
                        <span id="resultadoCedula"></span>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group --> 
                    <!-- /.nombre y apellidos -->
                    <div class="form-group">
                    <label>Nombre y apellidos:</label>
                    <div class="row">
                      <div class="input-group col">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre" onkeypress="return validarLetras(event)">
                      </div>
                      <!-- /.input group -->
                      <div class="input-group col">                       
                        <input type="text" class="form-control" placeholder="Apellido" id="apellido" name="apellido" onkeypress="return validarLetras(event)">
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>
                    <!-- /.form group --> 

                    <!-- /.usuario y rol -->
                  <div class="row">
                    <div class="col">
                      <label>Celular:</label>
                    </div>
                    <div class="col">
                      <label>Correo: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" class="form-control" id="celular" name="celular" onkeypress="return validarNumeros(event)" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    </div>
                    <!-- /.input group -->
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>                     
                      </div> 
                      <input type="email" class="form-control" placeholder="Correo" id="correo" name="correo">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group col">

                    </div>
                    <div class="input-group col">
                      <span id="correo-valido" style="color: green;"></span>
                      <span id="correo-invalido" style="color: red;"></span>
                    </div>
                  </div>
                    <!-- /.form group -->                                 
                    <!-- Direccion -->
                    <div class="form-group">
                      <label>Dirección:</label>
    
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Dirección" id="direccion" name="direccion">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button"  class="btn btn-primary" onclick="guardar('cliente', 'El Cliente ha sido agregado correctamente.', 'modal-cliente-agg')">Guardar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal" id="editar-cliente" aria-hidden="true" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Cliente Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="editarcliente" method="POST" action="../bd-archivo/editar-cliente.php">
              <input type="hidden" id="idcliente" name="idcliente"/>
              <div class="modal-body">
                    <!-- /.Cedula -->
                    <div class="form-group">
                      <label>Cedula:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Cedula" id="Ccedula" name="cedula" onkeypress="return validarNumeros(event)" readonly>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group --> 
                    <!-- /.nombre y apellidos -->
                    <div class="form-group">
                    <label>Nombre y apellidos:</label>
                    <div class="row">
                      <div class="input-group col">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" id="Cnombre" name="nombre">
                      </div>
                      <!-- /.input group -->
                      <div class="input-group col">                       
                        <input type="text" class="form-control" placeholder="Apellido" id="Capellido" name="apellido">
                      </div>
                    </div>                   
                    <!-- /.input group -->
                  </div>
                  <div class="row">
                    <div class="col">
                      <label>Celular:</label>
                    </div>
                    <div class="col">
                      <label>Correo: </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" class="form-control" id="Ccelular" name="celular" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    </div>
                    <!-- /.input group -->
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>                     
                      </div> 
                      <input type="email" class="form-control" placeholder="Correo" id="Ccorreo" name="correo">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-group col">

                    </div>
                    <div class="input-group col">
                      <span id="Ccorreo-valido" style="color: green;"></span>
                      <span id="Ccorreo-invalido" style="color: red;"></span>
                    </div>
                  </div>
                    <!-- /.form group -->                                 
                    <!-- Direccion -->
                    <div class="form-group">
                      <label>Dirección:</label>
    
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Dirección" id="Cdireccion" name="direccion">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button"  class="btn btn-primary" onclick="guardar1('editarcliente', 'El Cliente ha sido agregado correctamente.', 'editar-cliente')">Guardar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <?php
  include("../menu/footer.php")
  ?>                   
</div>

<?php
  include("../carpeta_css/script_js.php")
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

  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

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
    $('#tabla3').DataTable($.extend({}, commonOptions));
    $('#tabla4').DataTable($.extend({}, commonOptions));
    // Agrega más tablas aquí si es necesario
});

function validarNumeros(e) { // 1
  var tecla = (document.all) ? e.keyCode : e.which;// 2
  if (tecla==8) return true; // 3
  var patron =/[0-9]/; // 4
  var te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
}

function validarLetras(e) { // 1
  var tecla = (document.all) ? e.keyCode : e.which;// 2
  if (tecla==8) return true; // 3
  var patron =/[A-Za-z\s]/; // 4
  var te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
}

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
          window.location.href = "../bd-archivo/eliminar-cliente.php?id=" + id;
      }
  });
}

function crearcliente(){
  $("#modal-cliente-agg").modal("show");
}

function editarcliente(id,nombre,apellido,cedula,celular,correo,direccion){
  correoOriginal = correo;
  $("#idcliente").val(id);
  $("#editar-cliente").modal("show");
  $("#Cnombre").val(nombre);
  $("#Capellido").val(apellido);
  $("#Ccedula").val(cedula);
  $("#Ccelular").val(celular);
  $("#Ccorreo").val(correo);
  $("#Cdireccion").val(direccion);

   // Realizar la validación del correo original
  validarCorreoEdicion();
}

</script>
<script>
    // Evitar que el usuario retroceda usando el botón del navegador
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };

    // Redirigir a dashboard.php cuando el usuario intenta retroceder
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        window.location.href = "../../dashboard.php";
    });
//VALIDACION DE FORMULARIO, CORREO Y CEDULA
//formulario de agregar
const emailInput = document.getElementById("correo");
const correoValidoMsg = document.getElementById("correo-valido");
const correoInvalidoMsg = document.getElementById("correo-invalido");
const cedulaInput = document.getElementById("cedula");
const resultadoCedula = document.getElementById("resultadoCedula");

//formulario de editar
const emailInput1 = document.getElementById("Ccorreo");
const correoValidoMsg1 = document.getElementById("Ccorreo-valido");
const correoInvalidoMsg1 = document.getElementById("Ccorreo-invalido");


emailInput.addEventListener("input", validarCorreo);
emailInput1.addEventListener("input", validarCorreoEdicion);
cedulaInput.addEventListener("input", validarCedulaAutomatically); 

function validarCorreo() {
  const correo = emailInput.value;
  const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (regex.test(correo)) {
    correoValidoMsg.textContent = "Correo válido";
    correoInvalidoMsg.textContent = "";
  } else {
    correoValidoMsg.textContent = "";
    correoInvalidoMsg.textContent = "Correo no válido";
  }
}

function validarCorreoEdicion() {
  const correo = emailInput1.value;
  const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (regex.test(correo)) {
    correoValidoMsg1.textContent = "Correo válido";
    correoInvalidoMsg1.textContent = "";
  } else {
    correoValidoMsg1.textContent = "";
    correoInvalidoMsg1.textContent = "Correo no válido";
  }
}


function validarCedulaAutomatically() {
  const cedula = cedulaInput.value.trim();
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../bd-archivo/validar_cedula.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const response = xhr.responseText;
      if (response.trim() === "Cédula válida") {
        resultadoCedula.innerHTML = "Cédula válida";
        resultadoCedula.style.color = "green";
      } else {
        resultadoCedula.innerHTML = "Cédula no válida";
        resultadoCedula.style.color = "red";
      }
    }
  };
  xhr.send("cedula=" + cedula);
}

function guardar(formId, successMessage, modalId) {
  const correoValido = correoValidoMsg.textContent === "Correo válido";
  const cedulaValida = resultadoCedula.textContent === "Cédula válida";
  const formulario = document.getElementById(formId);
  const correoEditado = emailInput1.value;

  // Validar campos del formulario
  const campos = formulario.querySelectorAll('input, select');
  for (const campo of campos) {
    if (!campo.value.trim()) {
      Swal.fire({
        title: 'Error',
        text: 'Por favor, complete todos los campos.',
        icon: 'error'
      });
      return;
    }
  }
  if (correoValido && cedulaValida) {
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
      document.getElementById(formId).submit();
    });
  } else {
    Swal.fire({
      title: 'Error',
      text: 'Por favor, complete los campos correctamente.',
      icon: 'error'
    });
  }
}

// Función para guardar el formulario
function guardar1(formId, successMessage, modalId) {
  const correoEditado = emailInput1.value;
  const formulario = document.getElementById(formId);
  // Validar correo solo si se ha editado
  if (correoEditado !== correoOriginal) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!regex.test(correoEditado)) {
      Swal.fire({
        title: 'Error',
        text: 'El correo no es válido. Por favor, corríjalo antes de continuar.',
        icon: 'error'
      });
      return;
    }
  }
  
  // Validar otros campos del formulario si es necesario
  const campos = formulario.querySelectorAll('input, select');
  for (const campo of campos) {
    if (!campo.value.trim()) {
      Swal.fire({
        title: 'Error',
        text: 'Por favor, complete todos los campos.',
        icon: 'error'
      });
      return;
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
      document.getElementById(formId).submit();
    });
  }

</script>
</body>
</html>