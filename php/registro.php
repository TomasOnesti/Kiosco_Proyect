<?php
session_start();
include "Conexion.php";

if (!empty($_POST['registrar'])) {
    if (!isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['correo']) || !isset($_POST['contrasenia'])) {
        echo "Por favor, rellene todos los campos";
        return;
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $mail = $_POST['correo'];
    $contra = $_POST['contrasenia'];

    // Validar que el correo termine con '@gmail.com'
    if (substr($mail, -10) !== '@gmail.com') {
        echo "El correo debe terminar con '@gmail.com'.";
        return;
    }

    // Verificar si el correo ya está registrado
    $stmt_check = $conexion->prepare("SELECT ID FROM usuarios WHERE Email = ?");
    $stmt_check->bind_param("s", $mail);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "Este correo ya está en uso. Por favor, intente con otro.";
    } else {
        // Si el correo no está en uso, se inserta el nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios(Nombre, Apellido, Email, Contraseña, Rol) VALUES (?, ?, ?, ?, '1')");
        $stmt->bind_param("ssss", $nombre, $apellido, $mail, $contra);

        if ($stmt->execute()) {
            $query2 = "SELECT ID, Nombre, Apellido, Email, Rol FROM usuarios WHERE Email = '$mail'";
            $env2 = $conexion->query($query2);
            if ($r = $env2->fetch_array()) {
                $_SESSION['usuario_id'] = $r['ID'];
                $_SESSION['nombre'] = $r['Nombre'];
                $_SESSION['apellido'] = $r['Apellido'];
                $_SESSION['mail'] = $r['Email'];
                $_SESSION['rol'] = $r['Rol'];
                header("Location: ../index.php");
                exit();
            } else {
                echo "Error, los datos no pudieron ser cargados";
            }
        } else {
            echo "Error al insertar datos: " . $conexion->error;
        }
    }
}
?>
