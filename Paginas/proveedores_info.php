<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="../CSS/adm/proveedores_info.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');
    </style>
</head>
<body>
<header class="cont-header">
<div class="contenedor_h">
    <img class="Logo" src="../Img/Logo_kiosco.png" alt="Logo">
</div>

    <div class="copy">
        <nav>
            <li><button class="Boton" onclick="irACategoria('Chocolates')">Chocolates</button></li>
            <li><button class="Boton" onclick="irACategoria('Alfajores')">Alfajores</button></li>
            <li><button class="Boton" onclick="irACategoria('Golosinas')">Golosinas</button></li>
            <li><button class="Boton" onclick="irACategoria('Bebidas')">Bebidas</button></li>
            <li><button class="Boton" onclick="irACategoria('Menu')">Menu</button></li>
            <li><button class="Boton" onclick="irACategoria('Promos')">Promos</button></li>
            <li><button class="Boton" onclick="irACategoria('Marcas')">Marcas</button></li>
        </nav>
    </div>
</header>

<main>
<h2 id="titulo_prov">Nuestros proveedores:</h2>
    <article class="mover_cont">
        
        <div class="contenedor_proveedor">
            <img class="img_prov" src="" alt="">
            <div class="">
                <h2 class="nombre_prov">hola</h2>
            </div>
            <div class="info_prov">
                <p class="direccion">buenas</p>
                <p class="telefono">tardes</p>
                <p class="mail">profesor</p>
            </div>
        </div>
    </article>
</main>

<footer>
    <div class="cont-footer">
        <div class="icon">
            <img src="IMG/Logo_kiosco.png" alt="">
        </div>
        <div class="datos">
            <p>Terminos y condiciones</p>
            <p>politicas de privacidad</p>
            <p>contacto</p>
        </div>
        <div class="redes">
            <p>Redes</p><br>
            <div class="footer-contact">
                <p>Dudas?</p>
                <form>
                    <input type="email" placeholder="Dudas">
                    <button type="submit">ENVIAR</button>
                </form>
                <p>Tel: 1158253782 | b3140269@gmail.com</p>
                <p>Parana 1651 Cerrito, Buenos Aires</p>
            </div>
            <div class="cont-redes">
                <a href="https://www.instagram.com/jheysmar_m_m/">
                    <i class="fa-brands fa-square-instagram"></i>
                </a>
                <i class="fa-brands fa-square-facebook"></i>
                <i class="fa-brands fa-square-x-twitter"></i>
            </div>
        </div>
        <div class="copy">
            <p>Hecho por Jheysmar Mendieta, Tomas Onesti, Demian Barreto y Gadiel Siles / Kiosco</p>
        </div>
    </div>
</footer>
</body>
</html>