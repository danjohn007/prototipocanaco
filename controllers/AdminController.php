<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Afiliacion.php';
require_once __DIR__ . '/../models/Membresia.php';
require_once __DIR__ . '/../models/Sector.php';
require_once __DIR__ . '/../models/Usuario.php';

class AdminController {
    private $auth;
    private $afiliacion;
    private $membresia;
    private $sector;
    private $usuario;

    public function __construct() {
        $this->auth = new AuthController();
        $this->afiliacion = new Afiliacion();
        $this->membresia = new Membresia();
        $this->sector = new Sector();
        $this->usuario = new Usuario();
    }

    /**
     * Show admin dashboard
     */
    public function dashboard() {
        $this->auth->requireAdmin();

        // Get statistics
        $stats = $this->getStatistics();
        
        include __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * Get dashboard statistics
     */
    private function getStatistics() {
        $stats = [];

        // Affiliation statistics by status
        $stats['por_estatus'] = $this->afiliacion->getStatsByStatus();
        
        // Affiliation statistics by sector
        $stats['por_sector'] = $this->afiliacion->getStatsBySector();
        
        // Membership statistics
        $stats['por_membresia'] = $this->membresia->getStats();

        // Recent affiliations
        $stats['recientes'] = $this->afiliacion->getAll(null, null, 10);

        // Total counts
        $all_affiliations = $this->afiliacion->getAll();
        $stats['totales'] = [
            'total_afiliaciones' => count($all_affiliations),
            'pendientes' => count(array_filter($all_affiliations, function($a) { return $a['estatus'] === 'pendiente'; })),
            'validadas' => count(array_filter($all_affiliations, function($a) { return $a['estatus'] === 'validada'; })),
            'rechazadas' => count(array_filter($all_affiliations, function($a) { return $a['estatus'] === 'rechazada'; }))
        ];

        return $stats;
    }

    /**
     * Show affiliations list
     */
    public function afiliaciones() {
        $this->auth->requireAdmin();

        $estatus = $_GET['estatus'] ?? null;
        $sector_id = $_GET['sector'] ?? null;

        $afiliaciones = $this->afiliacion->getAll($estatus, $sector_id);
        $sectores = $this->sector->getAll();

        include __DIR__ . '/../views/admin/afiliaciones.php';
    }

    /**
     * Show affiliation details
     */
    public function detalleAfiliacion($id) {
        $this->auth->requireAdmin();

        require_once __DIR__ . '/AfiliacionController.php';
        $afiliacionController = new AfiliacionController();
        $afiliacion = $afiliacionController->getDetails($id);

        if (!$afiliacion) {
            $_SESSION['error'] = 'Afiliación no encontrada';
            header('Location: /admin/afiliaciones');
            exit();
        }

        include __DIR__ . '/../views/admin/detalle_afiliacion.php';
    }

    /**
     * Update affiliation status
     */
    public function actualizarEstatus() {
        $this->auth->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $estatus = $_POST['estatus'] ?? '';
            $comentarios = $_POST['comentarios'] ?? '';

            if (!in_array($estatus, ['pendiente', 'en_proceso', 'validada', 'rechazada'])) {
                $_SESSION['error'] = 'Estatus inválido';
                header('Location: /admin/afiliaciones');
                exit();
            }

            if ($this->afiliacion->updateStatus($id, $estatus, $_SESSION['user_id'], $comentarios)) {
                $_SESSION['success'] = 'Estatus actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar el estatus';
            }

            header('Location: /admin/afiliacion/' . $id);
            exit();
        }
    }

    /**
     * Export data to CSV
     */
    public function exportarCSV() {
        $this->auth->requireAdmin();

        $afiliaciones = $this->afiliacion->getAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=afiliaciones.csv');

        $output = fopen('php://output', 'w');
        
        // Write BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Write headers
        fputcsv($output, [
            'ID', 'Empresa', 'Contacto', 'Email', 'Teléfono', 'Dirección',
            'Sector', 'Membresía', 'Estatus', 'Fecha Solicitud', 'Fecha Validación'
        ]);

        // Write data
        foreach ($afiliaciones as $afiliacion) {
            fputcsv($output, [
                $afiliacion['id'],
                $afiliacion['empresa'],
                $afiliacion['contacto'],
                $afiliacion['usuario_email'],
                $afiliacion['telefono'],
                $afiliacion['direccion'],
                $afiliacion['sector_nombre'],
                $afiliacion['membresia_nombre'],
                $afiliacion['estatus'],
                $afiliacion['fecha_solicitud'],
                $afiliacion['fecha_validacion']
            ]);
        }

        fclose($output);
        exit();
    }

    /**
     * Get chart data as JSON
     */
    public function getChartData() {
        $this->auth->requireAdmin();
        
        header('Content-Type: application/json');
        
        $stats = $this->getStatistics();
        echo json_encode($stats);
        exit();
    }
}
?>