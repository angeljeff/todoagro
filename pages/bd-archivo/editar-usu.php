<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$nom = $_POST['nombre'];
$ape = $_POST['apellido'];
$usu = $_POST['usuario'];
$rol = $_POST['rol'];
$ced = $_POST['cedula'];
$celu = $_POST['celular'];
$cor = $_POST['correo'];
$direc = $_POST['direccion'];
$estado = $_POST['estado'];
$id= $_POST['idusuario'];

// Se utiliza la consulta UPDATE para editar los datos existentes
$select = "UPDATE usuarios SET 
    nombre = '$nom',
    apellido = '$ape',
    usuario = '$usu',
    rol_id = '$rol',
    cedula = '$ced',
    celular = '$celu',
    correo = '$cor',
    direccion = '$direc',
    estado = '$estado'
    WHERE id_usu = $id";
$db->query($select);
header("location:../UI/Administrativo-usuarios.php");
?>