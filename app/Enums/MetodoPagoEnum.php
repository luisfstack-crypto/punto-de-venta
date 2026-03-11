<?php

namespace App\Enums;

enum MetodoPagoEnum: string
{
    case Efectivo        = 'EFECTIVO';
    case Tarjeta         = 'TARJETA';
    case Transferencia   = 'TRANSFERENCIA';
    case Credito         = 'CREDITO';
    case MercadoPago     = 'MERCADO_PAGO';
    case Cheque          = 'CHEQUE';

    public function label(): string
    {
        return match($this) {
            self::Efectivo      => 'Efectivo',
            self::Tarjeta       => 'Tarjeta de débito/crédito',
            self::Transferencia => 'Transferencia bancaria (SPEI)',
            self::Credito       => 'Crédito',
            self::MercadoPago   => 'Terminal Mercado Pago',
            self::Cheque        => 'Cheque',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Efectivo      => 'bi bi-cash-stack',
            self::Tarjeta       => 'bi bi-credit-card-2-front',
            self::Transferencia => 'bi bi-arrow-left-right',
            self::Credito       => 'bi bi-file-earmark-text',
            self::MercadoPago   => 'bi bi-phone',
            self::Cheque        => 'bi bi-journal-check',
        };
    }
}
