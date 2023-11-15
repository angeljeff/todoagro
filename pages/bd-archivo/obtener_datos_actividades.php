<?php
    // Conexión a la base de datos

    $db = new mysqli("localhost", "root", "", "todoagro");

    // Verificar la conexión
    if ($db->connect_error) {
        die("Error en la conexión: " . $db->connect_error);
    }


    // Obtener el ProductoInsumoID enviado a través de POST
    $productoID = $_POST['productoID'];

    // Realiza una consulta SQL para obtener los datos del producto
    $query = "SELECT productoinsumo.ProductoInsumoID, productoinsumo.CantidadStock,
    productoinsumo.CantidadMedida, insumo.FechaVenci, productoinsumo.UnidadMedida 
    FROM productoinsumo 
    INNER JOIN insumo ON productoinsumo.ProductoInsumoID = insumo.IDProductoInsumo 
    INNER JOIN tipoinsumo ON insumo.IDTipoInsumo = tipoinsumo.TipoInsumoID 
    WHERE productoinsumo.ProductoInsumoID = $productoID";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
    // Obtener los datos del producto
    $row = $result->fetch_assoc();
    $datosProducto = array(
        'codigo' => $row['ProductoInsumoID'],
        'envase' => $row['CantidadMedida'],
        'disponible' => $row['CantidadStock'],
        'vence' => $row['FechaVenci'],
        'unidadMedida' => $row['UnidadMedida'],
        
    );

    // Devolver los datos del producto en formato JSON
    echo json_encode($datosProducto);
    } else {
    // Producto no encontrado
    echo json_encode(array());
    }

    // Cierra la conexión a la base de datos
    $db->close();
?>
