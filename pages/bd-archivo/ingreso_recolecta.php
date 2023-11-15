<?php
// Conectar a la base de datos
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar valores del formulario
    $idinver = $_POST['invernaderoID'];
    $fecha = $_POST['fecha'];
    $pedido = $_POST['pedidoID'];
    $cantBandeja = $_POST['cantBandeja'];
    $cantidadrecolectada = $_POST['countedPlants'];

    // Utilizar una consulta preparada para insertar en recolectaplantas
    $insert_query = "INSERT INTO recolectaplantas (InvernaderoID, FechaRecolecta, PedidoID, sobrantebandeja, CantidadRecolectada) VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta de inserción
    $stmt = $db->prepare($insert_query);

    if ($stmt) {
        // Vincular los parámetros a la consulta de inserción
        $stmt->bind_param("isidi", $idinver, $fecha, $pedido, $cantBandeja, $cantidadrecolectada);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            // La inserción fue exitosa

            // Actualizar el estado del pedido a "ListoEntrega"
            $update_query = "UPDATE pedido SET Estado = 'ListoEntrega' WHERE PedidoID = ?";
            $update_stmt = $db->prepare($update_query);

            if ($update_stmt) {
                $update_stmt->bind_param("i", $pedido);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                // Hubo un error al preparar la consulta de actualización
                echo "Error al preparar la consulta de actualización: " . $db->error;
            }

            header("location:../UI/Seguimiento-pedido-listo.php");
        } else {
            // Hubo un error al ejecutar la consulta de inserción
            echo "Error al ejecutar la consulta de inserción: " . $stmt->error;
        }

        // Cerrar la sentencia de inserción
        $stmt->close();
    } else {
        // Hubo un error al preparar la consulta de inserción
        echo "Error al preparar la consulta de inserción: " . $db->error;
    }
}
?>