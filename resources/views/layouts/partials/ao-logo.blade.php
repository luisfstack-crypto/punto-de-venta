{{--
    resources/views/layouts/partials/ao-logo.blade.php
    Uso: @include('layouts.partials.ao-logo', ['size' => 'sm|md|lg', 'showText' => true])
    Defaults: size=md, showText=true
--}}
@php
    $size     = $size     ?? 'md';
    $showText = $showText ?? true;
    $svgSize  = match($size) { 'sm' => 28, 'lg' => 52, default => 36 };
    $nameSize = match($size) { 'sm' => '0.72rem', 'lg' => '1.1rem', default => '0.84rem' };
    $subSize  = match($size) { 'sm' => '0.55rem', 'lg' => '0.72rem', default => '0.62rem' };
@endphp

<div class="ao-brand-logo" style="display:flex;align-items:center;gap:{{ $size === 'sm' ? '8' : '12' }}px;">
    {{-- SVG Logo --}}
    <svg width="{{ $svgSize }}" height="{{ $svgSize }}" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
        <defs>
            <linearGradient id="ao-gold-{{ $size }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#E8C97A"/>
                <stop offset="50%" stop-color="#C9A84C"/>
                <stop offset="100%" stop-color="#A0742A"/>
            </linearGradient>
            <linearGradient id="ao-navy-{{ $size }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#2A4A7F"/>
                <stop offset="100%" stop-color="#1B2D4F"/>
            </linearGradient>
            <linearGradient id="ao-accent-{{ $size }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#E8873A"/>
                <stop offset="100%" stop-color="#C9A84C"/>
            </linearGradient>
        </defs>
        <!-- Anillo exterior navy -->
        <circle cx="100" cy="100" r="88" stroke="url(#ao-navy-{{ $size }})" stroke-width="7" fill="none"/>
        <!-- Arco naranja-dorado (acento) -->
        <path d="M 162 55 A 74 74 0 0 1 168 100"
              stroke="url(#ao-accent-{{ $size }})" stroke-width="7" fill="none" stroke-linecap="round"/>
        <!-- A — triángulo con travesaño -->
        <path d="M 100 38 L 70 138 M 100 38 L 130 138 M 78 108 L 122 108"
              stroke="url(#ao-navy-{{ $size }})" stroke-width="10"
              stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        <!-- Ω — curva base dorada -->
        <path d="M 68 148 Q 68 118 100 118 Q 132 118 132 148"
              stroke="url(#ao-gold-{{ $size }})" stroke-width="8" stroke-linecap="round" fill="none"/>
        <!-- Patas de omega -->
        <path d="M 68 148 Q 68 162 78 162 L 96 162 M 132 148 Q 132 162 122 162 L 104 162"
              stroke="url(#ao-gold-{{ $size }})" stroke-width="8" stroke-linecap="round" fill="none"/>
    </svg>

    @if($showText)
    <div class="ao-logo-text" style="display:flex;flex-direction:column;line-height:1.15;">
        <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:{{ $nameSize }};color:#FFFFFF;letter-spacing:0.07em;text-transform:uppercase;">
            ALFA <span style="color:#C9A84C;">Y</span> OMEGA
        </span>
        <span style="font-family:'DM Sans',sans-serif;font-weight:400;font-size:{{ $subSize }};color:#C9A84C;letter-spacing:0.14em;text-transform:uppercase;">
            Punto de Venta
        </span>
    </div>
    @endif
</div>