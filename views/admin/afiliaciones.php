<?php
$title = 'Gestión de Afiliaciones - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid my-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Gestión de Afiliaciones</h1>
                    <p class="text-muted">Administra las solicitudes de afiliación</p>
                </div>
                <div>
                    <a href="/admin/dashboard" class="btn btn-outline-primary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Dashboard
                    </a>
                    <a href="/admin/exportar" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>
                        Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="estatus" class="form-label">Filtrar por Estatus</label>
                            <select class="form-control" id="estatus" name="estatus">
                                <option value="">Todos los estatus</option>
                                <option value="pendiente" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] === 'pendiente') ? 'selected' : ''; ?>>
                                    Pendiente
                                </option>
                                <option value="en_proceso" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] === 'en_proceso') ? 'selected' : ''; ?>>
                                    En Proceso
                                </option>
                                <option value="validada" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] === 'validada') ? 'selected' : ''; ?>>
                                    Validada
                                </option>
                                <option value="rechazada" <?php echo (isset($_GET['estatus']) && $_GET['estatus'] === 'rechazada') ? 'selected' : ''; ?>>
                                    Rechazada
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sector" class="form-label">Filtrar por Sector</label>
                            <select class="form-control" id="sector" name="sector">
                                <option value="">Todos los sectores</option>
                                <?php foreach ($sectores as $sector): ?>
                                    <option value="<?php echo $sector['id']; ?>" 
                                            <?php echo (isset($_GET['sector']) && $_GET['sector'] == $sector['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($sector['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>
                                    Aplicar Filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Affiliations Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Lista de Afiliaciones (<?php echo count($afiliaciones); ?> registros)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="afiliacionesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Empresa</th>
                                    <th>Contacto</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Sector</th>
                                    <th>Membresía</th>
                                    <th>Estatus</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($afiliaciones)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            No se encontraron afiliaciones con los filtros aplicados
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($afiliaciones as $afiliacion): ?>
                                        <tr>
                                            <td><?php echo $afiliacion['id']; ?></td>
                                            <td><?php echo htmlspecialchars($afiliacion['empresa']); ?></td>
                                            <td><?php echo htmlspecialchars($afiliacion['contacto']); ?></td>
                                            <td><?php echo htmlspecialchars($afiliacion['usuario_email']); ?></td>
                                            <td><?php echo htmlspecialchars($afiliacion['telefono']); ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo htmlspecialchars($afiliacion['sector_nombre']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($afiliacion['membresia_nombre']); ?></td>
                                            <td>
                                                <?php
                                                $badge_class = '';
                                                switch ($afiliacion['estatus']) {
                                                    case 'pendiente': $badge_class = 'warning'; break;
                                                    case 'en_proceso': $badge_class = 'info'; break;
                                                    case 'validada': $badge_class = 'success'; break;
                                                    case 'rechazada': $badge_class = 'danger'; break;
                                                }
                                                ?>
                                                <span class="badge bg-<?php echo $badge_class; ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $afiliacion['estatus'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($afiliacion['fecha_solicitud'])); ?></td>
                                            <td>
                                                <a href="/admin/afiliacion/<?php echo $afiliacion['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced table functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add search functionality
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.className = 'form-control mb-3';
    searchInput.placeholder = 'Buscar en la tabla...';
    
    const tableContainer = document.querySelector('.table-responsive');
    tableContainer.parentNode.insertBefore(searchInput, tableContainer);
    
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#afiliacionesTable tbody tr');
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>