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

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si se recibió un ID válido
if (!isset($data['id']) || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(array("message" => "ID del producto no proporcionado."));
    exit();
}

// Obtener los datos del producto
$id = $data['id'];
$nombre = $data['nombre'];
$categoria = $data['categoria'];
$precio = $data['precio'];
$descuento = $data['descuento'];
$rating = $data['rating'];
$stock = $data['stock'];
$marca = $data['marca'];

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