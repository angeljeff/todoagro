<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$id_cliente = $_GET['id'];

$select = "DELETE FROM cliente WHERE id_cliente = $id_cliente";
$db->query($select);

header("location:../UI/Administrativo-clientes.php");



?>