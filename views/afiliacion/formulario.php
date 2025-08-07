<?php
$title = 'Formulario de Afiliación - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold">Únete a la Cámara de Comercio</h1>
                <p class="lead">Forma parte de la comunidad empresarial más importante de Querétaro</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Formulario de Afiliación
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo Config::url('afiliacion'); ?>" method="POST" enctype="multipart/form-data">
                        
                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Información Personal</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre Completo <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <!-- Company Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Información de la Empresa</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="empresa" class="form-label">Nombre de la Empresa <span class="required">*</span></label>
                                <input type="text" class="form-control" id="empresa" name="empresa" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contacto" class="form-label">Persona de Contacto <span class="required">*</span></label>
                                <input type="text" class="form-control" id="contacto" name="contacto" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="sector_id" class="form-label">Sector <span class="required">*</span></label>
                                <select class="form-control" id="sector_id" name="sector_id" required>
                                    <option value="">Seleccionar sector...</option>
                                    <?php foreach ($sectores as $sector): ?>
                                        <option value="<?php echo $sector['id']; ?>">
                                            <?php echo htmlspecialchars($sector['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección Completa <span class="required">*</span></label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="3" required></textarea>
                        </div>

                        <!-- Membership Selection -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Selección de Membresía</h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <?php foreach ($membresias as $membresia): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="membresia_id" 
                                                       id="membresia_<?php echo $membresia['id']; ?>" 
                                                       value="<?php echo $membresia['id']; ?>" required>
                                                <label class="form-check-label w-100" for="membresia_<?php echo $membresia['id']; ?>">
                                                    <h6 class="card-title"><?php echo htmlspecialchars($membresia['nombre']); ?></h6>
                                                    <p class="card-text text-muted"><?php echo htmlspecialchars($membresia['descripcion']); ?></p>
                                                    <h5 class="text-success">$<?php echo number_format($membresia['costo'], 2); ?></h5>
                                                    <small class="text-muted"><?php echo htmlspecialchars($membresia['beneficios']); ?></small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Star Products -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Productos Estrella (Máximo 5)</h5>
                                <p class="text-muted">Sube información de tus productos o servicios más destacados</p>
                            </div>
                        </div>

                        <div id="productos-container">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Producto <?php echo $i; ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="producto_nombre_<?php echo $i; ?>" class="form-label">Nombre del Producto</label>
                                                <input type="text" class="form-control" id="producto_nombre_<?php echo $i; ?>" 
                                                       name="producto_nombre_<?php echo $i; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="producto_imagen_<?php echo $i; ?>" class="form-label">Imagen</label>
                                                <input type="file" class="form-control" id="producto_imagen_<?php echo $i; ?>" 
                                                       name="producto_imagen_<?php echo $i; ?>" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="producto_descripcion_<?php echo $i; ?>" class="form-label">Descripción</label>
                                            <textarea class="form-control" id="producto_descripcion_<?php echo $i; ?>" 
                                                      name="producto_descripcion_<?php echo $i; ?>" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Enviar Solicitud de Afiliación
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation and image preview
document.addEventListener('DOMContentLoaded', function() {
    // Add image preview functionality
    for (let i = 1; i <= 5; i++) {
        const imageInput = document.getElementById(`producto_imagen_${i}`);
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('La imagen es muy grande. Máximo 5MB.');
                        e.target.value = '';
                        return;
                    }
                    
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Por favor selecciona una imagen válida.');
                        e.target.value = '';
                        return;
                    }
                }
            });
        }
    }
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>