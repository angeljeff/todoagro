<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$nom = $_POST['nombre'];
$ape = $_POST['apellido'];
$ced = $_POST['cedula'];
$celu = $_POST['celular'];
$cor = $_POST['correo'];
$direc = $_POST['direccion'];
$id= $_POST['idcliente'];

// Se utiliza la consulta UPDATE para editar los datos existentes
$select = "UPDATE cliente SET 
    nombre = '$nom',
    apellido = '$ape',
    cedula = '$ced',
    celular = '$celu',
    correo = '$cor',
    direccion = '$direc'
    WHERE id_cliente = $id";
$db->query($select);
header("location:../UI/Administrativo-clientes.php");
?>