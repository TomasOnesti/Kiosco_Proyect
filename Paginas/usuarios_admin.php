<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/global.css">
   
    <link rel="stylesheet" href="../CSS/adm/control_usuarios.css">
</head>
<body>
    <header>
    <?php
 include '../php/Conexion.php';
 echo"<div class=\"contenedor_h\">
 <img class=\"Logo\" src=\"../Img/Logo_kiosco.png\" alt=\"Logo\">
</div>";
?>

    </header>

    <main>
    <h2 class="usuarios_titulo">Usuarios</h2>
<?php
    $sql = "SELECT `ID`, `Nombre`, `Apellido`, `Email`, `Contraseña`, `Rol` FROM `usuarios` WHERE 1";
    $result = $conexion->query($sql);
    if($result->num_rows > 0){
        while($filas = $result->fetch_assoc()) {
         echo"<article>
         
            <div class=\"lista_nombre\">
                    <li><p class=\"estilo\">".$filas['ID']."</p></li>
                    <li><p class=\"estilo\">".$filas['Nombre']."</p></li>
                    <li><p class=\"estilo\">".$filas['Apellido']."</p></li>
                    <li><p class=\"estilo\">".$filas['Email']."</p></li>
                    <li><p class=\"estilo\">".$filas['Rol']."</p></li>
            <form action='../php/eliminar_usuario.php' method='POST' onsubmit='return confirmarEliminacion()'>
                    <input type='hidden' name='id_usuario' value='" . $filas['ID'] . "'>           
                    <button type=\"submit\" class=\"estilo_de_btn_eliminar\">Eliminar</button>
            </form>
                 
                </div>
            </article>";
            }
        }
?>
    </main>

    <script>
    function confirmarEliminacion() {
        return confirm('¿Seguro que quieres eliminar a este Usuario?');
    }
</script>
</body>
</html>