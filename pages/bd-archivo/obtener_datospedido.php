<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

if (isset($_POST['orden'])) {
    $pedidoID = intval($_POST['orden']);

    // Consulta para obtener los datos del pedido
    $consultaPedido = "SELECT u.nombre, h.NombreHortaliza, p.CantidadPlantulas,
                        th.NombreTipo, tb.Nombre, pl.CantidadBandejas, pl.plantasreales,
                        s.BandejasUtilizadas, p.CantidadPlantulas
                       FROM Pedido p
                       INNER JOIN cliente  u ON u.id_cliente = p.ClienteID 
                       INNER JOIN hortalizas h  ON h.HortalizaID = p.ProductoPlantulasID 
                       INNER JOIN tiposhortaliza th  ON th.TipoHortalizaID = p.TipoProductoPlantulas
                       JOIN planificacionpedidos pl ON pl.OrdenID = p.PedidoID
                       JOIN tipobandeja tb ON tb.TipoBandejaID = pl.Bandejas
                       JOIN Siembra s ON p.PedidoID = s.IDPedido
                       WHERE p.PedidoID = $pedidoID";

    $resultadoPedido = $db->query($consultaPedido);

    if ($resultadoPedido && $resultadoPedido->num_rows > 0) {
        $row = $resultadoPedido->fetch_assoc();
        $clienteID = $row['nombre'];
        $productoID = $row['NombreHortaliza'];
        $cantidadPlantulas = $row['CantidadPlantulas'];
        $tipoProducto = $row['NombreTipo'];
        $tipoBandeja = $row['Nombre'];
        $plantas = $row['CantidadPlantulas'];
        $bandejasplanificadas = $row['CantidadBandejas'];
        $bandejasUtilizadas = $row['BandejasUtilizadas'];
        $plantasReales = $row['plantasreales'];
        $bandejasPerdidas = $row['bandeja_perdida'];

        // Calcular otros valores necesarios
        $bpedidas = $bandejasplanificadas; // Número de bandejas pedidas
        $bsembrada = $bandejasUtilizadas; // Bandejas total sembradas
        $btotales = $bandejasUtilizadas - $bandejasPerdidas; // Bandejas actuales en invernadero
        $plantaspedidas = $plantasReales; // Plantas pedidas

        // Calcular el total de plantulas
        $totalplantulas = $tipoBandeja * $btotales;

        // Crear un arreglo asociativo con los datos
        $datos = array(
            "clienteID" => $clienteID,
            "productoID" => $productoID,
            "tipoProducto" => $tipoProducto,
            "tipoBandeja" => $tipoBandeja,
            "bpedidas" => $bpedidas,
            "bsembrada" => $bsembrada,
            "plantas" => $plantas,
            "btotales" => $btotales,
            "plantaspedidas" => $plantaspedidas,
            "totalplantulas" => $totalplantulas,
            "Estadopro" => "EnInvernadero"
        );

        // Devolver la respuesta en formato JSON
        echo json_encode($datos);
    } else {
        echo "No se encontró el pedido en estado de invernadero.";
    }
} else {
    echo "No se recibió el número de orden.";
}

$db->close();
?>
