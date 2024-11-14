<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de ventas</title>
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/adm/admin.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');
    </style>
</head>
<body>
    <header class="cont-header">
        <div class="Contener_opciones">
        
        <Button id="regreso"><a class="botones_admin" href="../index.php">Back</a></Button>
        
        </div>
        <?php
        include "../php/Conexion.php";
        echo"<div class=\"contenedor_h\">
            <img class=\"Logo\" src=\"../Img/Logo_kiosco.png\" alt=\"Logo\">
         </div>
            <div class=\"copy\">
            <nav>
                <li>
                    <a href=\"chocolates.html\">
                    <button class=\"Boton\">Chocolates</button>
                    </a>
                </li>
                <li> 
                    <button class=\"Boton\">Alfajores</button>
                </li>
                <li>
                    <button class=\"Boton\">Golosinas</button>
                </li>
                <li>
                    <button class=\"Boton\">Bebidas</button>
                </li>
                <li>
                    <button class=\"Boton\">Menu</button>
                </li>
                <li>
                    <button class=\"Boton desaparecer\">Promos</button>
                </li>
                <li>
                    <button class=\"Boton desaparecer\" >Marcas</button>
                </li>
            </nav>
        </div>";
        ?>
    </header>
    <main>
    <article class="contenedor">
        <?php
        $venta = "SELECT usuarios.Nombre, ventas.Fecha, productos.Nombre_producto, `Cantidad`, `Subtotal`, `Envio`, ventas.Total FROM `detalle_venta` JOIN ventas ON detalle_venta.Venta_id = ventas.ID JOIN usuarios ON ventas.Usuario_id = usuarios.ID JOIN productos ON detalle_venta.Producto_id = productos.ID WHERE 1";
        $resul_venta = $conexion ->query($venta);

        if($resul_venta->num_rows > 0){
            while($Filas=$resul_venta->fetch_array()){
                echo "
                <div class=\"Registro\">
                    <h2 class=\"titulo\">".$Filas['Nombre']."</h2>
                    <p class=\"control cuadrito\">".$Filas['Fecha']."</p>
                    <div class=\"posiciones\">
                    <li class=\"control cuadrito\"><p> Producto:  ".$Filas['Nombre_producto']."</p></li>
                    <li class=\"control cuadrito\"><p> Cantidad:  ".$Filas['Cantidad']."</p></li>
                    <li class=\"control cuadrito\"><p> Subtotal:  ".$Filas['Subtotal']."$</p></li>
                    </div>
                    <li class=\"control cuadrito\"><p> Direccion:  ".$Filas['Envio']."</p></li>
                    <h2 class=\"titulo cuadrito\"> Total: ".$Filas['Total']."$</h2>
                </div>";
            }
        }
        ?>
        </article>
    </main>

    <footer>
        <div class="cont-footer" >
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
    <script src="https://kit.fontawesome.com/45f45403cb.js" crossorigin="anonymous"></script>
</body>
</html>




