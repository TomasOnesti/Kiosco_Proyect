<?php
// Incluir la conexión a la base de datos
include 'Conexion.php'; // Asegúrate de que esta ruta sea correcta, según la ubicación de este archivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del producto desde el formulario
    $id_producto = $_POST['id_producto'];

    // Consulta SQL para eliminar el producto
    $sql = "DELETE FROM productos WHERE ID = ?";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($sql)) {
        // Enlazar el parámetro (ID del producto)
        $stmt->bind_param("i", $id_producto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir de nuevo a la página de productos después de eliminar
            header("Location: ../index.php"); // Cambia la URL según tu estructura
            exit();
        } else {
            echo "Error al eliminar el producto.";
        }
    } else {
        echo "Error en la consulta SQL.";
    }

    // Cerrar la conexión
    $stmt->close();
}
?>
