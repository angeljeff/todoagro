<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

    // Insertar un nuevo tipo de insumo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['Nombre'];
        $insert_query = "INSERT INTO tipoinsumo (Nombre) VALUES ('$nombre')";
        if (!$db->query($insert_query)) {
            throw new Exception("Error al ingresar el tipo de insumo: " . $db->error);
        }
    }

    // Eliminar un insumo
    if (isset($_GET['id'])) {
        $TipoInsumoID = $_GET['id'];
        $delete_query = "DELETE FROM tipoinsumo WHERE TipoInsumoID = $TipoInsumoID";
        if (!$db->query($delete_query)) {
            throw new Exception("Error al eliminar el insumo: " . $db->error);
        } else {
            echo "Insumo eliminado correctamente.";
        }
    }

// Verificar si es una solicitud Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    // No es una solicitud Ajax, redirigir
    header("Location: ../UI/Administrativo-insumo.php");
    exit();
}
?>
