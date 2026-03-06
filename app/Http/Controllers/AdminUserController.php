<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserApproved;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Listar usuarios en estado 'pending'
     */
    public function pendingUsers()
    {
        $users = User::where('status', 'pending')->get();
        $roles = Role::where('name', '!=', 'administrador')->get();
        return view('admin.users.pending', compact('users', 'roles'));
    }

    /**
     * Ver el comprobante o documento de identidad
     */
    public function showReceipt(User $user)
    {
        if (!$user->payment_receipt) {
            abort(404, 'El usuario no ha subido comprobante.');
        }

        $path = storage_path('app/public/' . $user->payment_receipt);

        if (!file_exists($path)) {
            abort(404, 'Archivo no encontrado en el servidor.');
        }

        return response()->file($path);
    }

    /**
     * Aprobar la solicitud del usuario
     */
    public function approve(Request $request, User $user)
    {
        // Validar que se reciba un rol válido (excepto administrador para evitar escalado en masa)
        $request->validate([
            'role' => 'required|exists:roles,name|not_in:administrador'
        ]);

        $user->update(['status' => 'active']);
        
        // Asignar el rol elegido al usuario
        $user->assignRole($request->role);

        try {
            // Enviar notificación por correo
            Mail::to($user->email)->send(new UserApproved($user));
            $mensaje = 'Usuario aprobado exitosamente y notificado por correo.';
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[Aprobación] Error al enviar correo a ' . $user->email . ': ' . $e->getMessage());
            $mensaje = 'Usuario aprobado, pero el correo de notificación no pudo enviarse.';
        }

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Rechazar la solicitud del usuario
     */
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Usuario rechazado.');
    }
}
