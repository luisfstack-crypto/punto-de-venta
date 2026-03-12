<?php

namespace App\Mail;

use App\Models\Cotizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CotizacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cotizacion;
    public $empresa;
    public $asunto;
    public $mensajePersonalizado;
    public $firma;

    public function __construct(
        Cotizacion $cotizacion,
        $empresa,
        string $asunto = null,
        string $mensajePersonalizado = null,
        string $firma = null
    ) {
        $this->cotizacion           = $cotizacion;
        $this->empresa              = $empresa;
        $this->asunto               = $asunto ?? 'Cotización ' . ($empresa->nombre ?? config('app.name')) . ' - ' . ($cotizacion->observaciones ?? 'Nuevo Presupuesto');
        $this->mensajePersonalizado = $mensajePersonalizado;
        $this->firma                = $firma;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->asunto);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.cotizacion');
    }

    public function attachments(): array
    {
        return [];
    }
}
