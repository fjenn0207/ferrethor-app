<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - FERRETHOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --ferre-naranja: #f26522;
            --ferre-naranja-glow: rgba(242, 101, 34, 0.4);
            --ferre-oscuro: #0f1015;
            --ferre-card-bg: rgba(26, 28, 36, 0.75);
        }
        body {
            /* Fondo tecnológico e industrial con profundidad geométrica */
            background-color: var(--ferre-oscuro);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(242, 101, 34, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(30, 144, 255, 0.05) 0%, transparent 40%),
                linear-gradient(135deg, #0f1015 0%, #1a1c24 100%);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        /* Contenedor principal con efecto de cristal avanzado */
        .welcome-card {
            background: var(--ferre-card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 28px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(242, 101, 34, 0.1);
            max-width: 600px;
            width: 100%;
            position: relative;
            animation: fadeIn 1s ease-out;
        }

        /* Línea superior brillante decorativa */
        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20%;
            right: 20%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--ferre-naranja), transparent);
            border-radius: 3px;
        }

        /* Zona del Logo con destello icónico */
        .logo-box {
            position: relative;
            margin-bottom: 30px;
            display: inline-block;
            padding: 15px 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);
        }
        
        .welcome-logo {
            max-width: 300px;
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.2));
            transition: transform 0.4s ease;
        }

        .welcome-logo:hover {
            transform: scale(1.03);
        }

        .badge-system {
            background: rgba(242, 101, 34, 0.15);
            color: #f8945c;
            border: 1px solid rgba(242, 101, 34, 0.3);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 35px;
        }

        /* Botones ultra llamativos con efectos dinámicos */
        .btn-ferre-glow {
            background: linear-gradient(135deg, #f26522 0%, #d5521b 100%);
            color: white;
            font-weight: 700;
            padding: 15px 32px;
            border-radius: 14px;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px var(--ferre-naranja-glow);
            letter-spacing: 0.5px;
        }

        .btn-ferre-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(242, 101, 34, 0.6);
            color: white;
        }

        .btn-ferre-glass {
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-weight: 600;
            padding: 15px 28px;
            border-radius: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-ferre-glass:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 d-flex justify-content-center">
                <div class="welcome-card">
                    
                    <!-- Contenedor del logotipo -->
                    <div class="logo-box">
                        <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR" class="welcome-logo">
                    </div>

                    <div>
                        <span class="badge-system">
                            <i class="fa-solid fa-shield-halved me-1"></i> Control Inteligente de Cuentas por Pagar
                        </span>
                    </div>

                    <!-- Botones de Acción Principal -->
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('facturas.index') }}" class="btn-ferre-glow">
                            <i class="fa-solid fa-file-invoice-dollar me-2 fs-5"></i> Entrar al Sistema
                        </a>
                        <a href="{{ route('proveedores.index') }}" class="btn-ferre-glass">
                            <i class="fa-solid fa-store me-2 fs-5"></i> Proveedores
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>