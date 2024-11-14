<?php
session_start();
include('../php/Conexion.php'); // Verifica que esta ruta sea correcta

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuario no autenticado.");
}

// Verifica si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    // Si el carrito está vacío, redirige directamente a la página de "Gracias por tu compra"
    header('Location: ../index.php'); 
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$productos_ids = [];
foreach ($_SESSION['carrito'] as $item) {
    $productos_ids[] = $item['producto_id'];
}

$ids_para_consulta = implode(",", array_map('intval', $productos_ids));

// Consulta para obtener productos en el carrito
$sql = "SELECT ID, Nombre_producto, Precio, Stock_disponible FROM productos WHERE ID IN ($ids_para_consulta)";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Comienza la confirmación de compra
    if (isset($_POST['confirmar_compra'])) {
        // Comienza la transacción
        $conexion->begin_transaction();

        try {
            // Inicializar el total de la compra
            $total = 0;
            $productos_en_carrito = [];

            // Procesar cada producto en el carrito
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
                        // Actualizar el stock
                        $nuevo_stock = $producto['Stock_disponible'] - $cantidad_comprada;
                        $sql_update = "UPDATE productos SET Stock_disponible = ? WHERE ID = ?";
                        $stmt_update = $conexion->prepare($sql_update);
                        $stmt_update->bind_param("ii", $nuevo_stock, $producto_id);
                        if ($stmt_update->execute()) {
                            // Calcular el total
                            $total += $producto['Precio'] * $cantidad_comprada;
                            $productos_en_carrito[] = [
                                'ID' => $producto_id,
                                'Precio' => $producto['Precio'],
                                'cantidad' => $cantidad_comprada
                            ];
                        } else {
                            throw new Exception("Error al actualizar el stock para el producto ID: $producto_id.");
                        }
                    } else {
                        throw new Exception("No hay suficiente stock para el producto ID: $producto_id. Solo hay " . $producto['Stock_disponible'] . " unidades.");
                    }
                } else {
                    throw new Exception("Producto con ID $producto_id no encontrado.");
                }
            }

            // Insertar la nueva venta en la tabla ventas
            $sql = "INSERT INTO ventas (Total, Usuario_id) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param('di', $total, $usuario_id);
            $stmt->execute();
            $venta_id = $stmt->insert_id;

            // Obtener la dirección de envío (suponiendo que viene del formulario)
            $direccion = $_POST['direccion_envio']; // Asegúrate de que la dirección esté siendo enviada en el formulario

            // Verificar si la dirección se ha recibido correctamente
            if (empty($direccion)) {
                throw new Exception("La dirección de envío no está definida.");
            }

            // Insertar los detalles de la compra en la tabla detalle_venta
            $sql = "INSERT INTO detalle_venta (Venta_id, Producto_id, Cantidad, Subtotal, Envio) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            foreach ($productos_en_carrito as $producto) {
                $subtotal = $producto['Precio'] * $producto['cantidad'];
                $stmt->bind_param('iiids', $venta_id, $producto['ID'], $producto['cantidad'], $subtotal, $direccion);
                if (!$stmt->execute()) {
                    throw new Exception("Error al insertar detalle de venta para el producto ID: {$producto['ID']}");
                }
            }

            // Commit si todo salió bien
            $conexion->commit();
            // Guardar el total en la sesión para pasarlo a Ticket.php
            $_SESSION['total_compra'] = $total;

            // Limpiar el carrito después de la compra
            unset($_SESSION['carrito']);

            // Redirigir a la página de agradecimiento
            header('Location: GraciasCompra.php');
            exit;

        } catch (Exception $e) {
            // En caso de error, hacer rollback
            $conexion->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    // Si no hay productos, solo muestra el mensaje de compra exitosa
    header('Location: GraciasCompra.php');
    exit;
}

$conexion->close();
?>