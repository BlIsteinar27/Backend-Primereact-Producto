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

// Obtener el ID desde la URL (query parameter)
$id = isset($_GET['id']) ? $_GET['id'] : null; // <--- Clave: Leer el ID desde la URL

if (!$id) {
    http_response_code(400);
    echo json_encode(array("message" => "ID del producto no proporcionado en la URL."));
    exit();
}

// Parsear datos del formulario (multipart/form-data)
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$descuento = isset($_POST['descuento']) ? $_POST['descuento'] : null;
$rating = isset($_POST['rating']) ? $_POST['rating'] : null;
$stock = isset($_POST['stock']) ? $_POST['stock'] : null;
$marca = isset($_POST['marca']) ? $_POST['marca'] : null;

// Validar datos requeridos
if (!$nombre || !$categoria || !$precio || !$descuento || !$rating || !$stock || !$marca) {
    http_response_code(400);
    echo json_encode(array("message" => "Faltan campos obligatorios."));
    exit();
}

// Actualizar el producto en la base de datos
$sql = "UPDATE productos SET 
        nombre = ?, 
        categoria = ?, 
        precio = ?, 
        descuento = ?, 
        rating = ?, 
        stock = ?, 
        marca = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(array("message" => "Error al preparar la consulta."));
    exit();
}

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

if ($stmt->execute()) {
    // Manejar la imagen si se envió
    if (!empty($_FILES['miniatura']['name'])) {
        $target_dir = "../../img/";
        $target_file = $target_dir . basename($_FILES["miniatura"]["name"]);
        
        if (move_uploaded_file($_FILES["miniatura"]["tmp_name"], $target_file)) {
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

$stmt->close();
$conn->close();
?>