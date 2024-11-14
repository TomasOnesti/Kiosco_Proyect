// JS/cargarProductos.js
document.addEventListener("DOMContentLoaded", function() {
    fetch('php/obtener_productos.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.product-container');
            data.forEach(producto => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    <a href='producto_detalle.php?id=${producto.ID}' class='product-link'>
                        <div class='product-image-text'>
                            <img src='${producto.Imagen}' alt='Imagen del producto' class='product-image'>
                            <div class='product-info'>
                                <h2 class="nombre_producto">${producto.Nombre_producto}</h2>
                                <div class='price'>
                                    <span class='current-price'>$${producto.Precio.toFixed(2)}</span>
                                </div>
                                <div class='action-text'>Llega hoy</div>
                            </div>
                        </div>
                    </a>`;
                if ('<?php echo $rol; ?>' === 'vendedor') {
                    productCard.innerHTML += `
                        <div class='eliminar'>
                            <form action='php/eliminar_producto.php' method='POST' class='delete-form' onsubmit='return confirmarEliminacion()'>
                                <input type='hidden' name='id_producto' value='${producto.ID}'>
                                <button type='submit' class='delete-button'> - </button>
                            </form>
                        </div>
                        <div class='modificar'>
                            <a href='Paginas/modificar.php?id=${producto.ID}&nombre=${encodeURIComponent(producto.Nombre_producto)}&precio=${encodeURIComponent(producto.Precio)}&descripcion=${encodeURIComponent(producto.Descripcion)}&stock=${encodeURIComponent(producto.Stock_disponible)}'>
                                <img src='Img/modificar.png' alt='Modificar producto' class='modificar-imagen'>
                            </a>
                        </div>`;
                }
                container.appendChild(productCard);
            });
        })
        .catch(error => console.error('Error al cargar los productos:', error));
});
