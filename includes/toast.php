<!-- Footer.php: Toast global + función JavaScript -->
<!-- Coloca esto justo antes de cerrar </body> -->

<!-- Toast visual universal -->
<div class="toast text-white position-fixed bottom-0 end-0 m-3" id="toastMsg" role="alert">
    <div class="toast-header bg-primary text-white">
        <strong class="me-auto" id="toastTitulo">Título</strong>
        <small id="toastTiempo">Ahora</small>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body" id="toastBody">
        Cuerpo del mensaje
    </div>
</div>


<!-- Bootstrap & jQuery (si no están incluidos ya en header.php) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- Función para mostrar toast dinámicamente -->
<script>
    function mostrarToast(titulo = "Notificación", tiempo = "Ahora", mensaje = "Mensaje genérico", claseFondo = "bg-success") {
        const toastElement = $('#toastMsg');

        // Limpiar clases de fondo anteriores (bg-success, etc.)
        toastElement.removeClass(function(_, currentClasses) {
            return (currentClasses.match(/bg-\S+/g) || []).join(' ');
        });

        // Aplicar nueva clase de fondo
        toastElement.addClass(`${claseFondo}`);

        // Actualizar contenido dinámico
        $('#toastTitulo').text(titulo);
        $('#toastTiempo').text(tiempo);
        $('#toastBody').text(mensaje);

        // Mostrar toast
        const toast = new bootstrap.Toast(toastElement[0]);
        toast.show();
    }
</script>