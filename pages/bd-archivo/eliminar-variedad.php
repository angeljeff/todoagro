<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}


function eliminarTipoBandeja($TipoBandejaID) {
    global $db;  // Acceso a la conexión global

    $sql = "DELETE FROM tipobandeja WHERE TipoBandejaID = $TipoBandejaID";
    if ($db->query($sql)) {
        echo "Producto Plantulas eliminado correctamente.";
    } else {
        echo "Error al eliminar Producto Plantulas: " . $db->error;
    }
}

function eliminarVariedadProductoPlantulas($variedadID) {
    global $db;  // Acceso a la conexión global

    $sql = "DELETE FROM variedades WHERE VariedadID = $variedadID";
    if ($db->query($sql)) {
        echo "Variedad Producto Plantulas eliminada correctamente.";
    } else {
        echo "Error al eliminar Variedad Producto Plantulas: " . $db->error;
    }
}

function eliminarTipoProductoPlantulas($TipoHortalizaID) {
    global $db;  // Acceso a la conexión global

    $sql = "DELETE FROM tiposhortaliza WHERE TipoHortalizaID = $TipoHortalizaID";
    if ($db->query($sql)) {
        echo "Tipo Producto Plantulas eliminado correctamente.";
    } else {
        echo "Error al eliminar Tipo Producto Plantulas: " . $db->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];

    if ($tipo === 'tipobandeja') {
        eliminarTipoBandeja($id);
    } elseif ($tipo === 'variedad') {
        eliminarVariedadProductoPlantulas($id);
    } elseif ($tipo === 'tipo') {
        eliminarTipoProductoPlantulas($id);
    } else {
        echo "Tipo de producto plantulas no válido.";
    }
}
?>
