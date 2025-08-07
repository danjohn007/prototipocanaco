<?php
$title = 'Dashboard Administrativo - Cámara de Comercio de Querétaro';
include __DIR__ . '/../partials/header.php';
?>

<div class="container-fluid my-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Dashboard Administrativo</h1>
                    <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                </div>
                <div>
                    <a href="/admin/exportar" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>
                        Exportar CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Afiliaciones
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $stats['totales']['total_afiliaciones']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $stats['totales']['pendientes']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Validadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $stats['totales']['validadas']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rechazadas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $stats['totales']['rechazadas']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Sector Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Afiliaciones por Sector</h6>
                </div>
                <div class="card-body">
                    <canvas id="sectorChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estatus de Afiliaciones</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Membership Chart -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Membresías por Tipo</h6>
                </div>
                <div class="card-body">
                    <canvas id="membershipChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Affiliations -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Afiliaciones Recientes</h6>
                    <a href="/admin/afiliaciones" class="btn btn-sm btn-primary">Ver Todas</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Empresa</th>
                                    <th>Contacto</th>
                                    <th>Sector</th>
                                    <th>Membresía</th>
                                    <th>Estatus</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($stats['recientes'], 0, 10) as $afiliacion): ?>
                                    <tr>
                                        <td><?php echo $afiliacion['id']; ?></td>
                                        <td><?php echo htmlspecialchars($afiliacion['empresa']); ?></td>
                                        <td><?php echo htmlspecialchars($afiliacion['contacto']); ?></td>
                                        <td><?php echo htmlspecialchars($afiliacion['sector_nombre']); ?></td>
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
                                        <td><?php echo date('d/m/Y', strtotime($afiliacion['fecha_solicitud'])); ?></td>
                                        <td>
                                            <a href="/admin/afiliacion/<?php echo $afiliacion['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
</style>

<script>
// Chart.js Configuration
document.addEventListener('DOMContentLoaded', function() {
    // Sector Chart
    const sectorData = <?php echo json_encode($stats['por_sector']); ?>;
    const sectorCtx = document.getElementById('sectorChart').getContext('2d');
    new Chart(sectorCtx, {
        type: 'doughnut',
        data: {
            labels: sectorData.map(item => item.nombre),
            datasets: [{
                data: sectorData.map(item => item.total),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Status Chart
    const statusData = <?php echo json_encode($stats['por_estatus']); ?>;
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusData.map(item => item.estatus.replace('_', ' ')),
            datasets: [{
                data: statusData.map(item => item.total),
                backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a', '#e74a3b']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Membership Chart
    const membershipData = <?php echo json_encode($stats['por_membresia']); ?>;
    const membershipCtx = document.getElementById('membershipChart').getContext('2d');
    new Chart(membershipCtx, {
        type: 'bar',
        data: {
            labels: membershipData.map(item => item.nombre),
            datasets: [{
                label: 'Afiliaciones',
                data: membershipData.map(item => item.total),
                backgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>