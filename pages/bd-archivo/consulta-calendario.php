<?php

  // Conexión a la base de datos
    $dsn = "mysql:host=localhost;dbname=todoagro";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    // Consulta para obtener eventos
    $query = "SELECT c.id_orden, c.CamaraGerminacionID, prod.NombreHortaliza, c.fecha, c.hora, c.color, u.nombre,
    pf.CantidadBandejas, pf.plantasreales, pf.CantidadSemilla, s.BandejasUtilizadas FROM camaragerminacion c
    INNER JOIN siembra s ON s.IDPedido = c.id_orden
    INNER JOIN pedido p ON p.PedidoID = c.id_orden
    INNER JOIN hortalizas prod ON p.ProductoPlantulasID = prod.HortalizaID
    INNER JOIN planificacionpedidos pf ON pf.OrdenID = p.PedidoID 
    INNER JOIN cliente u ON u.id_cliente = p.ClienteID 
    WHERE p.Estadopro = 'EnCamara'";
    $statement = $conn->prepare($query);
    $statement->execute();
    $events = [];

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $event = [
            'id' => $row['id_orden'],
            'Camara' => $row['CamaraGerminacionID'],
            'title' => 'Siembra de ' . $row['NombreHortaliza'] , // Puedes personalizar el título según tus necesidades
            'start' => strtotime($row['fecha'] . ' ' . $row['hora']) * 1000,
            'color' => $row['color'],
            'cliente' => $row['nombre'],
            'producto' => $row['NombreHortaliza'],
            'bandejas' => $row['CantidadBandejas'],
            'plantas' => $row['plantasreales'],
            'semillas' => $row['CantidadSemilla'],
            'sembradas' => $row['BandejasUtilizadas'],
            // Puedes agregar más propiedades aquí según tus datos de la base de datos
        ];
        $events[] = $event;
    }

?>