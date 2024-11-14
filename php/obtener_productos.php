<?php
session_start();
include 'Conexion.php';

// Verifica si el usuario ha iniciado sesión y tiene un rol
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// Verifica si la categoría está establecida
if (isset($_GET['categoria'])) {
    $categoriaId = intval($_GET['categoria']);

    $sql = "SELECT ID, Nombre_producto, Descripcion, Precio, Stock_disponible, Imagen FROM productos WHERE categoria_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $categoriaId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product-card'>
                    <a href='producto_detalle.php?id=" . $row['ID'] . "' class='product-link'>
                        <div class='product-image-text'>
                            <img src='" . $row['Imagen'] . "' alt='Imagen del producto' class='product-image'>
                            <div class='product-info'>
                                <h2 class='nombre_producto'>" . $row['Nombre_producto'] . "</h2>
                                <div class='price'>
                                    <span class='current-price'>$" . number_format($row['Precio'], 2) . "</span>
                                </div>
                                <div class='action-text'>Llega hoy</div>
                            </div>
                        </div>
                    </a>";

            // Mostrar opciones de eliminar y modificar si el usuario es vendedor
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

            echo "</div>"; // Cerrar product-card
        }
    } else {
        echo "<p>No hay productos disponibles en esta categoría.</p>";
    }
    $stmt->close();
} else {
    echo "<p>Categoría no especificada.</p>";
}
?>

<script>
    function mostrarPopup() {
        document.getElementById("overlay").style.display = "flex";
    }

    function cerrarPopup() {
        document.getElementById("overlay").style.display = "none";
    }

    function confirmarEliminacion() {
        return confirm("¿Estás seguro de que deseas eliminar este producto?");
    }
</script>
