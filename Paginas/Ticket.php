<?php
session_start();
include('../php/Conexion.php'); // Verifica que esta ruta sea correcta

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuario no autenticado.");
}

$usuario_id = $_SESSION['usuario_id'];

// Verifica si el carrito está vacío
if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) === 0) {
    die("Tu carrito está vacío.");
}

$productos_ids = [];
foreach ($_SESSION['carrito'] as $item) {
    $productos_ids[] = $item['producto_id'];
}

$ids_para_consulta = implode(",", array_map('intval', $productos_ids));

// Consulta para obtener productos en el carrito
$sql = "SELECT ID, Nombre_producto, Precio, Stock_disponible FROM productos WHERE ID IN ($ids_para_consulta)";
$result = $conexion->query($sql);

$total = 0;

if ($result->num_rows > 0) {
    // Calcular el total de la compra
    foreach ($_SESSION['carrito'] as $item) {
        $producto_id = $item['producto_id'];
        $cantidad_comprada = $item['cantidad'];

        // Verificar si hay suficiente stock
        $sql_check = "SELECT Stock_disponible, Precio FROM productos WHERE ID = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("i", $producto_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $producto = $result_check->fetch_assoc();

            if ($producto['Stock_disponible'] >= $cantidad_comprada) {
                // Calcular el total
                $total += $producto['Precio'] * $cantidad_comprada;
            } else {
                die("No hay suficiente stock para el producto ID: $producto_id.");
            }
        } else {
            die("Producto con ID $producto_id no encontrado.");
        }
    }
} else {
    die("No se encontraron productos en el carrito.");
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/usuarios/Ticket.css">
    <title>Detalles de la Compra</title>
</head>
<body>
    <main class="falso_main">
        <h2>Detalles de la Compra</h2>
        
        <!-- Formulario para confirmar la compra -->
        <form action="ConfirmarCompra.php" method="POST">
            <input type="hidden" name="total" value="<?php echo number_format($total, 2); ?>">
            <label for="metodo_pago">Método de Pago:</label>
            <select name="metodo_pago" id="metodo_pago" required onchange="toggleTarjetaFields()">
                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                <option value="efectivo">Pago en Efectivo</option>
            </select>

            <div id="tarjeta-fields" class="card-container">
                <label for="numero_tarjeta">Ingrese los números de su tarjeta</label>
                <input type="text" class="card-input" name="numero_tarjeta" id="numero_tarjeta" placeholder="Número de Tarjeta">
                
                <label for="fecha_expiracion">Fecha de Expiración (MM/AA)</label>
                <input type="text" class="card-input" name="fecha_expiracion" id="fecha_expiracion" placeholder="Fecha de Expiración (MM/AA)">
                
                <label for="cvv">CVV</label>
                <input type="text" class="card-input" name="cvv" id="cvv" placeholder="CVV">
            </div>

            <label for="direccion">Dirección de Envío:</label>
            <input type="text" name="direccion_envio" placeholder="Ingresa tu dirección de envío" required>

            <h3>Total: $<?php echo number_format($total, 2); ?></h3>
            <button type="submit" name="confirmar_compra" class="btn">Confirmar compra</button>
        </form>
        
        <br><a href="../index.php" class="btn">Volver al inicio</a>
    </main>

    <script src="../JS/Ticket.js"></script>
</body>
</html>
