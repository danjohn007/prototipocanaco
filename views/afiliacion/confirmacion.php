<?php
$title = 'Confirmación - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h1 class="h2 text-success mb-3">¡Solicitud Enviada Exitosamente!</h1>
                    
                    <p class="lead mb-4">
                        Tu solicitud de afiliación ha sido recibida correctamente. 
                        Nuestro equipo la revisará y nos pondremos en contacto contigo pronto.
                    </p>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>¿Qué sigue?</h6>
                        <ul class="list-unstyled mb-0 text-start">
                            <li>✓ Revisión de tu solicitud (1-3 días hábiles)</li>
                            <li>✓ Validación de documentos y productos</li>
                            <li>✓ Contacto telefónico para confirmar datos</li>
                            <li>✓ Asignación de beneficios según membresía</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="/afiliacion" class="btn btn-primary me-3">
                            <i class="fas fa-plus me-2"></i>
                            Nueva Solicitud
                        </a>
                        <a href="/" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>
                            Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>