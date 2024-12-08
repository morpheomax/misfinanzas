<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        // Solo los administradores pueden ver todos los usuarios
        $this->authorize('viewAny', User::class);
        $users = User::all();

        return view('user.index', compact('users'));
    }
    /**
     * Display the user edit form.
     */
    public function edit(User $user)
    {

        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * Update user information.
     */
    public function update(Request $request, User $user)
    {
        // Autorización para actualizar el ingreso
        $this->authorize('update', $user);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $user->update($validatedData);

        //return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente');
        return redirect()->route('user.show', $user->id)->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Ingreso actualizado correctamente',
            'icon' => 'info',
        ]);
    }

    // Mostrar egreso
    public function show(User $user)
    {

// Autorizar que el usuario solo pueda ver su propia información
        $this->authorize('view', $user);
        return view('user.show', compact('user'));
    }

    // Cambio de contraseña
    public function changePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return back()->with('swal', [
                'title' => 'Error!',
                'text' => 'La contraseña actual no es correcta.',
                'icon' => 'error',
            ]);
        }

        $user->update([
            'password' => Hash::make($validatedData['new_password']),
        ]);

        return back()->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Contraseña actualizada correctamente.',
            'icon' => 'info',
        ]);

    }
    /**
     * Deactivate the user account.
     */
    public function deactivate(User $user)
    {

        $this->authorize('deactivate', $user);

        $user->update(['is_active' => false]);
        Auth::logout();

        return redirect('/')->with('swal', [
            'title' => 'Atención!',
            'text' => 'Cuenta desactivada. Esperamos verte de nuevo pronto.',
            'icon' => 'warning',
        ]);

    }

    /**
     * Reactivate the user account.
     */
    public function reactivate(Request $request, User $user)
    {
        $user = User::findOrFail($request->user_id);
        $this->authorize('update', $user);

        $user->update(['is_active' => true]);

        return redirect()->route('user.edit')->with('swal', [
            'title' => '¡Éxito!',
            'text' => 'Cuenta Activada correctamente',
            'icon' => 'info',
        ]);
    }
}
