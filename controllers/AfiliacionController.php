<?php
require_once __DIR__ . '/../config/demodata.php';
require_once __DIR__ . '/../config/config.php';

class AfiliacionController {
    private $demo_mode;
    private $usuario;
    private $afiliacion;
    private $sector;
    private $membresia;
    private $producto;
    private $auth;

    public function __construct() {
        // Check if database connection is available
        $this->demo_mode = !$this->isDatabaseAvailable();
        
        if (!$this->demo_mode) {
            require_once __DIR__ . '/../models/Usuario.php';
            require_once __DIR__ . '/../models/Afiliacion.php';
            require_once __DIR__ . '/../models/Sector.php';
            require_once __DIR__ . '/../models/Membresia.php';
            require_once __DIR__ . '/../models/Producto.php';
            require_once __DIR__ . '/AuthController.php';
            
            $this->usuario = new Usuario();
            $this->afiliacion = new Afiliacion();
            $this->sector = new Sector();
            $this->membresia = new Membresia();
            $this->producto = new Producto();
            $this->auth = new AuthController();
        }
    }

    private function isDatabaseAvailable() {
        try {
            require_once __DIR__ . '/../config/database.php';
            $database = new Database();
            $conn = $database->getConnection();
            return $conn !== null;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Show affiliation form
     */
    public function showForm() {
        if ($this->demo_mode) {
            $sectores = DemoData::getSectores();
            $membresias = DemoData::getMembresias();
        } else {
            $sectores = $this->sector->getAll();
            $membresias = $this->membresia->getAll();
            
            // Fallback to demo data if database queries return empty results
            if (empty($sectores)) {
                error_log("Sector data empty, falling back to demo data");
                $sectores = DemoData::getSectores();
            }
            if (empty($membresias)) {
                error_log("Membresia data empty, falling back to demo data");
                $membresias = DemoData::getMembresias();
            }
        }
        
        include __DIR__ . '/../views/afiliacion/formulario.php';
    }

    /**
     * Process affiliation form
     */
    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->demo_mode) {
                // In demo mode, just show success message
                $_SESSION['success'] = 'Solicitud de afiliación enviada correctamente (MODO DEMO). En el entorno real, esto se guardaría en la base de datos.';
                Config::redirect('afiliacion/confirmacion');
            }

            // Real processing code (original implementation)
            // Validate required fields
            $required_fields = ['nombre', 'email', 'empresa', 'contacto', 'telefono', 'direccion', 'sector_id', 'membresia_id'];
            $errors = [];

            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[] = "El campo $field es requerido";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                Config::redirect('afiliacion');
            }

            // Check if email already exists
            if ($this->usuario->emailExists($_POST['email'])) {
                $_SESSION['error'] = 'Este email ya está registrado';
                Config::redirect('afiliacion');
            }

            try {
                // Create user
                $this->usuario->nombre = $_POST['nombre'];
                $this->usuario->email = $_POST['email'];
                $this->usuario->contraseña = 'temp123'; // Temporary password
                $this->usuario->tipo_usuario = 'comerciante';

                if (!$this->usuario->create()) {
                    throw new Exception('Error al crear usuario');
                }

                // Create affiliation
                $this->afiliacion->usuario_id = $this->usuario->id;
                $this->afiliacion->empresa = $_POST['empresa'];
                $this->afiliacion->contacto = $_POST['contacto'];
                $this->afiliacion->telefono = $_POST['telefono'];
                $this->afiliacion->direccion = $_POST['direccion'];
                $this->afiliacion->sector_id = $_POST['sector_id'];
                $this->afiliacion->membresia_id = $_POST['membresia_id'];

                if (!$this->afiliacion->create()) {
                    throw new Exception('Error al crear afiliación');
                }

                // Process products
                $this->processProducts($this->afiliacion->id);

                $_SESSION['success'] = 'Solicitud de afiliación enviada correctamente. Nos pondremos en contacto contigo pronto.';
                Config::redirect('afiliacion/confirmacion');

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                Config::redirect('afiliacion');
            }
        }
    }

    /**
     * Process uploaded products
     */
    private function processProducts($afiliacion_id) {
        $upload_dir = __DIR__ . '/../public/uploads/productos/';
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        for ($i = 1; $i <= 5; $i++) {
            $nombre = $_POST["producto_nombre_$i"] ?? '';
            $descripcion = $_POST["producto_descripcion_$i"] ?? '';

            if (!empty($nombre)) {
                $imagen_nombre = null;

                // Handle image upload
                if (isset($_FILES["producto_imagen_$i"]) && $_FILES["producto_imagen_$i"]['error'] === UPLOAD_ERR_OK) {
                    $imagen_nombre = $this->uploadImage($_FILES["producto_imagen_$i"], $upload_dir);
                }

                // Create product
                $this->producto->afiliacion_id = $afiliacion_id;
                $this->producto->nombre = $nombre;
                $this->producto->descripcion = $descripcion;
                $this->producto->imagen = $imagen_nombre;
                $this->producto->create();
            }
        }
    }

    /**
     * Upload image file
     */
    private function uploadImage($file, $upload_dir) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Tipo de imagen no permitido');
        }

        if ($file['size'] > $max_size) {
            throw new Exception('La imagen es muy grande (máximo 5MB)');
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $destination = $upload_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }

        throw new Exception('Error al subir la imagen');
    }

    /**
     * Show confirmation page
     */
    public function showConfirmacion() {
        include __DIR__ . '/../views/afiliacion/confirmacion.php';
    }

    /**
     * Get affiliation details
     */
    public function getDetails($id) {
        if ($this->demo_mode) {
            return DemoData::getAfiliacionById($id);
        }

        $afiliacion = $this->afiliacion->getById($id);
        if (!$afiliacion) {
            return null;
        }

        $productos = $this->producto->getByAfiliacionId($id);
        $afiliacion['productos'] = $productos;

        return $afiliacion;
    }
}
?>