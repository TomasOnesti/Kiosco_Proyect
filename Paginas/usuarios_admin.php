<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/perfil.css">
</head>
<body>
<?php
 include '../php/Conexion.php';


 session_start();
    if(isset($_SESSION['nombre'])){
        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];

    } else {
        $nombre = "Invitado"; 
    }
    if(isset($_SESSION['rol'])){
        $rol = $_SESSION['rol'];
    } else {
        $rol = "cliente"; 
    }
?>

    <main>
        <article>
            <div class="lista_nombre">
                <li><p class="estilo"><?php echo $nombre;?></p></li>
                <li><p class="estilo"><?php echo $apellido;?></p></li>
            </div>
        </article>
    </main>
</body>
</html>