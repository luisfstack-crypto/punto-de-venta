<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Alfa y Omega — Punto de Venta" />
    <meta name="author" content="Alfa y Omega" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alfa y Omega PV — @yield('title')</title>

    {{-- Favicon SVG inline (opcional: reemplazar con archivo real) --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'><circle cx='100' cy='100' r='88' stroke='%231B2D4F' stroke-width='7' fill='%230E1117'/><path d='M100 38L70 138M100 38L130 138M78 108L122 108' stroke='%232A4A7F' stroke-width='10' stroke-linecap='round' fill='none'/><path d='M68 148Q68 118 100 118Q132 118 132 148M68 148Q68 162 78 162L96 162M132 148Q132 162 122 162L104 162' stroke='%23C9A84C' stroke-width='8' stroke-linecap='round' fill='none'/></svg>">

    @stack('css-datatable')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/theme-custom.css') }}?v=1.1" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    @stack('css')
    @stack('styles')
</head>

{{-- El data-theme se aplica aquí; el script inline lo lee de localStorage ANTES del render --}}
<body class="sb-nav-fixed">

    {{-- ══ TOPNAV ══ --}}
    @include('layouts.include.navigation-header')

    <div id="layoutSidenav">

        {{-- ══ SIDEBAR ══ --}}
        @include('layouts.include.navigation-menu')

        <div id="layoutSidenav_content">

            @include('layouts.partials.alert')

            <main>
                @yield('content')
            </main>

            @include('layouts.include.footer')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    {{-- Notificaciones --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationIcon = document.getElementById('notificationsDropdown');
            if (!notificationIcon) return;
            notificationIcon.addEventListener('click', function () {
                fetch("{{ route('notifications.markAsRead') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({})
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const badge = notificationIcon.querySelector('.badge');
                        if (badge) badge.remove();
                    }
                })
                .catch(err => console.error('Error notificaciones:', err));
            });
        });
    </script>

    {{-- Dark/Light Mode — aplicar ANTES de render para evitar flash --}}
    <script>
        (function () {
            const saved = localStorage.getItem('pv-theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    @stack('js')

    {{-- Toggle Dark/Light --}}
    <script>
        const toggleBtn  = document.getElementById('themeToggleBtn');
        const themeIcon  = document.getElementById('themeIcon');
        const themeLabel = document.getElementById('themeLabel');

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('pv-theme', theme);
            if (themeIcon && themeLabel) {
                if (theme === 'dark') {
                    themeIcon.className   = 'fas fa-sun';
                    themeLabel.textContent = 'Claro';
                } else {
                    themeIcon.className   = 'fas fa-moon';
                    themeLabel.textContent = 'Oscuro';
                }
            }
        }

        // Sincronizar ícono al cargar
        applyTheme(localStorage.getItem('pv-theme') || 'light');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                const current = document.documentElement.getAttribute('data-theme');
                applyTheme(current === 'dark' ? 'light' : 'dark');
            });
        }
    </script>

    @stack('scripts')
</body>
</html>