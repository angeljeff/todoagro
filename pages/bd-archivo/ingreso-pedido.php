<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Insertar en  general
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Cliente = $_POST['cliente'];
        $Observaciones = $_POST['observaciones'];
        $Estado = 'Pendiente';
        $Producto = $_POST['producto'];
        $Variedadsemilla = $_POST['variedadsemilla'];
        $Cantidad = $_POST['cantidadplantas'];
        $Fechasiembra = $_POST['fs-siembra'];
        $Dias = $_POST['dias'];
        $Fechaentrega = $_POST['fe-pedido'];

        $insert3_query = "INSERT INTO pedido(ClienteID, ProductoPlantulasID,
            CantidadPlantulas, FechaSiembra, FechaEntrega, Observaciones, DiasProduccion,
            VariedadProductoPlantulas, Estado) 
        VALUES ('$Cliente', '$Producto', '$Cantidad', '$Fechasiembra', '$Fechaentrega',
                '$Observaciones','$Dias', '$Variedadsemilla',
                '$Estado')";
        if (!$db->query($insert3_query)) {
            throw new Exception("Error al ingresar el PEDIDO: " . $db->error);
        }
    }
    // Eliminar 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Query para eliminar el registro
        $delete_query = "DELETE FROM pedido WHERE PedidoID = $id";
    
        if ($db->query($delete_query) === TRUE) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al eliminar el registro: " . $db->error;
        }
    }
    
    
// Redirigir a la página de administración
header("Location: ../UI/Pedido.php");
?>