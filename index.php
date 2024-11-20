<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/vendedor/boton_agregar.css">
    <link rel="stylesheet" href="CSS/vendedor/eliminar.css">
    <link rel="stylesheet" href="CSS/vendedor/modificar.css">
    <link rel="stylesheet" href="CSS/global.css">
    <link rel="stylesheet" href="CSS/productos.css">
    <link rel="stylesheet" href="CSS/perfil.css">
    <title>Kiosco_Primera_Parte</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');
    </style>
</head>
<body id="fondo">
<?php 
    session_start();
    if(isset($_SESSION['nombre'])){
        $nombre = $_SESSION['nombre'];
    } else {
        $nombre = "Invitado"; 
    }
    if(isset($_SESSION['rol'])){
        $rol = $_SESSION['rol'];
    } else {
        $rol = "cliente"; 
    }
?>
<header class="cont-header">
    <?php
       if($nombre != "Invitado"){
        echo "<div class=\"contenedor_h\">
                <a href=\"index.php\">
                    <img class=\"Logo\" src=\"./Img/Logo_kiosco.png\" alt=\"Logo\">
                </a>
                <div>
                    <button id=\"abrir\" class=\"Perfil\"></button>
                </div>
            </div>";
    }

        if($nombre == "Invitado"){
            echo "<div class=\"contenedor_h\">
                <a href=\"index.php\">
                    <img class=\"Logo\" src=\"./Img/Logo_kiosco.png\" alt=\"Logo\">
                </a>
                <button class=\"btn-login \"><a href=\"Paginas/Formulario_inicio.php\" class=\"letra\">Iniciar sesión</a></button>
                <button class=\"btn-login\"><a href=\"Paginas/Formulario_registro.php\" class=\"letra\">Registarse</a></button>
            </div>";
            
        }
        if($rol == "admi"){
            echo "<div class=\"Contener_opciones\">
                <Button class=\"botones_admin\"><a href=\"./Paginas/venta_admin.php\">$</a></Button>
                <Button class=\"botones_admin\"><a href=\"./Paginas/usuarios_admin.php\">usuarios</a></Button>
            </div>";
        } 
           
    ?>
        <nav id="nav" class="nav ">
            <ul class="nav-list">
                <img class="Logo margen_menu" src="./Img/Logo_kiosco.png" alt="Logo">
                <li><button class="btn-cerrar letra"><a class="info-menu" href="./Paginas/perfil.php">Mas informacion</a></button></li>
                <div class="session-button">
                    <?php if ($nombre == "Invitado") : ?>
                        
                    <?php else : ?>
                        <form action="" method="post">
                            <input class="btn-cerrar letra" type="submit" value="Cerrar Sesión" name="cerrar">
                        </form>
                        <?php 
                            if (!empty($_POST['cerrar'])){
                                session_destroy();
                                header("Location: index.php");
                                exit;
                            }
                        ?>
                    <?php endif; ?>
                </div>
                <button id="cerrar" class="btn-cerrar letra">Cerrar</button>
            </ul>
        </nav>
        
    <div class="copy">
        <nav>
            <li><a class="Boton" href="#" onclick="cargarProductosPorCategoria(1); return false;">Chocolates</a></li>
            <li><a class="Boton" href="#" onclick="cargarProductosPorCategoria(2); return false;">Alfajores</a></li>
            <li><a class="Boton" href="#" onclick="cargarProductosPorCategoria(3); return false;">Golosinas</a></li>
            <li><a class="Boton" href="#" onclick="cargarProductosPorCategoria(4); return false;">Bebidas</a></li>
            <li><a class="Boton" href="#" onclick="cargarProductosPorCategoria(5); return false;">Menu</a></li>
            <li><a class="Boton desaparecer" href="#" onclick="cargarProductosPorCategoria(6); return false;">Promos</a></li>
            <li><a class="Boton desaparecer" href="#" onclick="cargarProductosPorCategoria(7); return false;">Marcas</a></li>
        </nav>
    </div>
</header>
    <div class="container">
    <h1 class="invitado_t">Bienvenido, <?php echo $nombre; ?></h1>
    <h2 class="rol">Usted es un <?php echo $rol; ?></h2>
    <?php
        include 'php/Conexion.php';
        $sql = "SELECT ID, Nombre_producto, Descripcion, Precio, Stock_disponible, Imagen FROM productos";
        $result = $conexion->query($sql);

        // Verificamos si hay productos en la base de datos
        if ($result->num_rows > 0) {
            echo "<div class='product-container'>"; // Contenedor para los productos

            // Iteramos sobre cada producto y lo mostramos en una tarjeta
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>
                        <a href='producto_detalle.php?id=" . $row['ID'] . "' class='product-link'>
                            <div class='product-image-text'>
                                <img src='" . $row['Imagen'] . "' alt='Imagen del producto' class='product-image'>
                                <div class='product-info'>
                                    <h2 class=\"nombre_producto\">" . $row['Nombre_producto'] . "</h2>
                                    <div class='price'>
                                        <span class='current-price'>$" . number_format($row['Precio'], 2) . "</span>
                                    </div>
                                    <div class='action-text'>Llega hoy</div>
                                </div>
                            </div>
                        </a>";

                // Opciones de eliminación y modificación solo para el rol de "vendedor"
                if ($rol === "vendedor") {
                    echo "<div class='eliminar'>
                            <form action='php/eliminar_producto.php' method='POST' class='delete-form' onsubmit='return confirmarEliminacion()'>
                                <input type='hidden' name='id_producto' value='" . $row['ID'] . "'>
                                <button type='submit' class='delete-button'> - </button>
                            </form>
                          </div>
                          <div class='modificar'>
                                <a href='Paginas/modificar.php?id=" . $row['ID'] . "&nombre=" . urlencode($row['Nombre_producto']) 
                                . "&precio=" . urlencode($row['Precio']) . "&descripcion=" . urlencode($row['Descripcion']) . "&stock=" . urlencode($row['Stock_disponible']) . "'>
                                <img src='Img/modificar.png' alt='Modificar producto' class='modificar-imagen'>
                            </a>
                          </div>";
                }
                echo "</div>"; // Cierra el div de cada tarjeta de producto
            }
            echo "</div>"; // Cierra el contenedor de productos
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
    ?>
</div> <!-- Cierra el contenedor principal -->


    <?php 
        if($rol == "vendedor"){
            echo "<div class='agregar'>
                    <a href='Paginas/agregar_producto.php'>+</a>
                  </div>";
        }
    ?>
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
<script src="JS/cargarProductos.js"></script>
<script src="JS/categoria.js"></script>
<script>
    const nav = document.querySelector("#nav");
const abrir = document.querySelector("#abrir");
const cerrar = document.querySelector("#cerrar");

abrir.addEventListener("click", () => {
    nav.classList.add("visible");
    document.getElementByid("cerrar").style.display = "block"
    }
)

cerrar.addEventListener("click",() =>{
    nav.classList.remove("visible");
}
)
</script>
<script src="https://kit.fontawesome.com/45f45403cb.js" crossorigin="anonymous"></script>
<script>
    function confirmarEliminacion() {
        return confirm('¿Seguro que quieres eliminar este producto?');
    }
</script>
</body>
</html>