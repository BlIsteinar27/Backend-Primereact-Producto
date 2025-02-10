<?php

require_once("../../util/manejoCore.php");
require_once("../../config/conexion.php");

header('Content-Type: application/json');



$id = $_POST['id'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$rating = $_POST['rating'];
$stock = $_POST['stock'];
$marca = $_POST['marca'];

$directorio = "../../img/";

// Verificar si se ha subido una nueva imagen
if (isset($_FILES["miniatura"]) && $_FILES["miniatura"]["error"] == 0) {
    $imagen = $_FILES["miniatura"]["tmp_name"];
    $nombreImagen = $_FILES["miniatura"]["name"];
    $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));

    // Validar el tipo de imagen
    if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
        // Eliminar la imagen anterior si existe
        $imagenAnterior = glob($directorio . $id . ".{jpg,jpeg,png}", GLOB_BRACE);
        if (!empty($imagenAnterior)) {
            foreach ($imagenAnterior as $archivo) {
                unlink($archivo);
            }
        }

        // Mover la nueva imagen al directorio
        $ruta = $directorio . $id . "." . $tipoImagen;
        if (move_uploaded_file($imagen, $ruta)) {
            // Actualizar la base de datos con la nueva ruta de la imagen
            $editar = $conexion->query("UPDATE productos SET miniatura='$ruta' WHERE id=$id");
        } else {
            echo json_encode(["success" => false, "message" => "Error al subir la imagen."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "Formato de imagen no válido. Solo se permiten JPG, JPEG y PNG."]);
        exit;
    }
}

// Actualizar los demás campos del producto
$query = "UPDATE productos SET nombre='$nombre', categoria='$categoria', precio='$precio', descuento='$descuento', rating='$rating', stock='$stock', marca='$marca' WHERE id=$id";
if ($conexion->query($query)) {
    echo json_encode(["success" => true, "message" => "Producto actualizado exitosamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar el producto."]);
}
