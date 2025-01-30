<?php
//Este post guarda la ruta de la imagen en la base de datos

// Conexión a la base de datos
require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Obtener datos del formulario
$nombre    = htmlspecialchars(trim($_POST['nombre']));
$categoria   = htmlspecialchars(trim($_POST['categoria']));
$precio  = floatval($_POST['precio']); // Convertir a float
$descuento    = floatval($_POST['descuento']); // Convertir a float
$rating  = floatval($_POST['rating']); // Convertir a float
$stock   = intval($_POST['stock']); // Convertir a entero
$marca   = htmlspecialchars(trim($_POST['marca']));

// Manejo de la imagen
$miniatura = $_FILES["miniatura"];
$nombreMiniatura = $miniatura["name"];
$tipoImagen = strtolower(pathinfo($nombreMiniatura, PATHINFO_EXTENSION));
$directorio = "../../img/productos/";

// Verificar tipo de imagen
if (in_array($tipoImagen, ["jpg", "jpeg", "png"])) {
    // Generar nombre de archivo único
    $idRegistro = uniqid(); // Usar uniqid para evitar conflictos
    $ruta = $directorio . $idRegistro . "." . $tipoImagen;

    // Mover la imagen al directorio
    if (move_uploaded_file($miniatura["tmp_name"], $ruta)) {
        // Decodificar entidades HTML
        $nombre   = html_entity_decode($nombre);
        $categoria   = html_entity_decode($categoria);
        $marca     = html_entity_decode($marca);

        // Preparar y ejecutar la consulta
        $sql = "INSERT INTO productos (nombre, categoria, precio, descuento, rating, stock, marca, miniatura) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
        }

        // Bind params con el tipo correcto
        $stmt->bind_param("ssdddiss", $nombre, $categoria, $precio, $descuento, $rating, $stock, $marca, $ruta);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Nuevo producto agregado exitosamente."]);
        } else {
            error_log("Error al agregar producto: " . $stmt->error);
            echo json_encode(["success" => false, "message" => "Ocurrió un error al agregar el producto."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Error al subir la imagen."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Tipo de imagen no permitido."]);
}

// Cerrar conexión
$stmt->close();
$conn->close();

?>
