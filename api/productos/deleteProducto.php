<?php
require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Obtener la ruta de la imagen asociada al producto
    $sqlGetImagen = "SELECT miniatura FROM productos WHERE id = ?";
    $stmtGetImagen = $conn->prepare($sqlGetImagen);
    $stmtGetImagen->bind_param("i", $id);
    $stmtGetImagen->execute();
    $stmtGetImagen->store_result();
    $stmtGetImagen->bind_result($rutaImagen);
    $stmtGetImagen->fetch();
    $stmtGetImagen->close();

    // Eliminar la imagen del sistema de archivos si existe
    if ($rutaImagen && file_exists($rutaImagen)) {
        unlink($rutaImagen); // Eliminar la imagen
    }

    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
    }

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto eliminado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Ocurrió un error al eliminar el Producto: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID del producto no válido."]);
}

$conn->close();
?>