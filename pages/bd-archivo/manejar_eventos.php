<?php
// Conexión a la base de datos (reemplaza con tus datos)

$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

$codigo_pedido = $_POST['codigo_pedido'];

$update_query_pedido = "UPDATE Pedido SET Estadopro = 'EnCamara' WHERE PedidoID = '$codigo_pedido'";

if ($db->query($update_query_pedido)) {
    echo "Actualización exitosa";
} else {
    echo "Error al actualizar: " . $db->error;
}

// Cierra la conexión a la base de datos
$db->close();
?>
