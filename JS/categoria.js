// categoria.js
function cargarProductosPorCategoria(categoriaId) {
    // Realizar la solicitud al servidor
    fetch(`php/obtener_productos.php?categoria=${categoriaId}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.product-container').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar productos:', error));
}
