<?php
// Incluir la conexión a la base de datos
require_once('../../config/conexion.php');

// Configurar los encabezados CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar la solicitud OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verificar si se recibió un ID válido
if (!isset($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    echo json_encode(array("message" => "ID del producto no proporcionado."));
    exit();
}

// Obtener los datos del formulario
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$rating = $_POST['rating'];
$stock = $_POST['stock'];
$marca = $_POST['marca'];

// Preparar la consulta SQL para actualizar el producto
$sql = "UPDATE productos SET 
        nombre = ?, 
        categoria = ?, 
        precio = ?, 
        descuento = ?, 
        rating = ?, 
        stock = ?, 
        marca = ? 
        WHERE id = ?";

// Preparar la sentencia
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(array("message" => "Error al preparar la consulta."));
    exit();
}

// Vincular los parámetros
$stmt->bind_param(
    "ssddddsi", 
    $nombre, 
    $categoria, 
    $precio, 
    $descuento, 
    $rating, 
    $stock, 
    $marca, 
    $id
);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Manejar la imagen si se proporcionó
    if (!empty($_FILES['miniatura']['name'])) {
        $target_dir = "../../img/";
        $target_file = $target_dir . basename($_FILES["miniatura"]["name"]);

        // Mover la imagen al directorio de imágenes
        if (move_uploaded_file($_FILES["miniatura"]["tmp_name"], $target_file)) {
            // Actualizar la ruta de la imagen en la base de datos
            $sql_img = "UPDATE productos SET miniatura = ? WHERE id = ?";
            $stmt_img = $conn->prepare($sql_img);
            $stmt_img->bind_param("si", $target_file, $id);
            $stmt_img->execute();
            $stmt_img->close();
        }
    }

    http_response_code(200);
    echo json_encode(array("message" => "Producto actualizado correctamente."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Error al actualizar el producto."));
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>