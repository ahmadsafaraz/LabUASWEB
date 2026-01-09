<?php
// pages/dashboard.php

$pageTitle = 'Dashboard';
include '../includes/header.php';

// Get statistics
$motor = new Motor();
$stats = $motor->getStats();
?>

<div class="container-fluid">
    <div class="main-content">
        <h2 class="mb-4"><i class="fas fa-chart-line me-2"></i>Dashboard</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-motorcycle me-2"></i>Total Motor</h5>
                            <h2 class="mb-0"><?= $stats['total'] ?></h2>
                        </div>
                        <i class="fas fa-motorcycle fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stats-card success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-check-circle me-2"></i>Motor Tersedia</h5>
                            <h2 class="mb-0"><?= $stats['available'] ?></h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stats-card info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-tags me-2"></i>Total Merek</h5>
                            <h2 class="mb-0"><?= $stats['brands'] ?></h2>
                        </div>
                        <i class="fas fa-tags fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-info-circle me-2"></i>Selamat Datang!</h5>
                        <p class="card-text">
                            Halo <strong><?= htmlspecialchars($currentUser['username']) ?></strong>! 
                            Anda login sebagai <span class="badge bg-danger"><?= strtoupper($currentUser['role']) ?></span>
                        </p>
                        <p class="card-text">
                            Gunakan menu <strong>Data Motor</strong> untuk melihat dan mengelola data motor.
                        </p>
                        <?php if (User::isAdmin()): ?>
                        <p class="card-text">
                            <i class="fas fa-crown text-warning me-2"></i>
                            Sebagai <strong>Admin</strong>, Anda dapat menambah, edit, dan hapus data motor.
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>