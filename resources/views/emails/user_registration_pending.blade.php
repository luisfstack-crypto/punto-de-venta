<x-mail::message>
# ¡Hola {{ $user->name }}!

Hemos recibido tu solicitud de registro de manera exitosa. 

Actualmente, tu cuenta se encuentra en estado **pendiente de revisión**. Un administrador está revisando tu comprobante de pago o identidad.

Una vez que tu solicitud sea aprobada, te enviaremos otro correo confirmando que ya puedes ingresar al sistema.

Gracias por tu paciencia,<br>
{{ config('app.name') }}
</x-mail::message>
