<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario</title>
    <link rel="stylesheet" href="../CSS/vendedor/agregar_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body id="fondo">
    <header>
        <h1>Bienvenido, Porfavor Ingrese el Producto</h1>
    </header>
    <main>
        <form action="../php/agregar_p.php" method="post" enctype="multipart/form-data">
        <article>
            <div class="Registro">
                <h4>Registre el Producto nuevo</h4>
                <input class="control" type="text" name="producto" id="producto" placeholder="Ingrese el nombre del producto" required>
                <input class="control" type="text" name="descripcion" id="descripcion" placeholder="Descripcion" required>
                <input class="control" type="text" name="precio" id="precio" placeholder="Ingrese el precio unitario" required>
                <input class="control" type="text" name="tock_disponible" id="stock_disponible" placeholder="Stock_disponible" required>
                <input type="text" name="nombre_imagen" placeholder="Ingrese el nombre de la imagen">
                <input type="file" name="imagen">
                <?php
                    include "../php/Conexion.php";
                    $query="SELECT id_categoria, categoria FROM categoria";
                    $result= $conexion->query($query);
                    echo '<select name="Categoria" class="form-select">';
                    echo '<option value="" disabled selected>Categoria</option>';
                    while ($categoria = $result->fetch_array()){
                        echo '<option value="' . $categoria['id_categoria'] .'">' . $categoria['categoria'] . '</option>';
                    }
                    echo '</select>';        
                ?>
                <br>
                <?php
                    include "../php/Conexion.php";
                    $query="SELECT ID, Nombre FROM proveedores";
                    $result= $conexion->query($query);
                    echo '<select name="Proveedores" class="form-select">';
                    echo '<option value="" disabled selected>Proveedores</option>';
                    while ($categoria = $result->fetch_array()){
                        echo '<option value="' . $categoria['ID'] .'">' . $categoria['Nombre'] . '</option>';
                    }
                    echo '</select>';        
                ?>
                <input class="boton" type="submit" value="Registrar producto al kiosco" name="agregar_p">
                <p><a href="../index.php">¿Quieres salir?</a></p>
            </div>
        </article>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>