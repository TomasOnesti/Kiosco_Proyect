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
        <h1>Bienvenido</h1>
    </header>
    <main>
        <article>
            <form action="" method="post">
                <div class="Registro">
                    <h4>Inicio de sesion </h4>
                    <input class="control" type="email" name="correo" id="correos" placeholder="Ingrese su Correo Electronico">
                    <input class="control" type="password" name="contrasenia" id="contrasenias" placeholder="Ingrese su Contraseña">
                    <p>Estoy de acuerdo con <a href="#">Terminos y Condiciones</a></p>
                    <input class="boton" type="submit" value="Iniciar Sesion" name="inicio">
                    <p><a href="../Paginas/Formulario_registro.php">Si no tienes una cuenta</a></p>
                    <?php include "../php/inicio.php"; ?>
                </div>
            </form>
        </article>
    </main>
</body>
</html>