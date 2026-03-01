<x-mail::message>
# ¡Cuenta Aprobada!

Hola {{ $user->name }},

Te informamos que tu comprobante ha sido verificado y tu cuenta está ahora **activa**.

Ya puedes iniciar sesión en nuestro sistema y disfrutar de nuestros servicios.

<x-mail::button :url="route('login.index')">
Iniciar Sesión
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
