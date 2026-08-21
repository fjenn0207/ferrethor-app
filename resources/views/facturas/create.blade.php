<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Factura - FERRETHOR</title>
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

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-dark navbar-ferre shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fa-solid fa-hammer text-warning me-2 fs-3"></i>
                <div>
                    <span class="fs-4 fw-bold tracking-wide">FERRETHOR</span>
                    <span class="d-block text-muted" style="font-size: 0.75rem;">CONTROL DE CUENTAS POR PAGAR</span>
                </div>
            </a>
            <div>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header card-header-ferre py-3">
                        <h5 class="mb-0"><i class="fa-solid fa-file-circle-plus me-2"></i> Registrar Nueva Factura</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Mensajes de Error de Validación -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('facturas.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Folio de la Factura</label>
                                <input type="text" name="folio_factura" class="form-control" required placeholder="Ej. F-98765" value="{{ old('folio_factura') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Proveedor</label>
                                <div class="input-group">
                                    <!-- Selector único de proveedores para evitar duplicados -->
                                    <select name="proveedor_id" class="form-select" required>
                                        <option value="" selected disabled>-- Selecciona un proveedor registrado --</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('proveedores.create') }}" class="btn btn-outline-secondary" title="Dar de alta nuevo proveedor">
                                        <i class="fa-solid fa-plus"></i> Nuevo
                                    </a>
                                </div>
                                <div class="form-text">Si el proveedor no aparece en la lista, puedes agregarlo con el botón "Nuevo".</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de Expedición</label>
                                    <input type="date" name="fecha_expedicion" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de Vencimiento</label>
                                    <input type="date" name="fecha_vencimiento" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Monto Total ($)</label>
                                <input type="number" step="0.01" name="monto" class="form-control" required placeholder="0.00" value="{{ old('monto') }}">
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('facturas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                                <button type="submit" class="btn btn-ferre-primary">Guardar Factura</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>