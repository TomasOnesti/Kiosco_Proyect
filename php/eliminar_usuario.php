<?php
include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario =  $_POST['id_usuario'];

    $sql = "DELETE FROM usuarios WHERE ID = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Enlazar el parámetro (ID del producto)
        $stmt->bind_param("i", $id_usuario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir de nuevo a la página de productos después de eliminar
            header("Location: ../Paginas/usuarios_admin.php"); // Cambia la URL según tu estructura
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