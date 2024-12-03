<!-- resources/views/metas/components/form-edit.blade.php -->
<form id="form-edit-meta" action="" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="meta_id" id="meta_id">
    <div>
        <label for="edit-name" class="block text-sm font-medium">Nombre</label>
        <input type="text" name="name" id="edit-name" class="block w-full mt-1 border-gray-300 rounded-md">
    </div>
    <div class="mt-4">
        <label for="edit-description" class="block text-sm font-medium">Descripción</label>
        <textarea name="description" id="edit-description" rows="4" class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
    </div>
    <div class="mt-6">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
    </div>
</form>
