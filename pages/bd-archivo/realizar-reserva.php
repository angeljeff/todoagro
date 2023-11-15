<?php

$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Insertar nueva reserva si se enviaron datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idcliente = $_POST["cliente"];
    $idpedido = $_POST["PedidoID"];
    $idrecolecta = $_POST["RecolectaID"];
    $fechareserva = $_POST["fechaReserva"];
    $cantreservada = $_POST["cantidadReservada"];
    $fechaentregaposible = $_POST["fechaEntregaEstimada"];
    $estado = 'Reservado';

    // Insertar la reserva en la tabla de reservas
    $sql = "INSERT INTO reservas (ID_Cliente, ID_Pedido, ID_recolecta_stock, Cantidad_Reservada, Fecha_reserva, Fecha_Entrega_Estimada, Estado_Reserva) 
    VALUES ('$idcliente', '$idpedido', '$idrecolecta', '$cantreservada', '$fechareserva', '$fechaentregaposible', '$estado')";

    if ($db->query($sql) === TRUE) {
        // Actualizar la recolecta de plantas
        $update_recolecta_query = "UPDATE recolectaplantas SET CantidadRecolectada = CantidadRecolectada - $cantreservada WHERE RecolectaID = $idrecolecta";
        if ($db->query($update_recolecta_query) === TRUE) {
            echo "Reserva agregada con éxito y recolectaplantas actualizada.";
        } else {
            echo "Error al actualizar la recolectaplantas: " . $db->error;
        }
    } else {
        echo "Error al agregar la reserva: " . $db->error;
    }
}

// Cerrar la conexión
$db->close();

// Redirigir a la página de administración
header("Location: ../UI/Seguimiento-almacenaje.php");
?>