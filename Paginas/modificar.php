<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../CSS/vendedor/agregar_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body id="fondo">
    <header>
        <h1>Bienvenido, Por favor modifique el Producto</h1>
    </header>
    <main>
        <?php
            // Incluir la conexión a la base de datos
            include "../php/Conexion.php";

            // Obtener el ID del producto de la URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consultar los detalles del producto
                $sql = "SELECT * FROM productos WHERE ID = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Comprobar si se encontró el producto
                if ($result->num_rows > 0) {
                    $producto = $result->fetch_assoc();
                    $nombre = $producto['Nombre_producto'];
                    $descripcion = $producto['Descripcion'];
                    $precio = $producto['Precio'];
                    $stock = $producto['Stock_disponible'];
                    $nombre_imagen = $producto['imagen']; // O el campo correspondiente
                } else {
                    echo "<p>Producto no encontrado.</p>";
                    exit; // Termina el script si no se encuentra el producto
                }
            } else {
                echo "<p>No se ha proporcionado un ID de producto.</p>";
                exit; // Termina el script si no se proporciona un ID
            }
        ?>
        
        <form action="../php/modificar_p.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <article>
            <div class="Registro">
                <h4>Modificar Producto</h4>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input class="control" type="text" name="producto" id="producto" value="<?php echo htmlspecialchars($nombre); ?>" placeholder="Ingrese el nombre del producto" required>
                <input class="control" type="text" name="descripcion" id="descripcion" value="<?php echo htmlspecialchars($descripcion); ?>" placeholder="Descripción" required>
                <input class="control" type="text" name="precio" id="precio" value="<?php echo htmlspecialchars($precio); ?>" placeholder="Ingrese el precio unitario" required>
                <input class="control" type="text" name="stock_disponible" id="stock_disponible" value="<?php echo htmlspecialchars($stock); ?>" placeholder="Stock disponible" required>
                <input type="text" name="nombre_imagen" placeholder="Ingrese el nombre de la imagen" value="<?php echo htmlspecialchars($nombre_imagen); ?>">
                <input type="file" name="imagen">
                <?php
                    include "../php/Conexion.php";
                    $query = "SELECT id_categoria, categoria FROM categoria";
                    $result = $conexion->query($query);
                    echo '<select name="Categoria" class="form-select">';
                    echo '<option value="" disabled>Seleccione una Categoría</option>';
                    while ($categoria = $result->fetch_array()){
                        echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['categoria'] . '</option>';
                    }
                    echo '</select>';        
                    ?>
                <br>
                <?php
                    include "../php/Conexion.php";
                    $query = "SELECT ID, Nombre FROM proveedores";
                    $result = $conexion->query($query);
                    echo '<select name="Proveedores" class="form-select">';
                    echo '<option value="" disabled>Seleccione un Proveedor</option>';
                    while ($proveedor = $result->fetch_array()){
                        echo '<option value="' . $proveedor['ID'] . '">' . $proveedor['Nombre'] . '</option>';
                    }
                    echo '</select>';        
                    ?>
                <input class="boton" type="submit" value="Modificar producto" name="modificar_p">
                <p><a href="../index.php">¿Quieres salir?</a></p>
            </div>
        </article>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
