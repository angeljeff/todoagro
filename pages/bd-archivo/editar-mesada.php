<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

// Obtener los datos del formulario
$mesadaID = $_GET['mesadaID'];
$nuevoNombre = $_POST['nuevoNombre'];
$nuevaCapacidad = $_POST['nuevoCapacidad'];

// Preparar la consulta SQL para actualizar la mesada
$sql = "UPDATE mesada SET Nombre='$nuevoNombre', CapacidadBandejas= '$nuevaCapacidad' WHERE MesadaID='$mesadaID' ";

if ($db->query($sql) === TRUE) {
  echo "Mesada actualizada correctamente.";
} else {
  echo "Error al actualizar la mesada: " . $db->error;
}
// Redirigir a la página de administración
header("Location: ../UI/Administrativo-mesadas.php");
?>
