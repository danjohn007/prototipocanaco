    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Cámara de Comercio de Querétaro</h5>
                    <p>Fortaleciendo el desarrollo empresarial de nuestra región desde 1947.</p>
                </div>
                <div class="col-md-3">
                    <h6>Enlaces</h6>
                    <ul class="list-unstyled">
                        <li><a href="/afiliacion" class="text-light">Afiliarse</a></li>
                        <li><a href="/admin/login" class="text-light">Acceso Admin</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Contacto</h6>
                    <p class="mb-1">
                        <i class="fas fa-envelope me-2"></i>
                        info@camaradecomercioqro.mx
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-phone me-2"></i>
                        (442) 123-4567
                    </p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; <?php echo date('Y'); ?> Cámara de Comercio de Querétaro. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>