<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$id_usu = $_GET['id'];

$select = "DELETE FROM usuarios WHERE id_usu = $id_usu";
$db->query($select);

header("location:../UI/Administrativo-usuarios.php");

?>