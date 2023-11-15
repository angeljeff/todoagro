
<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

    // Eliminar 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Query para eliminar el registro
        $delete_query = "DELETE FROM plagaenfermedadtratadas WHERE PlagaEnfermedadTratadaID = $id";
        
        if ($db->query($delete_query) === TRUE) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al eliminar el registro: " . $db->error;
        }
    }
    
    
// Redirigir a la página de administración
header("Location: ../UI/Plagas-plantulas-tratadas.php");
?>