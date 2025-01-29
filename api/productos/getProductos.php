<?php 

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Consulta para obtener productos
$sql = "SELECT * FROM `productos`;";

// Inicializar array para productos
$productos = [];

// Verificar la conexión
if ($conn) {
    // Ejecutar la consulta
    if ($result = $conn->query($sql)) {
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
        // Liberar resultados
        $result->free();
    } else {
        echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
}

// Devolver resultados como JSON
echo json_encode($productos, JSON_UNESCAPED_UNICODE);

// Cerrar conexión
$conn->close();

?>