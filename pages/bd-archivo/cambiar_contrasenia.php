<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");
$id = $_POST['id'];
$pass = $_POST['new_pass'];

$sql = "UPDATE usuarios set contrasena = '$pass' where id_usu = '$id'";
$result = $db->query($sql);

if ($result) {
    $response = array("status" => "success", "message" => "Contraseña recuperada, ingresa con la nueva contraseña");
} else {
    $response = array("status" => "error", "message" => "Error al recuperar la contraseña");
}

echo json_encode($response);
exit();

?>