<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}


function eliminarhortaliza($ProductoHortalizaID) {
    global $db;  // Acceso a la conexión global

    $sql = "DELETE FROM productohortaliza WHERE ProductoHortalizaID = $ProductoHortalizaID";
    if ($db->query($sql)) {
        echo "Producto Plantulas eliminado correctamente.";
    } else {
        echo "Error al eliminar Producto Plantulas: " . $db->error;
    }
}

function eliminarplantulas($ProductoPlantulasID) {
    global $db;  // Acceso a la conexión global

    $sql = "DELETE FROM productoplantulas WHERE ProductoPlantulasID = $ProductoPlantulasID";
    if ($db->query($sql)) {
        echo "Variedad Producto Plantulas eliminada correctamente.";
    } else {
        echo "Error al eliminar Variedad Producto Plantulas: " . $db->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];

    if ($tipo === 'hortaliza') {
        eliminarhortaliza($id);
    } elseif ($tipo === 'plantulas') {
        eliminarplantulas($id);
    } else {
        echo "Tipo de producto plantulas no válido.";
    }
}
?>
