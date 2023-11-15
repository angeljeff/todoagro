<?php

function obtenerDatosPedido($orden) {
    $db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
    if ($db->connect_error) {
        die("Error en la conexión: " . $db->connect_error);
    }
        $sql = "SELECT pedido.PedidoID, usuarios.nombre, hortalizas.NombreHortaliza, planificacionpedidos.CantidadBandejas
        ,mesada.Nombre , plagaenfermedadtratadas.Band_Afectada
		FROM pedido  
		INNER JOIN usuarios  ON usuarios.id_usu = pedido.ClienteID 
		INNER JOIN rol ON usuarios.rol_ID = rol.id_rol 
		INNER JOIN hortalizas  ON hortalizas.HortalizaID = pedido.ProductoPlantulasID 
        INNER JOIN planificacionpedidos ON planificacionpedidos.OrdenID = pedido.PedidoID
        INNER JOIN invernadero ON invernadero.PedidoID = pedido.PedidoID
        INNER JOIN mesada ON mesada.MesadaID = invernadero.MesadaID
        INNER JOIN plagaenfermedadtratadas ON plagaenfermedadtratadas.OrdenID = pedido.PedidoID
		WHERE pedido.PedidoID = '$orden'";
        $result = $db->query($sql);

        $datosPedido = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $datosPedido["orden"] = $row["PedidoID"];
        $datosPedido["cliente"] = $row["nombre"];
        $datosPedido["prod"] = $row["NombreHortaliza"];
        $datosPedido["semb"] = $row["CantidadBandejas"];
        $datosPedido["mesada"] = $row["Nombre"];
        $datosPedido["bandafect"] = $row["Band_Afectada"];
        // Agrega más campos según sea necesario
    }

    

    $db->close();

    return $datosPedido;
}
?>