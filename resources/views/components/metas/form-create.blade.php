<!-- resources/views/metas/components/form-create.blade.php -->
<form id="form-create-meta" action="{{ route('metas.store') }}" method="POST">
    @csrf
    <div>
        <label for="name" class="block text-sm font-medium">Nombre</label>
        <input type="text" name="name" id="name" class="block w-full mt-1 border-gray-300 rounded-md">
    </div>
    <div class="mt-4">
        <label for="description" class="block text-sm font-medium">Descripción</label>
        <textarea name="description" id="description" rows="4" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
    </div>
    <div class="mt-6">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
    </div>
</form>
