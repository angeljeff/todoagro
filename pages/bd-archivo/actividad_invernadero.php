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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del invernadero enviado por AJAX
    $InvernaderoID = $_POST['InvernaderoID'];

    // Consultar las actividades anteriores para el invernadero
    $query = "SELECT fecha, nombre, observacion
              FROM actividad
              WHERE id_invernadero = ?";

    $statement = $conn->prepare($query);
    $statement->bind_param("i", $InvernaderoID);
    $statement->execute();
    $result = $statement->get_result();
    $actividades = $result->fetch_all(MYSQLI_ASSOC);
    // Devolver las actividades en formato JSON
    echo json_encode($actividades);
}
?>


