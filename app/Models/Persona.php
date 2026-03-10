<?php

namespace App\Models;

use App\Enums\TipoPersonaEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tipo'             => TipoPersonaEnum::class,
        'requiere_factura' => 'boolean',
    ];

    // ─── Relaciones ───────────────────────────────────────────────────────────

    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function proveedore(): HasOne
    {
        return $this->hasOne(Proveedore::class);
    }

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Etiqueta legible para el tipo de persona (terminología mexicana).
     * NATURAL   → Persona Física
     * JURIDICA  → Persona Moral
     */
    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            TipoPersonaEnum::NATURAL   => 'Persona Física',
            TipoPersonaEnum::JURIDICA  => 'Persona Moral',
            default                    => $this->tipo->value,
        };
    }

    /**
     * Etiqueta legible para el documento de identidad (terminología mexicana).
     * El modelo Documento define el nombre; aquí lo mostramos con contexto MX.
     */
    public function getIdentificacionLabelAttribute(): string
    {
        $nombre = optional($this->documento)->nombre ?? 'Identificación oficial';
        return "{$nombre}: {$this->numero_documento}";
    }

    /**
     * Dirección fiscal completa formateada en una línea.
     */
    public function getDireccionFiscalCompletaAttribute(): string
    {
        $partes = array_filter([
            $this->calle,
            $this->numero_exterior ? "Núm. ext. {$this->numero_exterior}" : null,
            $this->numero_interior ? "Núm. int. {$this->numero_interior}" : null,
            $this->cruzamientos    ? "entre {$this->cruzamientos}"         : null,
            $this->ciudad,
            $this->estado_fiscal,
            $this->codigo_postal   ? "C.P. {$this->codigo_postal}"         : null,
            $this->pais,
        ]);

        return implode(', ', $partes);
    }
}
