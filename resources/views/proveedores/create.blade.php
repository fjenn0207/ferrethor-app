<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Proveedor - FERRETHOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --ferre-naranja: #f26522;
            --ferre-naranja-dark: #d5521b;
            --ferre-negro: #212529;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-ferre {
            background-color: var(--ferre-negro);
            border-bottom: 4px solid var(--ferre-naranja);
        }
        .btn-ferre-primary {
            background-color: var(--ferre-naranja);
            color: white;
            font-weight: 600;
            border: none;
        }
        .btn-ferre-primary:hover {
            background-color: var(--ferre-naranja-dark);
            color: white;
        }
        .card-header-ferre {
            background-color: var(--ferre-negro);
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación Estilo Ferrethor -->
    <nav class="navbar navbar-dark navbar-ferre shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('proveedores.index') }}">
                <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR" style="max-height: 45px; width: auto;">
            </a>
            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver al Listado
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow border-0 rounded-3">
                    <div class="card-header card-header-ferre py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-truck-field me-2"></i> Registrar Nuevo Proveedor</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('proveedores.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del Proveedor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-store text-secondary"></i></span>
                                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Construblock, Dicofer..." required value="{{ old('nombre') }}">
                                </div>
                            </div>

                            <!-- Selector rápido: Pago Inmediato o Crédito -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Condición de Pago</label>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="tipo_pago" id="pagoInmediato" autocomplete="off" checked onchange="toggleDiasCredito(0)">
                                        <label class="btn btn-outline-dark w-100 py-2 text-start border-secondary" for="pagoInmediato">
                                            <i class="fa-solid fa-bolt text-warning me-2"></i> Pago Inmediato
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="tipo_pago" id="pagoCredito" autocomplete="off" onchange="toggleDiasCredito(30)">
                                        <label class="btn btn-outline-dark w-100 py-2 text-start border-secondary" for="pagoCredito">
                                            <i class="fa-solid fa-calendar-days text-warning me-2"></i> Con Crédito
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Días de Crédito</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-calendar-days text-secondary"></i></span>
                                    <input type="number" id="dias_credito" name="dias_credito" class="form-control" value="{{ old('dias_credito', 0) }}" min="0" required>
                                </div>
                                <div class="form-text text-muted">0 días para pago inmediato o especifica los días acordados (ej. 30, 60).</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                                <button type="submit" class="btn btn-ferre-primary px-4">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Proveedor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script para alternar el comportamiento del campo de días de crédito -->
    <script>
        function toggleDiasCredito(diasDefault) {
            const inputDias = document.getElementById('dias_credito');
            if (diasDefault === 0) {
                inputDias.value = 0;
                inputDias.readOnly = true;
            } else {
                inputDias.readOnly = false;
                if (inputDias.value == 0) {
                    inputDias.value = diasDefault;
                }
                inputDias.focus();
            }
        }

        // Estado inicial al cargar la vista
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('dias_credito').readOnly = true;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>