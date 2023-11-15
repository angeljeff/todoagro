<?php

$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Insertar nueva mesada si se enviaron datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["mesada"];
    $capacidad = $_POST["capacidad"];
    $libre = $_POST["capacidad"];

    $sql = "INSERT INTO mesada (Nombre, CapacidadBandejas,Libre) VALUES ('$nombre', '$capacidad',
    '$libre')";

    if ($db->query($sql) === TRUE) {
        echo "Mesada agregada con éxito.";
    } else {
        echo "Error al agregar la mesada: " . $db->error;
    }
}
// Consulta para obtener las mesadas existentes
$sql = "SELECT * FROM Mesada";
$result = $db->query($sql);

// Cerrar la conexión
$db->close();
// Redirigir a la página de administración
header("Location: ../UI/Administrativo-mesadas.php");
?>
