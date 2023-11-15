<?php
$db = new mysqli("localhost", "root", "", "todoagro");

// Verificar la conexión
if ($db->connect_error) {
    die("Error en la conexión: " . $db->connect_error);
}

    // Insertar en producto de insumo
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $CantProd = $_POST['Cantproducto'];
        $UnidadMedida = $_POST['Unidadmedida'];
        $CantMedida = $_POST['Cantidadmedida'];
        $NomProd = $_POST['nombreproducto'];

        $insert2_query = "INSERT INTO productoinsumo (Nombre, UnidadMedida, CantidadStock, CantidadMedida, MedidaConteo) 
        VALUES ('$NomProd', '$UnidadMedida', '$CantProd', '$CantMedida', '$CantMedida' )";
        if (!$db->query($insert2_query)) {
            throw new Exception("Error al ingresar el producto de insumo: " . $db->error);
        }
    }

// Redirigir a la página de administración
header("Location: ../UI/Administrativo-insumo.php");
?>
