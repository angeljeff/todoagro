<?php
// Verifica si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conexión a la base de datos
    $db = new mysqli("localhost", "root", "", "todoagro");

    // Verifica la conexión
    if ($db->connect_error) {
        die("Error en la conexión: " . $db->connect_error);
    }

    // Obtén el rolId de los datos enviados
    $rolId = $_POST['rolId'];
    $moduloId = isset($_POST['moduloId']) ? $_POST['moduloId'] : null;
    $permisos = $_POST['permisos'];

    // Obtén los permisos del formulario
    $permisos = $_POST['permisos'];

    // Itera sobre los permisos y guárdalos en la base de datos
    foreach ($permisos as $modulo => $acciones) {
        $r = isset($acciones['r']) ? 1 : 0;
        $w = isset($acciones['w']) ? 1 : 0;
        $u = isset($acciones['u']) ? 1 : 0;
        $d = isset($acciones['d']) ? 1 : 0;
    
        // Agrega esta línea para depurar
        echo "Valores: r=$r, w=$w, u=$u, d=$d<br>";

        // Asumiendo que tienes una tabla 'permisos' con columnas 'rol_Id', 'modulo_Id', 'r', 'w', 'u', 'd'
        $sql = "INSERT INTO permisos (r, w, u, d, rol_Id, modulo_Id)
        VALUES ($r, $w, $u, $d, $rolId,
         (SELECT id_modulo FROM modulo WHERE nombre_modulo = '$modulo'))";

        if (!$db->query($sql)) {
            die("Error al guardar permisos: " . $db->error);
        }
    }

    // Cierra la conexión a la base de datos
    $db->close();

    // Responde con un mensaje de éxito o redirección
    echo "Permisos guardados exitosamente";
} else {
    // Si no es una solicitud POST, muestra un mensaje de error
    echo "Error: Método no permitido";
}
?>
