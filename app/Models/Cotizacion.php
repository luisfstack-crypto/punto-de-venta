<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';
    protected $guarded = ['id'];
    protected $dates = ['fecha_hora', 'fecha_validez', 'enviado_at'];

    protected static function booted(): void
    {
        static::creating(function (self $cotizacion) {
            if (empty($cotizacion->token_publico)) {
                $cotizacion->token_publico = \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comprobante(): BelongsTo
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'cotizacion_producto')
            ->withTimestamps()
            ->withPivot('cantidad', 'precio', 'descuento', 'descripcion');
    }

    public function getFechaAttribute(): string
    {
        return Carbon::parse($this->fecha_hora)->format('d-m-Y');
    }

    public function getHoraAttribute(): string
    {
        return Carbon::parse($this->fecha_hora)->format('H:i');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->productos->sum(fn($p) =>
            $p->pivot->cantidad * $p->pivot->precio * (1 - ($p->pivot->descuento ?? 0) / 100)
        );
    }

    public function getUrlPublicaAttribute(): string
    {
        if (empty($this->token_publico)) {
            return '#';
        }
        return route('cotizaciones.publica', $this->token_publico);
    }
}
