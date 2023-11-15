<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Insertar un nuevo tipo de insumo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_id = $_POST['form_id']; // Added to identify the form being submitted

    if ($form_id === 'hortalizaForm') {
        $nombre = $_POST['hortaliza'];
        $dias = $_POST['diapro'];
        $diascamara = $_POST['diacamara'];

        $insert_query = "INSERT INTO hortalizas (NombreHortaliza, DiaProduccion, DiaCamara)
        VALUES ('$nombre','$dias','$diascamara' )";

    }

    if (!$db->query($insert_query)) {
        throw new Exception("Error al ingresar el hortaliza: " . $db->error);
    }
}
// Redirigir a la página de administración
header("Location: ../UI/Administrativo-productos-plantulas.php");
?>
