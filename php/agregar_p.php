<?php
    include "../php/Conexion.php";

    if(!empty($_POST['agregar_p'])){
        if(!isset($_POST['producto']) || !isset($_POST['descripcion']) || !isset($_POST['precio']) || !isset($_POST['tock_disponible']) || !isset($_POST['Categoria']) || !isset($_POST['Proveedores']) || !isset($_POST['nombre_imagen'])){
            echo "Por favor, rellene todos los campos";
            return;
        }

        $producto = $_POST['producto'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $tock_disponible = $_POST['tock_disponible'];
        $Categoria = $_POST['Categoria'];
        $proveedor = $_POST['Proveedores'];
        $nombre_imagen = $_POST['nombre_imagen'];

        if(isset($_FILES['imagen'])){
            $imagen = $_FILES['imagen'];
            $ruta_imagen = '';

            // Verifica si se seleccionó una imagen
            if($imagen['error'] == 0){
                // Guarda la imagen en el directorio especificado
                $nombre_imagen_final = $nombre_imagen . '.' . pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $direccion_imagen = './Img/Productos/' . $nombre_imagen_final;
                move_uploaded_file($imagen['tmp_name'], $direccion_imagen);
                // Guarda la ruta de la imagen en la base de datos
                $ruta_imagen = $direccion_imagen;
            }
        }

        $stmt = $conexion->prepare("INSERT INTO productos(Nombre_producto, Descripcion, Precio, Stock_disponible, Categoria_id, proveedores_id, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $producto, $descripcion, $precio, $tock_disponible, $Categoria, $proveedor, $ruta_imagen);
        if ($stmt->execute()){
            header("Location: ../");
        }else{
            echo "No se pudo insertar el producto";
        }
        mysqli_close($conexion);
    }
?>