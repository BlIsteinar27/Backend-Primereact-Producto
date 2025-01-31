<?php
//Este post guarda la ruta de la imagen en la base de datos

// Conexión a la base de datos
require_once('../../util/manejoCore.php');
require_once('../../config/conexion.php');



$id = $_POST["id"];
$nombre= $_POST["nombre"];
$categoria = $_POST["categoria"];
$precio = $_POST["precio"];
$descuento = $_POST["descuento"];
$rating= $_POST["rating"];
$stock = $_POST["stock"];
$marca = $_POST["marca"];


// Manejo de la imagen
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


// Cerrar conexión
$stmt->close();
$conn->close();

?>
