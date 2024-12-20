<form action="{{ route('egresos.duplicate', $egreso->id) }}" method="POST" style="display: inline;"
    id="duplicar-form-{{ $egreso->id }}">
    @csrf
    <button type="button" class="text-blue-500 text-sm hover:underline" id="btn-duplicar-{{ $egreso->id }}">
        Duplicar
    </button>
</form>

{{-- Manejo de alerta sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el botón de duplicar
        const buttonDuplicar = document.querySelector('#btn-duplicar-{{ $egreso->id }}');

        buttonDuplicar.addEventListener('click', function() {
            // Muestra SweetAlert2 para confirmar la acción
            Swal.fire({
                title: '¿Estás seguro de duplicar este egreso?',
                text: "Recuerde que debe editar los datos del registro duplicado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, duplicar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía el formulario
                    document.querySelector('#duplicar-form-{{ $egreso->id }}').submit();
                }
            });
        });

        // Mostrar el mensaje de SweetAlert si se encuentra en la sesión
        const swalData = @json(session('swal'));
        if (swalData) {
            Swal.fire(swalData);
        }
    });
</script>
