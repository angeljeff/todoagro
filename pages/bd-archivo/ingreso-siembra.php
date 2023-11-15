<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

    // Insertar un nuevo tipo de insumo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numeroOrden = $_POST['numeroOrden'];
        $fechainicio = $_POST['fechainicio'];
        $horainicio = $_POST['horainicio'];
        $recibido = $_POST['recibido'];
        $bandejasutilizadas = $_POST['bandejasutilizadas'];

        $insert_query = "INSERT INTO siembra (IDPedido, HoraInicio
        , FechaInicio, BandejasUtilizadas, sobre_recibido) 
        VALUES ('$numeroOrden','$horainicio',
        '$fechainicio','$bandejasutilizadas','$recibido')";


        if (!$db->query($insert_query)) {
        throw new Exception("Error al ingresar la siembra: " . $db->error);
    }

    // Actualizar el estado en la tabla "Pedido"
    $update_query_pedido = "UPDATE Pedido SET Estadopro = 'EnSiembra' WHERE PedidoID = '$numeroOrden'";

    if (!$db->query($update_query_pedido)) {
        throw new Exception("Error al actualizar el estado del pedido: " . $db->error);
    }
}

// Redirigir a la página de administración
header("Location: ../UI/Seguimiento-siembra.php");
?>