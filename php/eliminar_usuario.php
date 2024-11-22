<?php
include 'Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario =  $_POST['id_usuario'];

    $sql = "DELETE FROM usuarios WHERE ID = ?";

    if ($stmt = $conexion->prepare($sql)) {
        
        $stmt->bind_param("i", $id_usuario);

        
        if ($stmt->execute()) {
            
            header("Location: ../Paginas/usuarios_admin.php"); 
            exit();
        } else {
            echo "Error al eliminar el Usuario.";
        }
    } else {
        echo "Error en la consulta SQL.";
    }

    $stmt->close();
}
?>