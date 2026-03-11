{{-- resources/views/layouts/include/navigation-header.blade.php --}}
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- ══ BRAND / LOGO ══ --}}
    <a class="navbar-brand ps-3 pe-2" href="{{ route('panel') }}" style="font-size:0!important;">
        <div class="ao-brand-logo" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            {{-- Logo SVG --}}
            <svg width="32" height="32" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
                <defs>
                    <linearGradient id="nh-gold" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#E8C97A"/>
                        <stop offset="50%" stop-color="#C9A84C"/>
                        <stop offset="100%" stop-color="#A0742A"/>
                    </linearGradient>
                    <linearGradient id="nh-navy" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#2A4A7F"/>
                        <stop offset="100%" stop-color="#1B2D4F"/>
                    </linearGradient>
                    <linearGradient id="nh-accent" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#E8873A"/>
                        <stop offset="100%" stop-color="#C9A84C"/>
                    </linearGradient>
                </defs>
                <circle cx="100" cy="100" r="88" stroke="url(#nh-navy)" stroke-width="7" fill="none"/>
                <path d="M 162 55 A 74 74 0 0 1 168 100" stroke="url(#nh-accent)" stroke-width="7" fill="none" stroke-linecap="round"/>
                <path d="M 100 38 L 70 138 M 100 38 L 130 138 M 78 108 L 122 108"
                      stroke="url(#nh-navy)" stroke-width="10" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <path d="M 68 148 Q 68 118 100 118 Q 132 118 132 148"
                      stroke="url(#nh-gold)" stroke-width="8" stroke-linecap="round" fill="none"/>
                <path d="M 68 148 Q 68 162 78 162 L 96 162 M 132 148 Q 132 162 122 162 L 104 162"
                      stroke="url(#nh-gold)" stroke-width="8" stroke-linecap="round" fill="none"/>
            </svg>
            {{-- Texto --}}
            <div style="display:flex;flex-direction:column;line-height:1.1;">
                <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;color:#FFFFFF;letter-spacing:0.07em;text-transform:uppercase;">
                    ALFA <span style="color:#C9A84C;">Y</span> OMEGA
                </span>
                <span style="font-family:'DM Sans',sans-serif;font-weight:400;font-size:0.58rem;color:#C9A84C;letter-spacing:0.14em;text-transform:uppercase;">
                    Punto de Venta
                </span>
            </div>
        </div>
    </a>

    {{-- ══ TOGGLE SIDEBAR (mobile) ══ --}}
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars fa-fw"></i>
    </button>

    {{-- ══ BUSCADOR (center, desktop) ══ --}}
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </form>

    {{-- ══ ACCIONES DERECHA ══ --}}
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 align-items-center gap-1">

        {{-- Toggle Dark/Light --}}
        <li class="nav-item">
            <button id="themeToggleBtn" title="Cambiar tema">
                <i class="fas fa-moon" id="themeIcon"></i>
                <span class="toggle-label" id="themeLabel">Oscuro</span>
            </button>
        </li>

        {{-- Notificaciones --}}
        <li class="nav-item dropdown">
            <a class="nav-link" id="notificationsDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                @php
                    $unreadCount = auth()->user()?->unreadNotifications?->count() ?? 0;
                @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-danger badge-counter">{{ $unreadCount }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                @forelse(auth()->user()?->notifications?->take(5) ?? [] as $notification)
                    <li>
                        <a class="dropdown-item d-flex align-items-start gap-2 py-2" href="#">
                            <i class="fas fa-info-circle mt-1" style="color:var(--pv-gold);font-size:0.8rem;flex-shrink:0;"></i>
                            <div>
                                <div style="font-size:0.82rem;">{{ $notification->data['message'] ?? 'Notificación' }}</div>
                                <div style="font-size:0.7rem;color:var(--pv-text-muted);">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li>
                        <span class="dropdown-item text-center" style="font-size:0.82rem;color:var(--pv-text-muted);">
                            Sin notificaciones
                        </span>
                    </li>
                @endforelse
            </ul>
        </li>

        {{-- Perfil del usuario --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" id="navbarDropdown"
               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div style="
                    width:30px;height:30px;border-radius:50%;
                    background:linear-gradient(135deg,#2A4A7F,#1B2D4F);
                    display:flex;align-items:center;justify-content:center;
                    font-family:'Syne',sans-serif;font-weight:700;font-size:0.72rem;color:#C9A84C;
                    border:1px solid rgba(201,168,76,0.3);flex-shrink:0;
                ">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
                <span style="font-size:0.82rem;color:rgba(255,255,255,0.75);max-width:110px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ auth()->user()?->name ?? 'Usuario' }}
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <span class="dropdown-item" style="font-size:0.75rem;color:var(--pv-text-muted);cursor:default;">
                        {{ auth()->user()?->email }}
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                @can('administrador')
                <li>
                    <a class="dropdown-item" href="{{ route('users.index') }}">
                        <i class="fas fa-users fa-fw me-2" style="color:var(--pv-gold);font-size:0.8rem;"></i>
                        Administrar usuarios
                    </a>
                </li>
                @endcan
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-right-from-bracket fa-fw me-2" style="color:#EF4444;font-size:0.8rem;"></i>
                        Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display:none;"></form>
                </li>
            </ul>
        </li>

    </ul>
</nav>