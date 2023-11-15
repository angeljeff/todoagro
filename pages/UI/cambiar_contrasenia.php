<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../plugins/css-login/login.css"> <!-- 5, 10 -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- 5, 10 -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- 5, 10 -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet"> <!-- 5, 10 -->
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
                  <img src="../img/logo.webp" id="imagen-circular" alt="TodoAgro" class="img-fluid">
                </div>
                <br>
                <h2 class="fw-bold mb-2 text-uppercase" id="title-inicio">RECUPERA TU CONTRASEÑA</h2>
                <div class="row justify-content-center"> <!-- Agregamos la clase justify-content-center para centrar horizontalmente -->
                <form action="../bd-archivo/cambiar_contrasenia.php" method="POST">
                  <hr>

                  </hr>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Nueva contraseña:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user-circle"></i></span>
                        </div>
                        <input type="password" class="form-control"  id="new_pass" name="new_pass">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-md-12">
                      <div class="form-group">
                        <p><a class="text-dark-50" href=""></a></p>
                        <button class="boton-iniciar-sesion" type="submit">Recuperar</button>
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
<?php
  include("../carpeta_css/script_js.php");
?>
<script>
    // Evitar que el usuario retroceda usando el botón del navegador
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
    window.history.pushState(null, "", window.location.href);
    };


    document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      // Realizar la solicitud AJAX
      fetch(form.action, {
        method: form.method,
        body: new FormData(form),
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          
          Swal.fire({
            icon: 'success',
            title: 'Cambio de contraseña',
            text: data.message,
          }).then(() => {
          
            window.location.href = '../../login-todoagro.php';
          });
        } else {
         
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message,
          });
        }
      })
      .catch(error => console.error('Error:', error));
    });
  });

</script>
</body>
</html>
