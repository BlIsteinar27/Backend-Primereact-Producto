<?php

require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');

// Obtener el ID del autor desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los datos JSON de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar los datos
if (isset($data->nombre) && isset($data->categoria) && isset($data->precio) && isset($data->descuento) && isset($data->rating) && isset($data->stock) && isset($data->marca)) {
    $nombre = $data->nombre;
    $categoria = $data->categoria;
    $precio = $data->precio;
    $descuento = $data->descuento;
    $rating = $data->rating;
    $stock = $data->stock;
    $marca = $data->marca;

    $miniatura = $_FILES["miniatura"];
    $nombreMiniatura = $miniatura["name"];
    $tipoImagen = strtolower(pathinfo($nombreMiniatura, PATHINFO_EXTENSION));
    $directorio = "../../img/productos/";

    if (is_file($miniatura)) {
        if ($tipoImagen == "jpg" or $tipoImagen == "jpeg" or $tipoImagen == "png") {

            try {
                unlink($miniatura);
            } catch (\Throwable $th) {
                //throw $th;
            }

            $ruta = $directorio . $id . "." . $tipoImagen;

            if (move_uploaded_file($miniatura, $ruta)) {

                $editar = $conexion->query("UPDATE productos SET miniatura = '$ruta' WHERE id = $id;");
                if ($editar==1) {
                    # code...
                } else {
                    # code...
                }
            }
        } else {
            # code...
        }
    } else {
        # code...
    }

    // Preparar la consulta SQL para actualizar el autor
    $sql = "UPDATE productos SET nombre = ?, categoria = ?, precio = ?, descuento = ?, rating = ?, stock = ? ,marca = ?, miniatura = ? WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conn->error]));
    }

    // Asegúrate de que el número de parámetros coincida con los placeholders
    $stmt->bind_param("issssi", $nombre, $categoria, $precio, $descuento, $rating, $stock, $marca, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Producto actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Ocurrió un error al actualizar el producto: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos."]);
}

$conn->close();
