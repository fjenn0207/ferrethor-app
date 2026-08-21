<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores - FERRETHOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --ferre-naranja: #f26522;
            --ferre-naranja-dark: #d5521b;
            --ferre-negro: #1a1c24;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-ferre {
            background-color: var(--ferre-negro);
            border-bottom: 4px solid var(--ferre-naranja);
            padding: 12px 0;
        }
        .navbar-brand img {
            max-height: 45px;
            width: auto;
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
                <!-- Logo Oficial Integrado -->
                <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR">
            </a>
            <div>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fa-solid fa-file-invoice-dollar me-1"></i> Ver Facturas
                </a>
                <a href="{{ route('proveedores.create') }}" class="btn btn-ferre-primary btn-sm">
                    <i class="fa-solid fa-truck-field me-1"></i> + Nuevo Proveedor
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabla de Proveedores -->
        <div class="card shadow border-0 rounded-3">
            <div class="card-header card-header-ferre d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="fa-solid fa-store me-2"></i> Listado General de Proveedores</h5>
                <span class="badge bg-warning text-dark px-3 py-2 fs-6">Control Activo</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Nombre del Proveedor</th>
                                <th>Días de Crédito Predeterminados</th>
                                <th class="text-center pe-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proveedores as $proveedor)
                                <tr>
                                    <td class="ps-3"><strong>#{{ $proveedor->id }}</strong></td>
                                    <td>
                                        <i class="fa-solid fa-truck text-secondary me-2"></i>
                                        {{ $proveedor->nombre }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $proveedor->dias_credito }} días</span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar al proveedor {{ $proveedor->nombre }}?');" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar Proveedor">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fa-solid fa-folder-open fs-3"></i>
                                        <p class="mb-0 mt-2">No hay proveedores registrados todavía.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>