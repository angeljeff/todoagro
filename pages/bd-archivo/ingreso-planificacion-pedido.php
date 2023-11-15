 <?php
    include('../bd-archivo/buscar_datos_pedidos.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $codigo_pedido = $_POST["codigo_pedido"];
        $campo1 = $_POST["campo1"];
        $campo2 = $_POST["campo2"];
        $campo3 = $_POST["campo3"];
        $fecha_plan = $_POST["fecha_plan"];
        $hora = $_POST["hora"];
        $empleado = $_POST["empleado"];
        $bandejas = $_POST["bandejas"];
        $cantBand = $_POST["cantBand"];
        $cantSemilla = $_POST["cantSemilla"];
        $plantasreales = $_POST["cantplantasreales"];

        // Asegúrate de tener una conexión a la base de datos de planificación
        $dbPlanificacion = new mysqli("localhost", "root", "", "todoagro");

        // Verificar la conexión
        if ($dbPlanificacion->connect_error) {
            die("Error en la conexión a la base de datos de planificación: " . $dbPlanificacion->connect_error);
        }

        // Preparar la consulta SQL para insertar los datos
        $sqlInsert = "INSERT INTO planificacionpedidos (OrdenID, CantidadPlantas,
        FechaPlanificacion, HoraIngreso, Empleado, Bandejas, CantidadBandejas, CantidadSemilla,plantasreales) 
        VALUES ('$codigo_pedido','$campo3','$fecha_plan','$hora','$empleado',
        '$bandejas','$cantBand','$cantSemilla','$plantasreales')";

        if (!$dbPlanificacion->query($sqlInsert)) {
            throw new Exception("Error al ingresar el insumo producto general: " . $dbPlanificacion->error);
        }

          // Actualizar el estado en la tabla "Pedido"
        $update_query_pedido = "UPDATE Pedido SET Estadopro = 'Planificado' WHERE PedidoID = '$codigo_pedido'";

        if (!$dbPlanificacion->query($update_query_pedido)) {
            throw new Exception("Error al actualizar el estado del pedido: " . $db->error);
        }

    } else {
        // Manejar el caso en el que no se haya enviado una solicitud POST válida
        http_response_code(400); // Código de respuesta HTTP 400 Bad Request
        echo json_encode(array("mensaje" => "Solicitud no válida."));
    }
header("Location: ../UI/Planificacion-pedido.php");
?>
