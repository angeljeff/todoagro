<?php

$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Obtén la hortalizaID de la solicitud POST
if (isset($_POST['hortalizaID'])) {
    $hortalizaID = $_POST['hortalizaID'];

    // Realiza una consulta SQL para obtener las variedades de la hortaliza seleccionada
    $query = "SELECT VariedadID, NombreVariedad FROM variedades WHERE HortalizaID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $hortalizaID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $options = "";

        while ($row = $result->fetch_assoc()) {
            $variedadID = $row['VariedadID'];
            $nombreVariedad = $row['NombreVariedad'];
            $options .= "<option value='$variedadID'>$nombreVariedad</option>";
        }

        echo $options;
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $db->close();
} else {
    echo "HortalizaID no proporcionado.";
}
?>