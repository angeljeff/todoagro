<?php
// Conectar a la base de datos
$db = new mysqli("localhost", "root", "", "todoagro");
date_default_timezone_set('America/Guayaquil');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recuperar valores del formulario
    $reservaIdModal = $_POST['reservaIdModal'];
    $RecolectaID = $_POST['recolectaIdModal'];
    $fecha = $_POST['fecha'];
    $pedido = $_POST['pedidoIdModal'];
    $cantPlantulas = $_POST['cantidadReservadaModal'];
    $cantBandejasDesocupadas = $_POST['cantBandejasDesocupadas'];
    $cajasUtilizadas = $_POST['cajasUtilizadas'];
    $tipoEmpaque = $_POST['tipoEmpaque'];
    $MesadaID = $_POST['mesadaIdModal'];

    // Utilizar una consulta preparada para insertar en la tabla "pedidoentregado"
    $insert_query = "INSERT INTO pedidoentregado (PedidoID, RecolectaID, FechaEntrega, PlantulasEntregadas, CajasUtilizadas, BandejasDesocupadas, TipoEmpaque)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta de inserción
    $stmt = $db->prepare($insert_query);

    if ($stmt) {
        // Vincular los parámetros a la consulta de inserción
        $stmt->bind_param("sssssss", $pedido, $RecolectaID, $fecha, $cantPlantulas, $cajasUtilizadas,$cantBandejasDesocupadas, $tipoEmpaque);

        // Ejecutar la consulta de inserción
        if ($stmt->execute()) {
            // La inserción fue exitosa

            // Restaurar la cantidad de bandejas desocupadas en la mesada
            $update_mesada_query = "UPDATE mesada SET Libre = Libre + ? WHERE MesadaID = ?";
            $stmt = $db->prepare($update_mesada_query);

            if ($stmt) {
                // Vincular los parámetros y ejecutar la consulta de actualización en la tabla "mesadas"
                $stmt->bind_param("ss", $cantBandejasDesocupadas, $MesadaID);
                if ($stmt->execute()) {
                    // Actualizar el estado del reserva a "Entregado" en la tabla "reserva"
                    $update_pedido_query = "UPDATE reservas SET Estado_Reserva = 'Entregado' WHERE ID_Reserva = ?";
                    $stmt = $db->prepare($update_pedido_query);

                    if ($stmt) {
                        // Vincular el parámetro y ejecutar la consulta de actualización en la tabla "pedido"
                        $stmt->bind_param("s", $reservaIdModal);
                        if ($stmt->execute()) {
                            // Actualizar la tabla "recolectaplantas" descontando "CantidadRecolectada" y "SobranteBandeja"
                            $update_recolecta_query = "UPDATE recolectaplantas SET SobranteBandeja = SobranteBandeja - ? WHERE RecolectaID = ?";
                            $stmt = $db->prepare($update_recolecta_query);

                            if ($stmt) {
                                // Vincular los parámetros y ejecutar la consulta de actualización en la tabla "recolectaplantas"
                                $stmt->bind_param("ss", $cantBandejasDesocupadas, $RecolectaID);
                                if ($stmt->execute()) {
                                    echo "Los datos se han guardado exitosamente, la cantidad de bandejas desocupadas en la mesada se ha restaurado, el estado del pedido se ha actualizado a 'Entregado' y se han descontado las cantidades en la tabla 'recolectaplantas'.";
                                    header("Location: ../UI/Seguimiento-listado-pedido.php");
                                    exit; 
                                } else {
                                    echo "Error al ejecutar la consulta de actualización en 'recolectaplantas': " . $stmt->error;
                                }
                            } else {
                                echo "Error al preparar la consulta de actualización en 'recolectaplantas': " . $db->error;
                            }
                        } else {
                            echo "Error al ejecutar la consulta de actualización de estado de pedido: " . $stmt->error;
                        }
                    } else {
                        echo "Error al preparar la consulta de actualización de estado de pedido: " . $db->error;
                    }
                } else {
                    echo "Error al ejecutar la consulta de actualización en mesadas: " . $stmt->error;
                }
            } else {
                echo "Error al preparar la consulta de actualización en mesadas: " . $db->error;
            }
        } else {
            // Hubo un error al ejecutar la consulta de inserción
            echo "Error al ejecutar la consulta de inserción: " . $stmt->error;
        }

        // Cerrar la sentencia de inserción
        $stmt->close();
    } else {
        // Hubo un error al preparar la consulta de inserción
        echo "Error al preparar la consulta de inserción: " . $db->error;
    }
}
?>
