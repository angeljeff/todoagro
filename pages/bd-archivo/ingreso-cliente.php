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
$ced = $_POST['cedula'];
$celu = $_POST['celular'];
$direc = $_POST['direccion'];

$select = "INSERT INTO cliente (nombre, apellido, 
        cedula, celular, correo, direccion) 
        VALUES ('$nom', '$ape', '$ced',
        '$celu', '$cor', '$direc')";
$db->query($select);
header("location:../UI/Administrativo-clientes.php");
?>