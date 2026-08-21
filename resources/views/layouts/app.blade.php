<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FERRETHOR - Cuentas por Pagar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --ferre-naranja: #f26522;
            --ferre-naranja-glow: rgba(242, 101, 34, 0.35);
            --ferre-oscuro: #0f1015;
            --ferre-card-bg: rgba(26, 28, 36, 0.85);
        }
        body {
            background-color: var(--ferre-oscuro);
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(242, 101, 34, 0.1) 0%, transparent 40%),
                linear-gradient(135deg, #0f1015 0%, #1a1c24 100%);
            color: #e2e8f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Navbar Icónico con Glassmorphism */
        .navbar-ferre {
            background: rgba(15, 16, 21, 0.9) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 2px solid rgba(242, 101, 34, 0.4);
            padding: 12px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .navbar-brand img {
            max-height: 42px;
            width: auto;
            filter: drop-shadow(0 0 8px rgba(255,255,255,0.2));
        }

        /* Tarjetas Estilo Industrial Moderno */
        .card-ferre {
            background: var(--ferre-card-bg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }
        .card-header-ferre {
            background: linear-gradient(135deg, #1a1c24 0%, #121319 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
            padding: 20px 25px;
        }

        /* Botones Icónicos */
        .btn-ferre-primary {
            background: linear-gradient(135deg, #f26522 0%, #d5521b 100%);
            color: white;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px var(--ferre-naranja-glow);
            transition: all 0.3s ease;
        }
        .btn-ferre-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(242, 101, 34, 0.6);
            color: white;
        }

        /* Tablas oscuras estilizadas */
        .table-ferre {
            color: #e2e8f0;
            margin-bottom: 0;
        }
        .table-ferre th {
            background-color: #161821;
            color: #f8945c;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-weight: 600;
            padding: 15px;
        }
        .table-ferre td {
            background-color: transparent;
            color: #cbd5e1;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 15px;
            vertical-align: middle;
        }
        .table-ferre tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.03);
            color: white;
        }

        /* Inputs y Modales personalizados */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: var(--ferre-naranja);
            color: white;
            box-shadow: 0 0 10px var(--ferre-naranja-glow);
        }
        .modal-content {
            background-color: #161821;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            border-radius: 16px;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación Global -->
    <nav class="navbar navbar-dark navbar-ferre sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('facturas.index') }}">
                <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR">
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light btn-sm px-3">
                    <i class="fa-solid fa-file-invoice-dollar me-1"></i> Facturas
                </a>
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light btn-sm px-3">
                    <i class="fa-solid fa-store me-1"></i> Proveedores
                </a>
                <a href="{{ route('facturas.create') }}" class="btn btn-ferre-primary btn-sm px-3">
                    <i class="fa-solid fa-file-circle-plus me-1"></i> + Nueva Factura
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Dinámico de las Vistas -->
    <main class="container pb-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>