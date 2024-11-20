<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/perfil.css">
</head>
<?php
 session_start();
 include '../php/Conexion.php';
 $user = $_SESSION['usuario_id'];
 $usuario_consulta = "SELECT `ID`, `Nombre`, `Apellido`, `Email`, `Contraseña`, `Rol` FROM `usuarios` WHERE ID =".$user."";
 $result = $conexion->query( $usuario_consulta);
 while($data = $result->fetch_assoc()){
    $id = $data['ID'];
    $nombre = $data['Nombre'];
    $apellido = $data['Apellido'];
    $contrasenia = $data['Contraseña'];
    $correo = $data['Email'];
    $rol = $data['Rol'];
 }
?>
<body>
    <header>
    <div class="contenedor_h">
                <a href="index.php">
                    <img class="Logo" src="../Img/Logo_kiosco.png" alt="Logo">
                </a>
            </div>
    </header>
    <main>
        
        <h1 class="nombre_perfil">Perfil de usuario: </h1>
        <div class="lista_nombre">
            <li><p class="estilo"><?php echo $nombre;?></p></li>
            <li><p class="estilo"><?php echo $apellido;?></p></li>
            <li><p class="estilo"><?php echo $correo;?></p></li>
            <li><p class="estilo"><?php echo $rol;?></p></li>
            <li><p class="estilo"><?php echo $contrasenia;?></p></li>
        </div>

    </main>

</body>
</html>