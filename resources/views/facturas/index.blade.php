<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuentas por Pagar - FERRETHOR</title>
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

    <!-- Barra de Navegación Estilo Ferrethor -->
    <nav class="navbar navbar-dark navbar-ferre shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/ferrethor-logo.png') }}" alt="FERRETHOR">
            </a>
            <div>
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fa-solid fa-store me-1"></i> Ver Proveedores
                </a>
                <a href="{{ route('proveedores.create') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fa-solid fa-truck-field me-1"></i> + Nuevo Proveedor
                </a>
                <a href="{{ route('facturas.create') }}" class="btn btn-ferre-primary btn-sm">
                    <i class="fa-solid fa-file-circle-plus me-1"></i> + Nueva Factura
                </a>
                <a href="{{ route('facturas.historial') }}" class="btn btn-outline-warning btn-sm me-2">
                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Historial
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><strong>¡Atención!</strong> Revisa los campos del formulario.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tarjeta Principal de la Tabla -->
        <div class="card shadow border-0 rounded-3">
            <div class="card-header card-header-ferre d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="fa-solid fa-clipboard-list me-2"></i> Listado General de Facturas</h5>
                
                <!-- Buscador por Folio -->
                <form action="{{ route('facturas.index') }}" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por folio..." value="{{ request('search') }}">
                        <button class="btn btn-warning text-dark fw-bold" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('facturas.index') }}" class="btn btn-outline-light" title="Limpiar búsqueda">
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
                                <th>Vencimiento</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Alerta / Aviso</th>
                                <th class="text-center pe-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($facturas as $factura)
                                @php
                                    $vencimiento = \Carbon\Carbon::parse($factura->fecha_vencimiento);
                                    $diasRestantes = $hoy->diffInDays($vencimiento, false);
                                @endphp
                                <tr>
                                    <td class="ps-3"><strong>{{ $factura->folio_factura }}</strong></td>
                                    <td>
                                        <i class="fa-solid fa-store text-secondary me-1"></i>
                                        {{ $factura->proveedor->nombre ?? 'Sin proveedor' }}
                                    </td>
                                    <td>{{ $factura->fecha_expedicion }}</td>
                                    <td>{{ $factura->fecha_vencimiento }}</td>
                                    <td><strong class="text-success">${{ number_format($factura->monto, 2) }}</strong></td>
                                    <td>
                                        @if($factura->pagado)
                                            <span class="badge bg-success">Pagado</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$factura->pagado)
                                            @if($diasRestantes < 0)
                                                <span class="badge bg-dark"><i class="fa-solid fa-triangle-exclamation me-1"></i> Vencida</span>
                                            @elseif($diasRestantes <= 2)
                                                <span class="badge bg-danger"><i class="fa-solid fa-clock me-1"></i> Faltan {{ $diasRestantes }} día(s)</span>
                                            @else
                                                <span class="badge bg-info text-dark">A tiempo ({{ $diasRestantes }} días)</span>
                                            @endif
                                        @else
                                            <span class="text-muted"><i class="fa-solid fa-check me-1"></i> Liquidada</span>
                                        @endif
                                    </td>
                                    <td class="text-center pe-3">
                                        @if(!$factura->pagado)
                                            <!-- Botón para abrir el Modal de Subir Comprobante/Captura de Transferencia -->
                                            <button type="button" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#modalPagar{{ $factura->id }}" title="Marcar como Pagado con Captura">
                                                <i class="fa-solid fa-check-to-slot"></i>
                                            </button>
                                        @endif

                                        @if($factura->complemento_recibido)
                                            <!-- Botón interactivo CP OK para visualizar detalles y su imagen guardada -->
                                            <button type="button" class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#modalVerComplemento{{ $factura->id }}" title="Ver Complemento y Comprobante">
                                                <i class="fa-solid fa-file-invoice-dollar me-1"></i> CP OK
                                            </button>
                                        @else
                                            <!-- Botón para registrar el complemento (con la imagen ya guardada y campo para PDF) -->
                                            <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modalComplemento{{ $factura->id }}" title="Registrar Complemento de Pago">
                                                <i class="fa-solid fa-envelope-circle-check"></i>
                                            </button>
                                        @endif

                                        <!-- Formulario de Eliminación Independiente -->
                                        <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de enviar al historial la factura {{ $factura->folio_factura }}?');" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Enviar al Historial">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- MODALES FUERA DE LA TABLA -->

                                <!-- 1. Modal para Marcar como Pagado (SOLO SUBIR IMAGEN DE TRANSFERENCIA) -->
                                @if(!$factura->pagado)
                                <div class="modal fade text-start" id="modalPagar{{ $factura->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('facturas.complemento', $factura->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fs-6"><i class="fa-solid fa-image me-2"></i> Subir Captura de Transferencia: {{ $factura->folio_factura }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Captura de la Transferencia (Imagen)</label>
                                                        <input type="file" name="foto_pago" class="form-control" accept="image/*" required>
                                                        <div class="form-text">Sube la foto o captura del comprobante bancario. Esto marcará la factura como pagada.</div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-ferre-primary btn-sm">Guardar Comprobante</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- 2. Modal para Ver Complemento (Con opción para adjuntar el PDF faltante si no se subió antes) -->
                                @if($factura->complemento_recibido)
                                <div class="modal fade text-start" id="modalVerComplemento{{ $factura->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
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
                                                            <span class="text-muted d-block small fw-bold">Folio Complemento</span>
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

                                                <!-- Bloque inferior: Archivos Adjuntos (Imagen y PDF o Formulario para subir PDF faltante) -->
                                                <div class="row g-3">
                                                    @if($factura->foto_pago)
                                                    <div class="col-md-6">
                                                        <div class="bg-white p-3 rounded shadow-sm border text-center h-100 d-flex flex-column justify-content-between">
                                                            <span class="text-muted small fw-bold mb-2 d-block"><i class="fa-solid fa-receipt me-1"></i> Captura de Transferencia</span>
                                                            <div class="my-auto">
                                                                <a href="{{ asset('storage/' . $factura->foto_pago) }}" target="_blank">
                                                                    <img src="{{ asset('storage/' . $factura->foto_pago) }}" alt="Comprobante de Pago" class="img-thumbnail rounded shadow-sm" style="max-height: 120px; object-fit: contain;">
                                                                </a>
                                                            </div>
                                                            <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Haz clic para ampliar</small>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-md-6">
                                                        <div class="bg-white p-3 rounded shadow-sm border text-center h-100 d-flex flex-column justify-content-between">
                                                            <span class="text-muted small fw-bold mb-2 d-block"><i class="fa-solid fa-file-pdf me-1"></i> Archivo PDF del Complemento</span>
                                                            
                                                            @if($factura->pdf_complemento)
                                                                <!-- Si ya tiene PDF, muestra el botón para verlo -->
                                                                <div class="my-auto py-2">
                                                                    <a href="{{ asset('storage/' . $factura->pdf_complemento) }}" target="_blank" class="btn btn-outline-danger btn-sm w-100 py-3">
                                                                        <i class="fa-solid fa-file-pdf fs-3 d-block mb-1"></i> Ver PDF Guardado
                                                                    </a>
                                                                </div>
                                                                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Documento oficial</small>
                                                            @else
                                                                <!-- Si NO tiene PDF, muestra un formulario rápido para subirlo en este momento -->
                                                                <form action="{{ route('facturas.complemento', $factura->id) }}" method="POST" enctype="multipart/form-data" class="my-auto">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <!-- Mantenemos los datos existentes para que la validación o el controlador no falle -->
                                                                    <input type="hidden" name="complemento_folio" value="{{ $factura->complemento_folio }}">
                                                                    <input type="hidden" name="complemento_fecha" value="{{ $factura->complemento_fecha }}">
                                                                    <input type="hidden" name="complemento_monto" value="{{ $factura->complemento_monto }}">

                                                                    <div class="mb-2">
                                                                        <input type="file" name="pdf_complemento" class="form-control form-control-sm" accept=".pdf" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-sm btn-ferre-primary w-100">
                                                                        <i class="fa-solid fa-upload me-1"></i> Subir PDF Faltante
                                                                    </button>
                                                                </form>
                                                                <small class="text-danger mt-1 d-block" style="font-size: 0.75rem;">Pendiente de adjuntar</small>
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
                                <!-- 3. Modal para Registrar Complemento (Muestra la imagen ya guardada y permite subir el PDF/datos finales) -->
                                <div class="modal fade text-start" id="modalComplemento{{ $factura->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('facturas.complemento', $factura->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fs-6"><i class="fa-solid fa-file-invoice me-2"></i> Registrar Complemento: {{ $factura->folio_factura }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Vista previa de la imagen de transferencia ya guardada -->
                                                    @if($factura->foto_pago)
                                                    <div class="mb-3 text-center bg-light p-2 rounded border">
                                                        <label class="form-label text-muted small fw-bold d-block mb-1">Captura de Transferencia (Ya Guardada)</label>
                                                        <img src="{{ asset('storage/' . $factura->foto_pago) }}" alt="Captura Guardada" class="img-thumbnail" style="max-height: 120px;">
                                                    </div>
                                                    @endif

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Folio del Complemento</label>
                                                        <input type="text" name="complemento_folio" class="form-control" required placeholder="Ej. CP-12345">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Fecha del Complemento</label>
                                                        <input type="date" name="complemento_fecha" class="form-control" required value="{{ date('Y-m-d') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Monto del Complemento ($)</label>
                                                        <input type="number" step="0.01" name="complemento_monto" class="form-control" required value="{{ $factura->monto }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Archivo PDF del Complemento</label>
                                                        <input type="file" name="pdf_complemento" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-ferre-primary btn-sm">Guardar Registro Completo</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fa-solid fa-folder-open fs-3"></i>
                                        <p class="mb-0 mt-2">No hay facturas registradas todavía.</p>
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