<div>
    <!-- Versión Desktop: Tabla -->
    <div class="hidden md:block">
        <table class="min-w-full table-auto bg-white rounded-2xl overflow-hidden shadow-md">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Monto</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Monto Ahorrado</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Fecha Cumplimiento</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @foreach ($metas as $meta)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $meta->nombre }}</td>
                        <td class="px-6 py-4">{{ '$' . number_format($meta->monto, 0, '', '.') }}</td>
                        <td class="px-6 py-4">{{ '$' . number_format($meta->monto_ahorrado, 0, '', '.') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($meta->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-4">
                                <a href="{{ route('metas.edit', $meta->id) }}"
                                    class="text-yellow-500 hover:underline">Editar</a>
                                <form action="{{ route('metas.destroy', $meta->id) }}" method="POST"
                                    id="form-eliminar-{{ $meta->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-500 hover:underline btn-eliminar"
                                        data-id="{{ $meta->id }}">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación de escritorio -->
        <div class="mt-4 ">
            {{ $metas->links() }}
        </div>
    </div>

    <!-- Versión Mobile: Tarjetas -->
    <div class="block md:hidden space-y-4">
        @foreach ($metas as $meta)
            <div class="bg-white rounded-2xl shadow-md p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-semibold text-gray-800">#{{ $loop->iteration }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('metas.edit', $meta->id) }}"
                            class="text-yellow-500 text-sm hover:underline">Editar</a>
                        <form action="{{ route('metas.destroy', $meta->id) }}" method="POST"
                            id="form-eliminar-{{ $meta->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-500 text-sm hover:underline btn-eliminar"
                                data-id="{{ $meta->id }}">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-700"><span class="font-medium">Nombre:</span> {{ $meta->nombre }}</p>
                <p class="text-gray-700"><span
                        class="font-medium">Monto:</span>{{ '$' . number_format($meta->monto, 0, '', '.') }}</p>
                <p class="text-gray-700"><span class="font-medium">Monto
                        Ahorrado:</span>{{ '$' . number_format($meta->monto_ahorrado, 0, '', '.') }}</p>
                <p class="text-gray-700"><span
                        class="font-medium">Fecha:</span>{{ \Carbon\Carbon::parse($meta->fecha)->format('d/m/Y') }}</p>
            </div>
        @endforeach

        <!-- Paginación móvil -->
        <div class="mt-4 ">
            {{ $metas->links() }}
        </div>
    </div>
</div>

<!-- Script para integrar SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-eliminar');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¡No podrás recuperar este registro!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envía el formulario correspondiente
                        document.getElementById(`form-eliminar-${id}`).submit();
                    }
                });
            });
        });
    });
</script>