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
              Empleados
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
            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Empleado y rol
                </h3>
              </div>             
              <div class="card-body">
                <button type="button" class="btn btn-default text-primary" onclick="crearempleado()" >
                  Agregar nuevo empleado 
                  <i class="nav-icon far fa-plus-square"></i>
                </button>
                <br> </br>
                <div class="card">
                  <div class="card-header bg-gradient-success">
                    <h4 class="card-title">DATOS DE EMPLEADOS DE LA EMPRESA</h4>
                  </div>
                  <br>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table id="tabla4" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre y apellido</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Cedula</th>
                        <th>Celular</th> 
                        <th>Dirección</th>  
                        <th>Estado</th>
                        <th>Acción</th>                                            
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                          $select = "select u.*, r.nombreid 
                          FROM usuarios u 
                          INNER JOIN rol r ON u.rol_Id = r.id_rol
                          where r.nombreid != 'Cliente'
                          ";
                          $resp = $db->query($select);
                          while($fila = $resp->fetch_array()){
                            $estado = ($fila['estado'] == 1) ? '<span class="text-white bg-success rounded-pill px-2">Activo</span>'
                          : '<span class="text-white bg-danger rounded-pill px-2">Inactivo</span>';
                          ?>
                          <tr>
                            <td><?php echo $fila['id_usu']; ?></td>
                            <td><?php echo $fila['nombre'].' '.$fila['apellido']; ?></td>
                            <td><?php echo $fila['usuario']; ?></td>
                            <td><?php echo $fila['nombreid']; ?></td>
                            <td><?php echo $fila['cedula']; ?></td>
                            <td><?php echo $fila['celular']; ?></td>
                            <td><?php echo $fila['direccion']; ?></td>
                            <td><?php echo $estado; ?></td>
                            <td class="project-actions text-center">
                              <button type="button" class="btn btn-info btn-sm" onclick="editarempleado('<?php echo $fila['id_usu']; ?>','<?php echo $fila['nombre']; ?>',
                              '<?php echo $fila['apellido']; ?>','<?php echo $fila['usuario']; ?>','<?php echo $fila['cedula']; ?>','<?php echo $fila['celular']; ?>'
                              ,'<?php echo $fila['correo']; ?>','<?php echo $fila['direccion']; ?>')">
                              <i class="fas fa-pencil-alt"></i>     
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('<?php echo $fila['id_usu']; ?>')">
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

      <div class="modal" id="modal-empleado-agg" aria-hidden="true" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Empleado Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form enctype="multipart/form-data" id="empleado" method="POST" action="../bd-archivo/ingreso-usu.php">
              <div class="modal-body">
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
                <div class="form-group">
                  <label>Usuario y rol:</label>
                  <div class="row">
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario">
                    </div>
                    <!-- /.input group -->
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-creative-commons-nd"></i></span>                     
                      </div> 
                      <select class="form-control select2bs4" id="rol" name="rol">
                      <?php
                      // Realiza una consulta SQL para obtener los roles desde la tabla "roles"
                      $query = "SELECT id_rol, nombreid FROM rol";
                      $result = $db->query($query);
                      
                      // Itera a través de los resultados y crea opciones para el campo select
                      while ($row = $result->fetch_assoc()) {
                          $id = $row['id_rol'];
                          $nombreRol = $row['nombreid'];
                          
                          // Verifica si el nombre del rol no es "Cliente" y agrega la opción
                          if ($nombreRol != 'Cliente') {
                              echo "<option value='$id'>$nombreRol</option>";
                          }
                      }
                      ?>
                      </select>
                    </div>
                  </div>                   
                  <!-- /.input group -->
                </div>
                <!-- /.form group --> 
                
                <div class="row">
                  <div class="col">
                    <label>Celular:</label>
                  </div>
                  <div class="col">
                    <label>Cedula: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" id="celular" name="celular" onkeypress="return validarNumeros(event)"  data-inputmask='"mask": "(999) 999-9999"' data-mask>
                  </div>
                  <!-- /.input group -->
                  <div class="input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" onkeypress="return validarNumeros(event)" placeholder="Cedula" id="cedula" name="cedula">
                  </div>
                </div> 
                <div class="row">
                  <div class="input-group col">
                
                  </div>
                  <div class="input-group col">
                    <span id="resultadoCedula"></span>
                  </div>
                </div>

                <!-- /.Cedula -->
                <div class="form-group">
                  <label>Correo:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>                     
                    </div> 
                    <input type="email" class="form-control" placeholder="Correo" id="correo" name="correo" required>
                  </div>
                  <div>
                      <span id="correo-valido" style="color: green;"></span>
                      <span id="correo-invalido" style="color: red;"></span>
                    </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group --> 

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

                <div class="row">
                  <div class="col">
                    <label>Contraseña:</label>
                  </div>
                  <div class="col">
                    <label>Estado</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                  </div>
                  <!-- /.input group -->
                  <div class="input-group col">
                    <select name="estado" class="form-control select2bs4" >
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                  </div>
                </div> 
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardar('empleado', 'El empleado ha sido agregado correctamente.', 'modal-empleado-agg')">Guardar</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal" id="editar-empleado" aria-hidden="true" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-cyan">
              <h3 class=" modal-title">Empleado Todo Agro</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="editarempleado" method="POST" action="../bd-archivo/editar-usu.php">
            <input type="hidden" id="idusuario" name="idusuario"/>
              <div class="modal-body">
                <!-- /.nombre y apellidos -->
                <div class="form-group">
                  <label>Nombre y apellidos:</label>
                  <div class="row">
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Nombre" id="Unombre" name="nombre" onkeypress="return validarLetras(event)">
                    </div>
                    <!-- /.input group -->
                    <div class="input-group col">                       
                      <input type="text" class="form-control" placeholder="Apellido" id="Uapellido" name="apellido" onkeypress="return validarLetras(event)">
                    </div>
                  </div>                   
                  <!-- /.input group -->
                </div>
                <!-- /.form group --> 

                <!-- /.usuario y rol -->
                <div class="form-group">
                  <label>Usuario y rol:</label>
                  <div class="row">
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Usuario" id="Uusuario" name="usuario">
                    </div>
                    <!-- /.input group -->
                    <div class="input-group col">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-creative-commons-nd"></i></span>                     
                      </div> 
                      <select class="form-control select2bs4" style="width: 70%;" id="Urol" name="rol">
                      <?php
                          // Realiza una consulta SQL para obtener los roles desde la tabla "roles"
                          $query = "SELECT id_rol, nombreid FROM rol";
                          $result = $db->query($query);
                          
                          // Itera a través de los resultados y crea opciones para el campo select
                          while ($row = $result->fetch_assoc()) {
                              $id = $row['id_rol'];
                              $nombreRol = $row['nombreid'];
                              
                              // Verifica si el nombre del rol no es "Cliente" y agrega la opción
                              if ($nombreRol != 'Cliente') {
                                  echo "<option value='$id'>$nombreRol</option>";
                              }
                          }
                      ?>
                      </select>
                    </div>
                  </div>                   
                  <!-- /.input group -->
                </div>
                <!-- /.form group --> 
                
                <div class="row">
                  <div class="col">
                    <label>Celular:</label>
                  </div>
                  <div class="col">
                    <label>Cedula: </label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" id="Ucelular" name="celular" onkeypress="return validarNumeros(event)"  data-inputmask='"mask": "(999) 999-9999"' data-mask>
                  </div>
                  <!-- /.input group -->
                  <div class="input-group col">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-id-card"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="UCedula" id="Ucedula" name="cedula" readonly>
                  </div>
                </div> 
                <!-- /.Cedula -->
                <div class="form-group">
                  <label>Correo:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>                     
                    </div> 
                    <input type="email" class="form-control" placeholder="Correo" id="Ucorreo" name="correo">
                  </div>
                  <div class="input-group col">
                    <span id="Ccorreo-valido" style="color: green;"></span>
                    <span id="Ccorreo-invalido" style="color: red;"></span>
                  </div>
                </div>
                <div class="form-group">
                    <label>Dirección:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Dirección" id="Udireccion" name="direccion">
                    </div>
                    <!-- /.input group -->
                </div>
                <!-- /.form group --> 
                <div class="row">
                  <div class="col">
                    <label>Estado</label>
                  </div>
                </div>
                <div class="row">
                  <!-- /.input group -->
                  <div class="input-group col">
                    <select id="Uestado" name="estado" class="form-control select2bs4" >
                      <option value="1">Activo</option>
                      <option value="2">Inactivo</option>
                    </select>
                  </div>
                </div> 
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button"  class="btn btn-primary" onclick="guardar1('editarempleado', 'El Empleado ha sido agregado correctamente.', 'editar-empleado')">Guardar</button>
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

$(document).ready(function() {
    $('#example1').DataTable($.extend({}, commonOptions));
    $('#example2').DataTable($.extend({}, commonOptions));
    $('#tabla3').DataTable($.extend({}, commonOptions));
    $('#tabla4').DataTable($.extend({}, commonOptions));
    // Agrega más tablas aquí si es necesario
});

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
            window.location.href = "../bd-archivo/eliminar-usu.php?id=" + id;
        }
    });
  }

  function crearempleado(){
  $("#modal-empleado-agg").modal("show");
  }


function editarempleado(id,nombre,apellido,usuario,cedula,celular,correo,direccion){
  correoOriginal = correo;
  $("#idusuario").val(id);
  $("#editar-empleado").modal("show");
  $("#Unombre").val(nombre);
  $("#Uapellido").val(apellido);
  $("#Uusuario").val(usuario);
  $("#Ucedula").val(cedula);
  $("#Ucelular").val(celular);
  $("#Ucorreo").val(correo);
  $("#Udireccion").val(direccion);
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
const emailInput1 = document.getElementById("Ucorreo");
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
    // Aquí continúa el código para guardar los datos si ambos son válidos.
    // Agrega la lógica para enviar el formulario o realizar otras acciones.
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
