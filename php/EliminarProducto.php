<?php
session_start();

if (isset($_POST['producto_id'])) {
    $producto_id = (int) $_POST['producto_id'];
    
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                unset($_SESSION['carrito'][$key]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
    }
}

header('Location: ../Carrito.php');
exit;
?>
