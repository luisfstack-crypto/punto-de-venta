{{-- resources/views/layouts/include/navigation-header.blade.php --}}
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- ══ BRAND / LOGO ══ --}}
    <a class="navbar-brand ps-3 pe-2" href="{{ route('panel') }}" style="font-size:0!important;">
        <div class="ao-brand-logo" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            {{-- Logo --}}
            <div class="ao-logo-badge">
                <img src="{{ asset('assets/img/logo.png') }}" 
                     alt="Alfa y Omega PV" 
                     style="height: 28px; width:auto; object-fit:contain;">
            </div>
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
                {{-- Avatar con inicial --}}
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

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width:220px;">

                {{-- Info del usuario --}}
                <li>
                    <div class="px-3 py-2" style="border-bottom:1px solid var(--pv-border);">
                        <div style="font-family:'Syne',sans-serif;font-weight:600;font-size:0.82rem;color:var(--pv-text-primary);">
                            {{ auth()->user()?->name }}
                        </div>
                        <div style="font-size:0.72rem;color:var(--pv-text-muted);margin-top:1px;">
                            {{ auth()->user()?->email }}
                        </div>
                        <div style="margin-top:4px;">
                            <span style="
                                display:inline-block;font-size:0.62rem;font-family:'Syne',sans-serif;
                                font-weight:600;letter-spacing:0.06em;text-transform:uppercase;
                                background:rgba(201,168,76,0.12);color:#C9A84C;
                                border:1px solid rgba(201,168,76,0.25);
                                border-radius:20px;padding:0.15em 0.6em;
                            ">
                                {{ auth()->user()?->getRoleNames()->first() ?? 'Usuario' }}
                            </span>
                        </div>
                    </div>
                </li>

                {{-- Configuración de cuenta / Mi perfil --}}
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(42,74,127,0.12);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-user-gear" style="color:#2A4A7F;font-size:0.72rem;"></i>
                        </span>
                        <div>
                            <div style="font-size:0.83rem;font-weight:500;">Mi perfil</div>
                            <div style="font-size:0.68rem;color:var(--pv-text-muted);">Datos y configuración</div>
                        </div>
                    </a>
                </li>

                {{-- Cambiar contraseña (va al mismo perfil, sección password) --}}
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.index') }}#password">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(201,168,76,0.10);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-lock" style="color:#C9A84C;font-size:0.72rem;"></i>
                        </span>
                        <div>
                            <div style="font-size:0.83rem;font-weight:500;">Cambiar contraseña</div>
                            <div style="font-size:0.68rem;color:var(--pv-text-muted);">Actualizar credenciales</div>
                        </div>
                    </a>
                </li>

                {{-- Historial de actividad --}}
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('activityLog.index') }}">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(16,185,129,0.10);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-clock-rotate-left" style="color:#10B981;font-size:0.72rem;"></i>
                        </span>
                        <div>
                            <div style="font-size:0.83rem;font-weight:500;">Historial de actividad</div>
                            <div style="font-size:0.68rem;color:var(--pv-text-muted);">Acciones recientes</div>
                        </div>
                    </a>
                </li>

                {{-- Mis ventas del día --}}
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('ventas.index') }}">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(6,182,212,0.10);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-chart-line" style="color:#06B6D4;font-size:0.72rem;"></i>
                        </span>
                        <div>
                            <div style="font-size:0.83rem;font-weight:500;">Mis ventas del día</div>
                            <div style="font-size:0.68rem;color:var(--pv-text-muted);">Resumen de hoy</div>
                        </div>
                    </a>
                </li>

                <li><hr class="dropdown-divider my-1"></li>

                {{-- Admin: Usuarios --}}
                @can('administrador')
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('users.index') }}">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(99,102,241,0.10);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-users" style="color:#6366F1;font-size:0.72rem;"></i>
                        </span>
                        <div style="font-size:0.83rem;font-weight:500;">Administrar usuarios</div>
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                @endcan

                {{-- Cerrar sesión --}}
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span style="
                            width:26px;height:26px;border-radius:7px;
                            background:rgba(239,68,68,0.10);
                            display:flex;align-items:center;justify-content:center;flex-shrink:0;
                        ">
                            <i class="fas fa-right-from-bracket" style="color:#EF4444;font-size:0.72rem;"></i>
                        </span>
                        <div style="font-size:0.83rem;font-weight:500;color:#EF4444;">Cerrar sesión</div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display:none;"></form>
                </li>

            </ul>
        </li>

    </ul>
</nav>