<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $mesadaId = $db->real_escape_string($_POST['mesadaId']);
    $pedidoId = $db->real_escape_string($_POST['pedidoId']);
    $numBandejas = $db->real_escape_string($_POST['mesada']);
    $fecha = $_POST['fechaActual'];

    // Realizar la actualización en la base de datos para la cantidad 'libre'
    $sqlUpdate = "UPDATE Mesada SET Libre = Libre - $numBandejas WHERE MesadaID = $mesadaId";
    if ($db->query($sqlUpdate) === TRUE) {
        echo "Cantidad 'libre' actualizada correctamente.";
    } else {
        echo "Error al actualizar la cantidad 'libre': " . $db->error;
    }

    // Convertir la fecha al formato correcto para MySQL (yyyy-mm-dd)
    $fechaMySQL = date('Y-m-d', strtotime($fecha));

    // Realizar la inserción para guardar el ID del pedido y la ID de la mesada
    $sqlInsert = "INSERT INTO Invernadero (fechainvernadero, PedidoID, MesadaID) VALUES ('$fechaMySQL', '$pedidoId', '$mesadaId')";

    if ($db->query($sqlInsert) === TRUE) {
        echo "Se ha guardado la relación entre el pedido y la mesada.";
    } else {
        echo "Error al guardar la relación entre el pedido y la mesada: " . $db->error;
    }

    // Actualizar el estado en la tabla "Pedido"
    $update_query_pedido = "UPDATE Pedido SET Estadopro = 'EnInvernadero' WHERE PedidoID = '$pedidoId'";

    if ($db->query($update_query_pedido) === TRUE) {
        echo "Se ha actualizado el estado del pedido.";
    } else {
        echo "Error al actualizar el estado del pedido: " . $db->error;
    }
}

// Redirigir a la página de administración
header("Location: ../UI/Seguimiento-trasplantes.php");
?>
