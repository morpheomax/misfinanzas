<!-- resources/views/metas/components/table.blade.php -->
<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Nombre</th>
            <th class="border border-gray-300 px-4 py-2">Descripción</th>
            <th class="border border-gray-300 px-4 py-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($metas as $meta)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $meta->id }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $meta->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $meta->description }}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <button class="bg-blue-500 text-white px-3 py-1 rounded"
                        onclick="editMeta({{ $meta->id }})">Editar</button>
                    <button class="bg-red-500 text-white px-3 py-1 rounded"
                        onclick="deleteMeta({{ $meta->id }})">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
