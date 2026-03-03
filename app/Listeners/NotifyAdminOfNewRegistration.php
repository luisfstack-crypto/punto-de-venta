<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\UserRegistrationPending;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminOfNewRegistration implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct() {}

    public function handle(Registered $event): void
    {
        $newUser = $event->user;

        try {
            Mail::to($newUser->email)->send(new UserRegistrationPending($newUser));
        } catch (\Exception $e) {
            Log::error('[Registro] Error al enviar correo al usuario: ' . $e->getMessage());
        }

        try {
            $adminRole = Role::where('name', 'administrador')->first();
            
            if ($adminRole) {
                $admins = User::role('administrador')->where('status', 'active')->get();
            } else {
                $admins = User::where('email', 'solucionesedgar@gmail.com')->get();
            }

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new \App\Mail\AdminNewUserNotification($newUser));
            }
        } catch (\Exception $e) {
            Log::error('[Registro] Error al notificar al administrador: ' . $e->getMessage());
        }
    }
}
