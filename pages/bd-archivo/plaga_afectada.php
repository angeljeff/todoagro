<?php
    $conn = new mysqli("localhost", "root", "", "todoagro");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    if (
        isset($_POST['orden']) &&
        isset($_POST['fe_plaga']) &&
        isset($_POST['nombEnfe']) &&
        isset($_POST['sintoma']) &&
        isset($_POST['plagas_enfe']) &&
        isset($_POST['afectada']) &&
        isset($_POST['fecha_actividad']) &&
        isset($_POST['actividad']) &&
        isset($_POST['actTrans']) &&
        isset($_POST['dosis']) &&
        isset($_POST['obs']) 
    ) {
        $orden = $_POST['orden'];
        $fecha_plaga = $_POST['fe_plaga'];
        $nombEnfe = $_POST['nombEnfe'];
        $sintoma = $_POST['sintoma'];
        $plagas_enfe = $_POST['plagas_enfe'];
        $afectada = $_POST['afectada'];

        $fecha_actividad = $_POST['fecha_actividad'];
        $actividad = $_POST['actividad'];
        $actTrans = $_POST['actTrans'];
        $dosis = $_POST['dosis'];
        $obs = $_POST['obs'];

        // Escapar los valores para evitar inyecciones SQL (opcional, pero recomendado)
        $orden = $conn->real_escape_string($orden);
        $fecha_plaga = $conn->real_escape_string($fecha_plaga);
        $nombEnfe = $conn->real_escape_string($nombEnfe);
        $sintoma = $conn->real_escape_string($sintoma);
        $plagas_enfe = $conn->real_escape_string($plagas_enfe);
        $afectada = $conn->real_escape_string($afectada);

        $fecha_actividad = $conn->real_escape_string($fecha_actividad);
        $actividad = $conn->real_escape_string($actividad);
        $actTrans = $conn->real_escape_string($actTrans);
        $dosis = $conn->real_escape_string($dosis);
        $obs = $conn->real_escape_string($obs);

        // Consultar la cantidad disponible en productoinsumo
        $sqlConsulta = "SELECT CantidadMedida, CantidadStock, MedidaConteo 
        FROM productoinsumo 
        WHERE ProductoInsumoID = '$actTrans'";
        $resultConsulta = $conn->query($sqlConsulta);

        if ($resultConsulta->num_rows > 0) {
            $row = $resultConsulta->fetch_assoc();
            $cantidadMedida = $row['CantidadMedida'];
            $cantidadStock = $row['CantidadStock'];  
            $valorInicial = $row['MedidaConteo'];
            
            // Verificar el valor de $dosis y actualizar la cantidad correspondiente en productoinsumo
            if ($dosis != 0) {
                // Verificar si la dosis es mayor que la cantidad disponible en el envase
                if ($dosis > $cantidadMedida) {
        
                    // Calcular la cantidad que quedará en el envase después de usarlo
                    $cantidadMedida = $valorInicial - ($dosis - $cantidadMedida);
                    $cantidadStock -= 1;
        
                    // Si $cantidadStock llega a 0, establecer $cantidadMedida a 0
                    if ($cantidadStock == 0) {
                        $cantidadMedida = 0;
                    }
                } else {
                    // Restar la dosis de CantidadMedida
                    $cantidadMedida -= $dosis;
                    // Si CantidadMedida llega a cero o menos, disminuir CantidadStock en 1 y restablecer CantidadMedida a 500
                    if ($cantidadMedida <= 0) {
                        $cantidadStock -= 1;
                        $cantidadMedida = ($cantidadStock == 0) ? 0 : $valorInicial;   
                    }
                }
        
                // Actualizar la tabla productoinsumo
                $sqlUpdate = "UPDATE productoinsumo SET CantidadMedida = $cantidadMedida, 
                    CantidadStock = $cantidadStock 
                    WHERE ProductoInsumoID = '$actTrans'";
                if ($conn->query($sqlUpdate) !== TRUE) {
                    $mensaje = "Error al actualizar la información en productoinsumo: " . $conn->error;
                }
            }
        
        // Luego de actualizar productoinsumo, insertar los datos en la tabla 
        // Crear la consulta SQL para insertar los valores en la base de datos
        $sql = "INSERT INTO plagaenfermedadtratadas (OrdenID, Fecha_plaga, Nombre_enfermedad,
        Sintomas, Tipo_Enfermedad, Band_Afectada, Fecha_actividad, actividad, productoinsumo, dosis, observaciones ) 
        VALUES ('$orden', '$fecha_plaga', '$nombEnfe', '$sintoma', 
        '$plagas_enfe', '$afectada', '$fecha_actividad', '$actividad', '$actTrans', '$dosis'
        ,'$obs')";
        
            // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo "Registro insertado correctamente.";
        } else {
            echo "Error al insertar el registro: " . $conn->error;
        }
    } else {
        echo "Faltan campos en el formulario.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();  
header("Location: ../UI/Plagas-plantulas-tratadas.php");
?>
