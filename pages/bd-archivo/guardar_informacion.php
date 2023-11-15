<?php
// Conexión a la base de datos (ajusta esto a tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoagro";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos de la solicitud AJAX
$id = $_POST['id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$color = $_POST['color'];

$sql = "INSERT INTO camaragerminacion (id_orden, fecha, hora, color) VALUES ($id, '$fecha', '$hora', '$color')";

// Actualizar el estado en la tabla "Pedido"
$update_query_pedido = "UPDATE Pedido SET Estadopro = 'EnCamara' WHERE PedidoID = '$id'";

if (!$conn->query($update_query_pedido)) {  // Use $conn instead of $dbPlanificacion
    throw new Exception("Error al actualizar el estado del pedido: " . $conn->error);
}
if ($conn->query($sql) === TRUE) {
    echo "Información guardada con éxito.";
} else {
    echo "Error al guardar la información: " . $conn->error;
}

header("location:../UI/Seguimiento-camara-salida.php");
$conn->close();

?>
