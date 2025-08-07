<?php
$title = 'Detalle de Afiliación - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid my-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Detalle de Afiliación #<?php echo $afiliacion['id']; ?></h1>
                    <p class="text-muted"><?php echo htmlspecialchars($afiliacion['empresa']); ?></p>
                </div>
                <div>
                    <a href="/admin/afiliaciones" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver a la Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Affiliation Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información de la Afiliación</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Empresa:</strong><br>
                            <?php echo htmlspecialchars($afiliacion['empresa']); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Persona de Contacto:</strong><br>
                            <?php echo htmlspecialchars($afiliacion['contacto']); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <a href="mailto:<?php echo htmlspecialchars($afiliacion['usuario_email']); ?>">
                                <?php echo htmlspecialchars($afiliacion['usuario_email']); ?>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <strong>Teléfono:</strong><br>
                            <a href="tel:<?php echo htmlspecialchars($afiliacion['telefono']); ?>">
                                <?php echo htmlspecialchars($afiliacion['telefono']); ?>
                            </a>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Sector:</strong><br>
                            <span class="badge bg-info">
                                <?php echo htmlspecialchars($afiliacion['sector_nombre']); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Membresía:</strong><br>
                            <span class="badge bg-primary">
                                <?php echo htmlspecialchars($afiliacion['membresia_nombre']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Dirección:</strong><br>
                        <?php echo nl2br(htmlspecialchars($afiliacion['direccion'])); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Fecha de Solicitud:</strong><br>
                            <?php echo date('d/m/Y H:i', strtotime($afiliacion['fecha_solicitud'])); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Validación:</strong><br>
                            <?php 
                            if ($afiliacion['fecha_validacion']) {
                                echo date('d/m/Y H:i', strtotime($afiliacion['fecha_validacion']));
                            } else {
                                echo '<span class="text-muted">No validada</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <?php if (!empty($afiliacion['productos'])): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Productos Estrella (<?php echo count($afiliacion['productos']); ?>)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($afiliacion['productos'] as $producto): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php if ($producto['imagen']): ?>
                                                <img src="/uploads/productos/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                                     class="img-fluid mb-2 image-preview" 
                                                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                            <?php endif; ?>
                                            <h6 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h6>
                                            <p class="card-text text-muted small">
                                                <?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Status and Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estatus y Acciones</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Estatus Actual:</strong><br>
                        <?php
                        $badge_class = '';
                        switch ($afiliacion['estatus']) {
                            case 'pendiente': $badge_class = 'warning'; break;
                            case 'en_proceso': $badge_class = 'info'; break;
                            case 'validada': $badge_class = 'success'; break;
                            case 'rechazada': $badge_class = 'danger'; break;
                        }
                        ?>
                        <span class="badge bg-<?php echo $badge_class; ?> fs-6">
                            <?php echo ucfirst(str_replace('_', ' ', $afiliacion['estatus'])); ?>
                        </span>
                    </div>

                    <?php if ($afiliacion['comentarios']): ?>
                        <div class="mb-3">
                            <strong>Comentarios:</strong><br>
                            <div class="alert alert-info">
                                <?php echo nl2br(htmlspecialchars($afiliacion['comentarios'])); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Status Update Form -->
                    <form action="/admin/afiliacion/actualizar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $afiliacion['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="estatus" class="form-label">Cambiar Estatus:</label>
                            <select class="form-control" id="estatus" name="estatus" required>
                                <option value="">Seleccionar...</option>
                                <option value="pendiente" <?php echo $afiliacion['estatus'] === 'pendiente' ? 'selected' : ''; ?>>
                                    Pendiente
                                </option>
                                <option value="en_proceso" <?php echo $afiliacion['estatus'] === 'en_proceso' ? 'selected' : ''; ?>>
                                    En Proceso
                                </option>
                                <option value="validada" <?php echo $afiliacion['estatus'] === 'validada' ? 'selected' : ''; ?>>
                                    Validada
                                </option>
                                <option value="rechazada" <?php echo $afiliacion['estatus'] === 'rechazada' ? 'selected' : ''; ?>>
                                    Rechazada
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <textarea class="form-control" id="comentarios" name="comentarios" rows="3" 
                                      placeholder="Agregar comentarios sobre la validación..."><?php echo htmlspecialchars($afiliacion['comentarios'] ?? ''); ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Actualizar Estatus
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información Adicional</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Solicitante:</strong><br>
                        <?php echo htmlspecialchars($afiliacion['usuario_nombre']); ?>
                    </div>
                    
                    <?php if ($afiliacion['validado_por']): ?>
                        <div class="mb-2">
                            <strong>Validado por:</strong><br>
                            Usuario ID: <?php echo $afiliacion['validado_por']; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-2">
                        <strong>Productos registrados:</strong><br>
                        <?php echo count($afiliacion['productos']); ?> producto(s)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-preview {
    max-width: 100%;
    max-height: 150px;
    object-fit: cover;
    border-radius: 0.5rem;
}
</style>

<?php include __DIR__ . '/../partials/footer.php'; ?>