<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Punto de Venta - Registrarse</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/theme-custom.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #0F0F11 !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #layoutAuthentication {
            display: flex; flex-direction: column; min-height: 100vh;
        }
        #layoutAuthentication_content {
            flex: 1; display: flex; align-items: center;
        }
        .login-wrapper { width: 100%; padding: 2.5rem 0; }

        .login-card {
            border: 1px solid #2C2C30 !important;
            border-radius: 0.65rem !important;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.7) !important;
        }
        .login-card .card-header {
            background-color: #111113 !important;
            padding: 2rem 2rem 1.5rem !important;
            text-align: center;
            border-bottom: 1px solid #2C2C30 !important;
        }
        .login-card .card-header .brand-logo {
            width: 52px; height: 52px;
            background-color: #1E1E21;
            border: 1px solid #3A3A3F;
            border-radius: 0.5rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.85rem;
            font-size: 1.4rem; color: #4A8BDF;
        }
        .login-card .card-header h3 {
            color: #E5E5E7 !important;
            font-weight: 700 !important;
            font-size: 1.15rem !important;
            margin: 0 0 0.2rem !important;
        }
        .login-card .card-header p {
            color: #5A5A60 !important;
            font-size: 0.8rem !important;
            margin: 0 !important;
        }
        .login-card .card-body {
            background-color: #1E1E21 !important;
            padding: 1.75rem !important;
        }
        .login-card .form-floating label { color: #5A5A60 !important; }
        .login-card .form-control {
            background-color: #111113 !important;
            border: 1px solid #3A3A3F !important;
            color: #E5E5E7 !important;
            border-radius: 0.4rem !important;
        }
        .login-card .form-control:focus {
            border-color: #4A8BDF !important;
            box-shadow: 0 0 0 2px rgba(74,139,223,0.2) !important;
            background-color: #111113 !important;
        }
        .login-card .btn-login {
            width: 100%;
            background-color: #4A8BDF !important;
            border: 1px solid #4A8BDF !important;
            border-radius: 0.4rem !important;
            padding: 0.7rem !important;
            font-weight: 600 !important;
            font-size: 0.88rem !important;
            color: #fff !important;
            transition: background-color 0.2s ease !important;
        }
        .login-card .btn-login:hover { background-color: #3570BF !important; border-color: #3570BF !important; }
        .login-card .btn-login a { color: #fff !important; text-decoration: none !important; }

        .login-footer { background: transparent !important; border: none !important; }
        .login-footer .text-muted, .login-footer a { color: #3A3A3F !important; }
    </style>
</head>

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <div class="login-wrapper">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8">
                            <div class="card login-card">
                                <div class="card-header">
                                    <div class="brand-logo">
                                        <i class="fas fa-cash-register"></i>
                                    </div>
                                    <h3>Punto de Venta</h3>
                                    <p>Regístrate y sube tu comprobante para acceder</p>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        @foreach ($errors->all() as $item)
                                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $item }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endforeach
                                    @endif

                                    <form action="{{ route('register.register') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input autofocus autocomplete="off"
                                                class="form-control"
                                                name="name"
                                                value="{{ old('name') }}"
                                                id="inputName"
                                                type="text"
                                                placeholder="Nombre de usuario" />
                                            <label for="inputName">Nombre</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input autocomplete="off"
                                                class="form-control"
                                                name="email"
                                                value="{{ old('email') }}"
                                                id="inputEmail"
                                                type="email"
                                                placeholder="correo@ejemplo.com" />
                                            <label for="inputEmail">Correo electrónico</label>
                                        </div>
                                        
                                        <div class="form-floating mb-3">
                                            <input class="form-control"
                                                name="password"
                                                id="inputPassword"
                                                type="password"
                                                placeholder="Contraseña" />
                                            <label for="inputPassword">Contraseña</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control"
                                                name="password_confirmation"
                                                id="inputPasswordConfirm"
                                                type="password"
                                                placeholder="Confirmar Contraseña" />
                                            <label for="inputPasswordConfirm">Confirmar Contraseña</label>
                                        </div>

                                        <div class="mb-4">
                                            <label for="receipt" class="form-label" style="color: #5A5A60;">Comprobante de pago o Identidad (PDF/Imagen)</label>
                                            <input class="form-control" type="file" id="receipt" name="payment_receipt" accept=".pdf,.jpg,.jpeg,.png">
                                        </div>

                                        <button class="btn btn-login mb-3" type="submit">
                                            <i class="fas fa-user-plus me-2"></i> Registrarse
                                        </button>

                                        <div class="text-center">
                                            <a href="{{ route('login.index') }}" class="text-muted text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="layoutAuthentication_footer">
            <footer class="py-3 login-footer text-center">
                <span class="text-muted" style="font-size:0.75rem;">
                    &copy; {{ date('Y') }} Punto de Venta
                </span>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>
