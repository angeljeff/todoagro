<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['form_id'])) {
    $form_id = $_POST['form_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mensaje_error = '';

        if ($form_id === 'variedad_semilla') {
            $nombrehortaliza = $_POST['nombrehortaliza'];
            $Nomvariedad = $_POST['variedadsemilla'];
            $color = $_POST['color'];

            $insert_query = "INSERT INTO variedades (NombreVariedad, HortalizaID, color) VALUES (?, ?, ?)";
            $stmt = $db->prepare($insert_query);
            $stmt->bind_param("sis", $Nomvariedad, $nombrehortaliza, $color);
        
        } elseif ($form_id === 'tipo_bandejas') {
            $tipobandeja = $_POST['tipobandeja'];

            $insert_query = "INSERT INTO tipobandeja (Nombre) VALUES (?)";
            $stmt = $db->prepare($insert_query);
            $stmt->bind_param("s", $tipobandeja);

        } else {
            echo "Formulario no reconocido.";
            exit;
        }

        if ($stmt->execute()) {
            header("Location: ../UI/Administrativo-productos-plantulas.php");
            exit;
        } else {
            $mensaje_error = "Error al ingresar el elemento: " . $stmt->error;
        }

        $stmt->close();

        // Si hay un error, mostrarlo
        if ($mensaje_error !== '') {
            echo $mensaje_error;
        }
    }
}
?>
