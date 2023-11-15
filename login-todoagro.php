<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Login style -->
  <link rel="stylesheet" href="plugins/css-login/login.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
</head>
<body>
    <section class="content">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-dark" style="border-radius: 5rem;">
            <div class="card-body p-15 text-center">
              <div class="mb-md-5 mt-md-4">
                <div >
                  <img src="pages/img/logo.webp" id="imagen-circular" alt="TodoAgro" class="img-fluid">
                </div>
                <br>
                <h2 class="fw-bold mb-2 text-uppercase" id="title-inicio">INICIAR SESIÓN</h2>
                <div class="row justify-content-center"> <!-- Agregamos la clase justify-content-center para centrar horizontalmente -->
                <form action="bd/inicar-login.php" method="POST">
                  <hr>
                  <?php
                  if (isset($_GET['error'])) {
                    ?>
                    <p class="error">
                      <?php
                      echo $_GET['error'];
                      ?>
                    </p>
                  <?php
                  }
                  ?>
                  <?php
                    if(isset($_GET['message'])){
                  ?>
                      <div class="alert alert-primary" role="alert">
                        <?php
                          switch ($_GET['message']) {
                            case 'ok':
                              echo 'Por favor, revisa tu correo';
                              break;
                            
                            default:
                              echo 'Algo salió mas, intenta más tarde';
                              break;
                          }
                        ?>
                      </div>
                  <?php
                    }
                  ?>
                  </hr>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Usuario:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Ingrese su usuario" id="usuario" name="usuario">
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Contraseña:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                          </div>
                          <input type="password" class="form-control" placeholder="Ingrese contraseña" id="contrasena" name="contrasena">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-md-12">
                      <div class="form-group">
                        <button class="boton-iniciar-sesion" type="submit">Ingresar</button>
                        <p><a class="text-dark-50" href="pages/UI/recuperar_contrasenia.php">Cambiar Contraseña?</a></p>
                      </div>
                    </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
    // Evitar que el usuario retroceda usando el botón del navegador
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
    window.history.pushState(null, "", window.location.href);
    };
</script>
</body>
</html>
