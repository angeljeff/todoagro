<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Insertar en insumo producto general
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Utiliza consultas preparadas para evitar inyección SQL
    $insert3_query = $db->prepare("INSERT INTO insumo (Proveedor, FechaVenci, IDProductoInsumo, IDTipoInsumo) VALUES (?, ?, ?, ?)");
    $Tipoinsumo = $_POST['tipoinsumo'];
    $Productoinsumo = $_POST['productoinsumo'];
    $Fechavenc = $_POST['fechavenc'];
    $NomProveedor = $_POST['nombreproveedor'];

    $insert3_query->bind_param("ssii", $NomProveedor, $Fechavenc, $Productoinsumo, $Tipoinsumo);
    if ($insert3_query->execute()) {
        echo "Insumo agregado correctamente.";
    } else {
        echo "Error al ingresar el insumo producto general: " . $db->error;
    }
}

// Eliminar un insumo
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Utiliza consultas preparadas para evitar inyección SQL
    $delete_query = $db->prepare("DELETE FROM insumo WHERE InsumoID = ?");
    $delete_query->bind_param('i', $id); // 'i' indica que es un parámetro de tipo entero
    $delete_query->execute();

    if ($delete_query->affected_rows > 0) {
        echo "Registro eliminado correctamente.";
    } else {
        echo "Error al eliminar el registro: " . $db->error;
    }
}
$nuevoProductoInsumoID = obtenerNuevoProductoInsumoID();  // Reemplaza con la lógica real para obtener el nuevo ID
$nuevoTipoInsumoID = obtenerNuevoTipoInsumoID();  // Reemplaza con la lógica real para obtener el nuevo ID

// Imprime una llamada a la función para actualizar el select
echo "<script>actualizarSelectPrincipal('$nuevoProductoInsumoID', '$nuevoTipoInsumoID');</script>";
// Redirigir a la página de administración
header("Location: ../UI/Administrativo-insumo.php");
?>
