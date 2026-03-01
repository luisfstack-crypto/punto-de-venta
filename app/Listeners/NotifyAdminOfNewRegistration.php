<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistrationPending;

class NotifyAdminOfNewRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $admin = User::where('email', 'solucionesedgar@gmail.com')->first();
        
        if ($admin) {
            $admin->notify(new NewUserRegistered($event->user));
        }

        Mail::to($event->user->email)->send(new UserRegistrationPending($event->user));
    }
}
