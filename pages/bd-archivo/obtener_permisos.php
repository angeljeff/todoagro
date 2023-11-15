<?php
// Verifica si se ha enviado el rolId por GET
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['rolId'])) {
    $rolId = $_GET['rolId'];

    // Conexión a la base de datos
    $db = new mysqli("localhost", "root", "", "todoagro");

    // Verifica la conexión
    if ($db->connect_error) {
        die("Error en la conexión: " . $db->connect_error);
    }

    // Consulta para obtener los permisos del rolId
    $sql = "SELECT * FROM permisos WHERE rol_Id = $rolId";  // Ajusta la consulta según tu estructura de base de datos

    $result = $db->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $db->error);
    }

    // Array para almacenar los permisos
    $permisos = array();

    while ($row = $result->fetch_assoc()) {
        $modulo_Id = $row['modulo_Id'];
        $accion = $row['accion'];
        $valor = $row['valor'];

        // Almacena los permisos en el array según el módulo
        if (!isset($permisos[$modulo_Id])) {
            $permisos[$modulo_Id] = array();
        }

        $permisos[$modulo_Id][$accion] = (bool)$valor;
    }

    // Cierra la conexión a la base de datos
    $db->close();

    // Devuelve los permisos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($permisos);
} else {
    // Si no se proporcionó el rolId, muestra un mensaje de error
    echo "Error: RolId no proporcionado o método no permitido";
}
?>
