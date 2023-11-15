<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fechaActividad = $_POST["fechaActividad"];
    $nombreActividad = $_POST["nombreActividad"];
    $observacion = $_POST["observacion"];
    
    $InvernaderoID = $_POST["InvernaderoID"];

    // Prevenir inyección de SQL usando sentencias preparadas
    $sql = "INSERT INTO actividad (fecha, nombre, observacion, id_invernadero) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $fechaActividad, $nombreActividad, $observacion, $InvernaderoID);

    if ($stmt->execute()) {
        echo "<script>window.location.href='../UI/Seguimiento-trasplantes.php';</script>";
    } else {
        echo "Error al agregar la actividad: " . $stmt->error;
    }

    $stmt->close();
}
// Cerrar la conexión
$db->close();

?>