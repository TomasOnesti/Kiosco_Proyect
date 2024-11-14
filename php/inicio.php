<?php
session_start();
include "Conexion.php";

if(!empty($_POST['inicio'])){
    $mail = $_POST['correo'];
    $contra = $_POST['contrasenia'];
    $query = "SELECT ID, Nombre, Apellido, Email, Rol FROM usuarios WHERE Email = '$mail' AND Contraseña = '$contra'";
    $env = $conexion->query($query);

    if($r = $env->fetch_array()){
        $_SESSION['usuario_id'] = $r['ID'];
        $_SESSION['nombre'] = $r['Nombre'];
        $_SESSION['apellido'] = $r['Apellido'];
        $_SESSION['mail'] = $r['Email'];
        $_SESSION['rol'] = $r['Rol'];
        header("Location: ../index.php");
        exit();
    }
    else{
        echo "Error, los datos son incorrectos";
    }
}
?>
