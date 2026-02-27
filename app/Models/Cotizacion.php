<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';
    protected $guarded = ['id'];
    protected $dates = ['fecha_hora', 'fecha_validez', 'enviado_at'];

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
            ->withPivot('cantidad', 'precio', 'descuento');
    }

    public function getFechaAttribute(): string
    {
        return Carbon::parse($this->fecha_hora)->format('d-m-Y');
    }

    public function getHoraAttribute(): string
    {
        return Carbon::parse($this->fecha_hora)->format('H:i');
    }
}
