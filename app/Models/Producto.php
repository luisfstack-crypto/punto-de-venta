<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Producto extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'facturable' => 'boolean',
    ];

    // ─── Relaciones ───────────────────────────────────────────────────────────

    public function categoria(): BelongsTo    { return $this->belongsTo(Categoria::class); }
    public function marca(): BelongsTo        { return $this->belongsTo(Marca::class); }
    public function presentacione(): BelongsTo { return $this->belongsTo(Presentacione::class); }
    public function inventario(): HasOne      { return $this->hasOne(Inventario::class); }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ProductoImagen::class)->orderBy('orden');
    }

    // ─── Hooks ────────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $producto) {
            if (empty($producto->codigo)) {
                $producto->codigo = self::generateUniqueCode();
            }
        });
    }

    // ─── Helpers privados ─────────────────────────────────────────────────────

    private static function generateUniqueCode(): string
    {
        do {
            $code = str_pad(random_int(0, 9999999999), 12, '0', STR_PAD_LEFT);
        } while (self::where('codigo', $code)->exists());

        return $code;
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getNombreCompletoAttribute(): string
    {
        return "Código: {$this->codigo} - {$this->nombre} - Presentación: {$this->presentacione->sigla}";
    }

    /**
     * Etiqueta de tasa legible para el comprobante fiscal.
     */
    public function getTasaLabelAttribute(): string
    {
        return match ($this->tasa_cuota) {
            '0.160000' => 'IVA 16%',
            '0.080000' => 'IVA 8%',
            '0.000000' => 'Tasa 0%',
            'Exento'   => 'Exento',
            default    => $this->tasa_cuota ?? '—',
        };
    }
}
