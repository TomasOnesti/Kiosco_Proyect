// Función para mostrar u ocultar los campos de la tarjeta según el método de pago seleccionado
function toggleTarjetaFields() {
    const metodoPago = document.getElementById('metodo_pago').value;
    const tarjetaFields = document.getElementById('tarjeta-fields');

    if (metodoPago === 'tarjeta') {
        tarjetaFields.style.display = 'block';
        document.getElementById('numero_tarjeta').required = true;
        document.getElementById('fecha_expiracion').required = true;
        document.getElementById('cvv').required = true;
    } else {
        tarjetaFields.style.display = 'none';
        document.getElementById('numero_tarjeta').required = false;
        document.getElementById('fecha_expiracion').required = false;
        document.getElementById('cvv').required = false;
    }
}

// Llama a la función al cargar la página para configurar el estado inicial
document.addEventListener('DOMContentLoaded', function() {
    toggleTarjetaFields();
});
