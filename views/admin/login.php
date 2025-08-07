<?php
$title = 'Acceso Administrativo - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Acceso Administrativo
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo Config::url('admin/login'); ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="admin@camaradecomercioqro.mx" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted text-center small">
                    <i class="fas fa-info-circle me-1"></i>
                    Solo personal autorizado
                </div>
            </div>
            
            <!-- Demo Credentials -->
            <div class="mt-4">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-key me-2"></i>
                            Credenciales Demo
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Administrador:</strong></p>
                        <p class="small mb-1">Email: admin@camaradecomercioqro.mx</p>
                        <p class="small mb-3">Contraseña: admin123</p>
                        
                        <p class="mb-2"><strong>Validador:</strong></p>
                        <p class="small mb-1">Email: validador@camaradecomercioqro.mx</p>
                        <p class="small mb-0">Contraseña: admin123</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>