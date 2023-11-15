<?php
session_start();
include("conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

if (isset($_POST['usuario']) && isset($_POST['contrasena']) ) {
  function validate($data){
    $data = trim($data);
    $data =stripcslashes($data);
    $data =htmlspecialchars($data);
    return $data;
  }
  
  $usuario = validate($_POST["usuario"]);
  $contrasena = validate($_POST["contrasena"]);

  if (empty($usuario)){
    header("Location: ../login-todoagro.php?error=El usuario es requerido");
    exit();
  }elseif (empty($contrasena)){
    header("Location: ../login-todoagro.php?error=La contraseña es requerido");
    exit();
  }else{

    //$contrasena = md5($contrasena);

    $sql = "select * from usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena' AND estado=1";
    $result = $db->query($sql);
    
    if (mysqli_num_rows($result) === 1){
      $row = mysqli_fetch_assoc($result);
      if ($row['usuario'] === $usuario && $row['contrasena'] === $contrasena){
        $_SESSION['id_usu'] = $row['id_usu'];
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellido'] = $row['apellido'];
        $_SESSION['contrasena'] = $row['contrasena'];
        $_SESSION['id_rol'] = $row['rol_Id'];
        header("Location: ../dashboard.php");
        exit();
      }else {
        header("Location: ../login-todoagro.php?error= El usuario o la clave son incorrectas");
        exit();
      }

    }else {
      header("Location: ../login-todoagro.php?error= El usuario o la clave son incorrectas");
      exit();
    }
  }

} else{
  header("Location: ../login-todoagro.php");
  exit();
}



?>