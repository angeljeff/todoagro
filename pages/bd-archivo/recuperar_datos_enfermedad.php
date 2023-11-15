<?php
include('../bd-archivo/buscar_datos_enfermedad.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["orden"])) {
    $orden = $_GET["orden"];

    // Obtener datos del pedido
    $datosPedido = obtenerDatosPedido($orden);

    // Enviar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($datosPedido);
} else {
    // Manejar el caso en el que no se proporciona un código de pedido válido
    http_response_code(400); // Código de respuesta HTTP 400 Bad Request
    echo json_encode(array("mensaje" => "Código de pedido no válido."));
}
?>