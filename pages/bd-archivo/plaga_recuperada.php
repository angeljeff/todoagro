<?php
    $conn = new mysqli("localhost", "root", "", "todoagro");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    if (
        isset($_POST['orden']) &&
        isset($_POST['bandrecu']) &&
        isset($_POST['bandperd'])
        
    ) {
        $orden = $_POST['orden'];
        $bandrecu = $_POST['bandrecu'];
        $bandperd = $_POST['bandperd'];

        // Escapar los valores para evitar inyecciones SQL (opcional, pero recomendado)
        $orden = $conn->real_escape_string($orden);
        $bandrecu = $conn->real_escape_string($bandrecu);
        $bandperd = $conn->real_escape_string($bandperd);

        // Crear la consulta SQL para insertar los valores en la base de datos
        $sql = "INSERT INTO plantulasrecuperadas (orden, bandeja_recuperada, bandeja_perdida) 
        VALUES ('$orden', '$bandrecu', '$bandperd')";
    
// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
echo "Registro insertado correctamente.";
} else {
echo "Error al insertar el registro: " . $conn->error;
}
} else {
echo "Faltan campos en el formulario.";
}

// Cerrar la conexión a la base de datos
$conn->close();
header("Location: ../UI/Plagas-plantulas-recuperadas.php");
?>