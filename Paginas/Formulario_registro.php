<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario</title>
    <link rel="stylesheet" href="../CSS/Formulario.css">
</head>
<body id="fondo">
    <header>
        <h1>Bienvenido, Porfavor registrese</h1>
    </header>
    <main>
        <form action="" method="post">
        <article>
            <div class="Registro">
                <h4>Formulario de Registro</h4>
                <input class="control" type="text" name="nombre" id="nombres" placeholder="Ingrese su Nombre" required>
                <input class="control" type="text" name="apellido" id="apellidos" placeholder="Ingrese su Apellido" required>
                <input class="control" type="email" name="correo" id="correos" placeholder="Ingrese su Correo Electronico" required>
                <input class="control" type="password" name="contrasenia" id="contraseñas" placeholder="Ingrese su Contraseña" required>
                <p>Estoy de acuerdo con <a href="#">Terminos y Condiciones</a></p>
                <input class="boton" type="submit" value="Registrar" name="registrar">
                <p><a href="../Paginas/Formulario_inicio.php">¿Posees una cuenta?</a></p>
                <?php include "../php/registro.php"; ?>
            </div>
        </article>
        </form>
    </main>
</body>
</html>