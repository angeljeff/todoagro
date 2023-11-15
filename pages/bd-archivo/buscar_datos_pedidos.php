<?php
// Conexión a la base de datos 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoagro";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Obtener el ID del cliente enviado por AJAX
if (isset($_POST['clienteID'])) {
    $clienteID = $_POST['clienteID'];

    // Consulta para obtener los pedidos del cliente
    $query = "SELECT 
                pl.OrdenID, 
                CONCAT(h.NombreHortaliza, ' ', th.NombreTipo) AS Producto,
                m.Nombre AS Nombremesada,
                s.BandejasUtilizadas,
                p.FechaEntrega,
                p.CantidadPlantulas,
                p.Estadopro
            FROM Pedido p
            INNER JOIN PlanificacionPedidos pl ON p.PedidoID = pl.OrdenID
            INNER JOIN siembra s ON p.PedidoID = s.IDPedido
            INNER JOIN Hortalizas h ON p.ProductoPlantulasID = h.HortalizaID
            INNER JOIN TiposHortaliza th ON p.TipoProductoPlantulas = th.TipoHortalizaID
            INNER JOIN invernadero i ON p.PedidoID = i.PedidoID
            INNER JOIN mesada m ON m.MesadaID = i.MesadaID
            WHERE p.Estadopro = 'EnInvernadero' AND p.ClienteID = $clienteID";

    $result = $conn->query($query);

    if ($result) {
      // Construir el HTML de las filas de la tabla
    $html = '';
    while ($fila = $result->fetch_assoc()) {
        $Estadopro = ($fila['Estadopro'] == "EnInvernadero") ? '<span class="badge badge-success">EnInvernadero</span>' : $fila['Estadopro'];

        $html .= '<tr>';
        $html .= '<td>' . $fila['OrdenID'] . '</td>';
        $html .= '<td>' . $fila['Producto'] . '</td>';
        $html .= '<td>' . $fila['Nombremesada'] . '</td>';
        $html .= '<td>' . $fila['BandejasUtilizadas'] . '</td>';
        $html .= '<td>' . $fila['CantidadPlantulas'] . '</td>';
        $html .= '<td>' . $fila['FechaEntrega'] . '</td>';
        $html .= '<td>' . $Estadopro . '</td>';
        $html .= '</tr>';
    }

    echo $html;
    } else {
    echo 'Error al ejecutar la consulta: ' . $conn->error;
    }
} else {
    echo 'ClienteID no proporcionado.';
}
?>