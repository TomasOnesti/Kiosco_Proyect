<?php
// Incluir la conexión a la base de datos
include 'php/Conexion.php';

// Iniciar la sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Variable rol 
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

// Verificar si se envió el formulario para agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'], $_POST['cantidad'])) {
    $producto_id = (int) $_POST['producto_id'];
    $cantidad = (int) $_POST['cantidad'];

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            // Si ya está, solo actualizamos la cantidad
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }
    // Si no está en el carrito, lo agregamos
    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'producto_id' => $producto_id,
            'cantidad' => $cantidad
        ];
    }

    // Redirigir al carrito
    header('Location: Carrito.php');
    exit;
}

// Obtener el ID del producto desde la URL
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Consulta para obtener los detalles del producto
    $sql = "SELECT ID, Nombre_producto, Descripcion, Precio, Stock_disponible, Imagen FROM productos WHERE ID = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no especificado.";
    exit;
}

// Cerrar la conexión
$conexion->close();
?>
<?php
// Verificar si se ha enviado el formulario de compra (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'], $_POST['cantidad'])) {
    $producto_id = (int) $_POST['producto_id'];
    $cantidad = (int) $_POST['cantidad'];

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            // Si ya está, solo actualizamos la cantidad
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    // Si no está en el carrito, lo agregamos
    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'producto_id' => $producto_id,
            'cantidad' => $cantidad
        ];
    }

    // Redirigir al carrito
    header('Location: Carrito.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" href="CSS/productos_detalles.css">
    <link rel="stylesheet" href="CSS/global.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');
    </style>
</head>
<body id="fondo">
    <header class="cont-header">
    <?php
        if($rol != "admi"){
            echo "<div class=\"contenedor_h\">
                <a href=\"index.php\">
                    <img class=\"Logo\" src=\"./Img/Logo_kiosco.png\" alt=\"Logo\">
                </a>
                <div class=\"Perfil\">
                    <a href=\"#\"></a>
                </div>
            </div>";
        }
        if($rol == "admi"){
            echo "<div class=\"contenedor_h\">
                <a href=\"index.php\">
                    <img class=\"Logo\" src=\"./Img/Logo_kiosco.png\" alt=\"Logo\">
                </a>
                <div class=\"Perfil\">
                    <a href=\"#\"></a>
                </div>
            </div>";
            echo "<div class=\"Contener_opciones\">
                <Button class=\"botones_admin\"><a href=\"./Paginas/venta_admin.php\">$</a></Button>
                
            </div>";
        }    
    ?>
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
    <main>
        <div class="product-detail">
            <div class="product-image">
                <img src="<?php echo $producto['Imagen']; ?>" alt="<?php echo $producto['Nombre_producto']; ?>">
            </div>
            <div class="product-info">
                <h2 class="product-name"><?php echo $producto['Nombre_producto']; ?></h2>
                <div class="price-info">
                    <span class="current-price">$<?php echo number_format($producto['Precio'], 2); ?></span>
                </div>
                
                <form id="compra-form" action="producto_detalle.php" method="POST">
    <input type="hidden" name="producto_id" value="<?php echo $producto['ID']; ?>">
    <p class="stock-info">Cantidad: 
        <input type="number" name="cantidad" min="1" max="<?php echo $producto['Stock_disponible']; ?>" value="1">
    </p>
    <?php
    // Verificar si el usuario está logueado como cliente
    if ($nombre === "Invitado") {
        echo "<a href='./Paginas/Formulario_inicio.php' class='action-btn'>Iniciar sesión para comprar</a>";
    } else {
        if ($rol == "cliente") {
            echo "<button type='submit' class='action-btn'>Añadir al carrito</button>";
        }
    }
    ?>
</form>


                <div class="product-description">
                    <h3>Descripción del producto</h3>
                    <p><?php echo $producto['Descripcion']; ?></p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="cont-footer">
            <div class="icon">
                <img src="IMG/Logo_kiosco.png" alt="">
            </div>
            <div class="datos">
                <p>Términos y condiciones</p>
                <p>Políticas de privacidad</p>
                <p>Contacto</p>
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
                    <a href="https://www.instagram.com/jheysmar_m_m/"><i class="fa-brands fa-square-instagram"></i></a>
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
    <script src="https://kit.fontawesome.com/45f45403cb.js" crossorigin="anonymous"></script>
</body>
</html>