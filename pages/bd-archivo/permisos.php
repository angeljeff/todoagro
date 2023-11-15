<?php
include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

if (isset($_POST['guardar_permisos'])) {
// Obtén los valores de los permisos del formulario
$permisos = $_POST['permisos'];

// Loop a través de los permisos y actualiza la base de datos según sea necesario
foreach ($permisos as $modulo => $permiso) {
    // Asegúrate de validar y analizar los datos adecuadamente aquí para evitar ataques.
    $r = 1;
    $w = 0;
    $u = 1;
    $d = 0;
    // Ejemplo de SQL para actualizar los permisos (esto debe adaptarse a tu esquema real)
    $sql = "UPDATE permisos SET
        r = '$r', 
        w = '$w', 
        u = '$u', 
        d = '$d' 
        WHERE rol_Id = ? AND modulo_id = ?";

    // Preparar la declaración SQL
    $stmt = $conexion->prepare($sql);

    // Vincular los valores de los permisos a la declaración SQL
    $stmt->bind_param("iiiiii", $permiso['r'], $permiso['w'], $permiso['u'], $permiso['d'], $id_rol, $id_modulo);

    // Debes definir $id_rol y $id_modulo con los valores correspondientes.

    // Ejecutar la declaración SQL
    $stmt->execute();
}

// Cierra la conexión a la base de datos
$conexion->close();

// Redirige de vuelta a la página del formulario o muestra un mensaje de éxito
header("Location: formulario_permisos.html?exito=1");
exit();
}
?>