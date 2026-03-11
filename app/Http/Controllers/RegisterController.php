<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users',
            'password'         => 'required|string|min:8|confirmed',
            'payment_receipt'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'empresa_nombre'   => 'nullable|string|max:255',
            'empresa_telefono' => 'nullable|string|max:20',
        ]);

        $path = null;

        if ($request->hasFile('payment_receipt') && $request->file('payment_receipt')->isValid()) {
            try {
                $path = $request->file('payment_receipt')->store('receipts', 'public');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('[Registro] Error al guardar comprobante: ' . $e->getMessage());
                $path = null;
            }
        }

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'payment_receipt' => $path,
            'estado'          => 1,
            'status'          => 'pending',
            'empresa_nombre'  => $request->empresa_nombre,
            'empresa_telefono' => $request->empresa_telefono,
        ]);

        try {
            $adminEmail = 'solucionesedgar@gmail.com'; 
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notify(new \App\Notifications\NewUserRegistered($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[Registro] Error al enviar notificación de nuevo usuario: ' . $e->getMessage());
        }

        /* 
        try {
            event(new Registered($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('[Registro] Error al despachar evento Registered: ' . $e->getMessage());
        }
        */

        return redirect()->route('waiting.approval')->with('success', '¡Registro exitoso! Tu cuenta está pendiente de aprobación por un administrador.');
    }
}
