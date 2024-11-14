document.getElementById('cantidad').addEventListener('input', function() {
document.getElementById('cantidad-form').value = this.value;
});

function validarCompra() {
    const cantidadInput = document.getElementById('cantidad');
    const cantidad = parseInt(cantidadInput.value);
    const stockDisponible = parseInt(cantidadInput.max);

    if (cantidad <= 0) {
        alert("Por favor, ingresa una cantidad válida.");
        return false;
    }

    if (cantidad > stockDisponible) {
        alert(`No tenemos suficiente stock. Solo hay ${stockDisponible} unidades disponibles.`);
        return false;
    }

    return true; // Permitir el envío del formulario
}
