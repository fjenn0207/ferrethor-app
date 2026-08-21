<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Facturas - FERRETHOR</title>
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
                <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR" style="max-height: 45px; width: auto;">
            </a>
            <div>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver al Listado Principal
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

        <!-- Tarjeta del Historial con Buscador Avanzado -->
        <div class="card shadow border-0 rounded-3">
            <div class="card-header card-header-ferre d-flex flex-wrap justify-content-between align-items-center py-3 gap-2">
                <h5 class="mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i> Facturas En Papelera / Historial</h5>
                
                <!-- Buscador por Folio, Proveedor o Fecha -->
                <form action="{{ route('facturas.historial') }}" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar folio, proveedor o fecha..." value="{{ request('search') }}" style="min-width: 250px;">
                        <button class="btn btn-warning text-dark fw-bold" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                        @if(request('search'))
                            <a href="{{ route('facturas.historial') }}" class="btn btn-outline-light" title="Limpiar búsqueda">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Folio</th>
                                <th>Proveedor</th>
                                <th>Expedición</th>
                                <th>Monto</th>
                                <th>Estado al Borrar</th>
                                <th>Complemento</th>
                                <th>Fecha de Eliminación</th>
                                <th class="text-center pe-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($facturas as $factura)
                                <tr>
                                    <td class="ps-3"><strong>{{ $factura->folio_factura }}</strong></td>
                                    <td>
                                        <i class="fa-solid fa-store text-secondary me-1"></i>
                                        {{ $factura->proveedor->nombre ?? 'Proveedor desconocido' }}
                                    </td>
                                    <td>{{ $factura->fecha_expedicion }}</td>
                                    <td><strong class="text-danger">${{ number_format($factura->monto, 2) }}</strong></td>
                                    <td>
                                        @if($factura->pagado)
                                            <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Pagado</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($factura->complemento_recibido)
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalVerComplementoHistorial{{ $factura->id }}" title="Ver Complemento">
                                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> CP: {{ $factura->complemento_folio }}
                                            </button>

                                            <!-- Modal Detalle Completo de Complemento en Historial -->
                                            <div class="modal fade text-start" id="modalVerComplementoHistorial{{ $factura->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content border-0 shadow-lg">
                                                        <div class="modal-header bg-dark text-white">
                                                            <h5 class="modal-title fs-6"><i class="fa-solid fa-eye me-2 text-warning"></i> Detalle de Complemento - {{ $factura->folio_factura }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body bg-light p-4">
                                                            
                                                            <!-- Bloque superior: Datos Generales -->
                                                            <div class="bg-white p-3 rounded shadow-sm border mb-3">
                                                                <div class="row text-center text-md-start">
                                                                    <div class="col-md-4 mb-3 mb-md-0 border-end">
                                                                        <span class="text-muted d-block small fw-bold">Folio del Complemento</span>
                                                                        <span class="fw-bold fs-6 text-dark">{{ $factura->complemento_folio }}</span>
                                                                    </div>
                                                                    <div class="col-md-4 mb-3 mb-md-0 border-end ps-md-3">
                                                                        <span class="text-muted d-block small fw-bold">Fecha de Emisión</span>
                                                                        <span class="fw-bold fs-6 text-dark">{{ $factura->complemento_fecha }}</span>
                                                                    </div>
                                                                    <div class="col-md-4 ps-md-3">
                                                                        <span class="text-muted d-block small fw-bold">Monto Comprobado</span>
                                                                        <span class="fw-bold fs-6 text-success">${{ number_format($factura->complemento_monto, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Bloque inferior: Imagen y PDF Adjuntos -->
                                                            <div class="row g-3">
                                                                @if($factura->foto_pago)
                                                                <div class="col-md-6">
                                                                    <div class="bg-white p-3 rounded shadow-sm border text-center h-100 d-flex flex-column justify-content-between">
                                                                        <span class="text-muted small fw-bold mb-2 d-block"><i class="fa-solid fa-receipt me-1"></i> Captura de Transferencia</span>
                                                                        <div class="my-auto">
                                                                            <a href="{{ asset('storage/' . $factura->foto_pago) }}" target="_blank">
                                                                                <img src="{{ asset('storage/' . $factura->foto_pago) }}" alt="Comprobante de Pago" class="img-thumbnail rounded shadow-sm" style="max-height: 140px; object-fit: contain;">
                                                                            </a>
                                                                        </div>
                                                                        <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Haz clic para ampliar</small>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                <div class="{{ $factura->foto_pago ? 'col-md-6' : 'col-12' }}">
                                                                    <div class="bg-white p-3 rounded shadow-sm border text-center h-100 d-flex flex-column justify-content-between">
                                                                        <span class="text-muted small fw-bold mb-2 d-block"><i class="fa-solid fa-file-pdf me-1"></i> Archivo PDF del Complemento</span>
                                                                        
                                                                        @if($factura->pdf_complemento)
                                                                            <div class="my-auto py-2">
                                                                                <a href="{{ asset('storage/' . $factura->pdf_complemento) }}" target="_blank" class="btn btn-outline-danger btn-sm w-100 py-3">
                                                                                    <i class="fa-solid fa-file-pdf fs-3 d-block mb-1"></i> Ver PDF Guardado
                                                                                </a>
                                                                            </div>
                                                                            <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Documento oficial</small>
                                                                        @else
                                                                            <div class="my-auto py-2 text-muted">
                                                                                <i class="fa-solid fa-triangle-exclamation text-warning fs-3 d-block mb-1"></i>
                                                                                <span class="small">Sin PDF adjunto</span>
                                                                            </div>
                                                                            <small class="text-danger mt-1 d-block" style="font-size: 0.75rem;">No se subió archivo</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer bg-white">
                                                            <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">Sin complemento</span>
                                        @endif
                                    </td>
                                    <td><span class="text-muted"><i class="fa-regular fa-calendar-xmark me-1"></i> {{ $factura->deleted_at }}</span></td>
                                    <td class="text-center pe-3">
                                        <!-- Botón para Restaurar -->
                                        <form action="{{ route('facturas.restaurar', $factura->id) }}" method="POST" onsubmit="return confirm('¿Restaurar esta factura?');" style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Restaurar">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                        </form>

                                        <!-- Botón para Eliminar Definitivamente -->
                                        <form action="{{ route('facturas.forceDelete', $factura->id) }}" method="POST" onsubmit="return confirm('¡ADVERTENCIA: Esta acción es irreversible! ¿Eliminar permanentemente?');" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Borrar permanentemente">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fa-solid fa-trash fs-3 mb-2"></i>
                                        <p class="mb-0 mt-2">No hay facturas en el historial de eliminados.</p>
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