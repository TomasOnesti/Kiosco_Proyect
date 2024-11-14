<?php
include "../php/Conexion.php";

if (!empty($_POST['modificar_p'])) {
    // Verifica que se haya enviado el ID del producto
    if (!isset($_POST['id']) || !isset($_POST['producto']) || !isset($_POST['descripcion']) || !isset($_POST['precio']) || !isset($_POST['stock_disponible']) || !isset($_POST['Categoria']) || !isset($_POST['Proveedores'])) {
        echo "Por favor, rellene todos los campos";
        return;
    }

    $id = $_POST['id']; // Asegúrate de que el ID del producto se esté enviando
    $producto = $_POST['producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock_disponible = $_POST['stock_disponible'];
    $Categoria = $_POST['Categoria'];
    $proveedor = $_POST['Proveedores'];
    
    // Inicializa la ruta de la imagen
    $ruta_imagen = ''; // Cambia a vacío por si no se sube una nueva imagen

    // Verifica si se seleccionó una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        // Guarda la nueva imagen
        $imagen = $_FILES['imagen'];
        $nombre_imagen_final = $_POST['nombre_imagen'] . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $direccion_imagen = './Img/' . $nombre_imagen_final;

        // Mueve la imagen al directorio
        move_uploaded_file($imagen['tmp_name'], $direccion_imagen);
        
        // Asigna la ruta de la nueva imagen
        $ruta_imagen = $direccion_imagen;
    } else {
        // Si no se subió una nueva imagen, consulta la base de datos para obtener la ruta actual
        $query = "SELECT imagen FROM productos WHERE ID = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $producto_actual = $result->fetch_assoc();
            $ruta_imagen = $producto_actual['imagen']; // Mantiene la imagen actual
        }
    }

    // Prepara la consulta de actualización
    $stmt = $conexion->prepare("UPDATE productos SET 
                Nombre_producto = ?, 
                Descripcion = ?, 
                Precio = ?, 
                Stock_disponible = ?, 
                Categoria_id = ?, 
                proveedores_id = ?, 
                imagen = ? 
                WHERE ID = ?");
    
    $stmt->bind_param("ssdsissi", $producto, $descripcion, $precio, $stock_disponible, $Categoria, $proveedor, $ruta_imagen, $id);
    
    // Ejecuta la consulta
    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al modificar el producto: " . $stmt->error;
    }
    
    // Cierra la conexión
    mysqli_close($conexion);
}
?>
