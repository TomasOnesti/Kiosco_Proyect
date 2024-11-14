<?php
session_start();
include 'php/Conexion.php';

if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) === 0) {
    echo "Tu carrito está vacío.";
    exit;
}

$productos_ids = [];
foreach ($_SESSION['carrito'] as $item) {
    $productos_ids[] = $item['producto_id'];
}

$ids_para_consulta = implode(",", array_map('intval', $productos_ids));

$sql = "SELECT ID, Nombre_producto, Precio, Imagen FROM productos WHERE ID IN ($ids_para_consulta)";
$result = $conexion->query($sql);

$productos_en_carrito = [];
$total = 0;
if ($result->num_rows > 0) {
    while ($producto = $result->fetch_assoc()) {
        foreach ($_SESSION['carrito'] as $item) {
            if ($item['producto_id'] == $producto['ID']) {
                $producto['cantidad'] = $item['cantidad'];
                $productos_en_carrito[] = $producto;
                $total += $producto['Precio'] * $item['cantidad'];
            }
        }
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/usuarios/Carrito.css">
    <title>Carrito</title>
</head>
<body>
    <main>
        <h2>Tu carrito</h2>
        <?php if (count($productos_en_carrito) > 0): ?>
            <ul>
                <?php foreach ($productos_en_carrito as $item): ?>
                    <li>
                        <img src="<?php echo htmlspecialchars($item['Imagen']); ?>" alt="<?php echo htmlspecialchars($item['Nombre_producto']); ?>" width="100"><br>
                        Producto: <?php echo htmlspecialchars($item['Nombre_producto']); ?><br>
                        Cantidad: <?php echo htmlspecialchars($item['cantidad']); ?><br>
                        Precio unitario: $<?php echo htmlspecialchars(number_format($item['Precio'], 2)); ?><br>
                        Subtotal: $<?php echo htmlspecialchars(number_format($item['Precio'] * $item['cantidad'], 2)); ?><br>
                        <form action="php/EliminarProducto.php" method="POST" style="display:inline;">
                            <input type="hidden" name="producto_id" value="<?php echo $item['ID']; ?>">
                            <button type="submit" class="btn eliminar-btn">Eliminar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h3>Total: $<?php echo number_format($total, 2); ?></h3>
            <form action="php/VaciarCarrito.php" method="POST">
                <button type="submit" class="btn vaciar-btn">Vaciar carrito</button>
            </form>
            <div>
                <p></p>
            </div>
            <a href="./Paginas/Ticket.php?total=<?php echo $total; ?>" class="btn">Confirmar compra</a>
            <a href="index.php" class="btn">Seguir Comprando</a>
        <?php else: ?>
            <?php header("Location: ../index.php"); exit; ?>
        <?php endif; ?>
    </main>
</body>
</html>