<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$cor = $_POST["correo"];
if (filter_var($cor, FILTER_VALIDATE_EMAIL)) {
// El correo es válido
echo "Correo válido: " . $cor;
} else {
// El correo no es válido
echo "El correo no es válido.";
}
}

$nom = $_POST['nombre'];
$ape = $_POST['apellido'];
$usu = $_POST['usuario'];
$rol = $_POST['rol'];
$ced = $_POST['cedula'];
$celu = $_POST['celular'];
$contra = $_POST['contrasena'];
$direc = $_POST['direccion'];
$estado = $_POST['estado'];

$select = "INSERT INTO usuarios (nombre, apellido, usuario, rol_id, 
        cedula, celular, correo, direccion,contrasena, estado) 
        VALUES ('$nom', '$ape', '$usu', '$rol', '$ced',
        '$celu', '$cor', '$direc','$contra', '$estado')";
$db->query($select);
header("location:../UI/Administrativo-usuarios.php");
?>

