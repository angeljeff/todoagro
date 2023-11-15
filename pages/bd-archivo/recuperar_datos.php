<?php
include('../bd-archivo/buscar_datos_planificacion.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["codigo_pedido"])) {
    $codigo_pedido = $_GET["codigo_pedido"];

    // Obtener datos del pedido
    $datosPedido = obtenerDatosPedido($codigo_pedido);

    // Enviar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($datosPedido);
} else {
    // Manejar el caso en el que no se proporciona un código de pedido válido
    http_response_code(400); // Código de respuesta HTTP 400 Bad Request
    echo json_encode(array("mensaje" => "Código de pedido no válido."));
}
?>
