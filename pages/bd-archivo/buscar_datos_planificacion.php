<?php

function obtenerDatosPedido($codigo_pedido) {
    $db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
    if ($db->connect_error) {
        die("Error en la conexión: " . $db->connect_error);
    }
        $sql = "SELECT pedido.PedidoID, CONCAT(cliente.nombre, ' ', cliente.apellido) AS NombreCliente, hortalizas.NombreHortaliza, pedido.CantidadPlantulas 
		FROM pedido  
		INNER JOIN cliente  ON cliente.id_cliente = pedido.ClienteID 
		INNER JOIN hortalizas  ON hortalizas.HortalizaID = pedido.ProductoPlantulasID 
		WHERE pedido.PedidoID = '$codigo_pedido'";
        $result = $db->query($sql);

        $datosPedido = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $datosPedido["codigo_pedido"] = $row["PedidoID"];
        $datosPedido["campo1"] = $row["NombreCliente"];
        $datosPedido["campo2"] = $row["NombreHortaliza"];
        $datosPedido["campo3"] = $row["CantidadPlantulas"];
        // Agrega más campos según sea necesario
    }

    

    $db->close();

    return $datosPedido;
}
?>