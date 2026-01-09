<?php
// pages/motors.php

$pageTitle = 'Data Motor';
include '../includes/header.php';

$motor = new Motor();

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

// Filters
$filters = [];
if (!empty($_GET['search'])) {
    $filters['search'] = $_GET['search'];
}
if (!empty($_GET['brand'])) {
    $filters['brand'] = $_GET['brand'];
}
if (!empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}

// Get motors
$motors = $motor->getAll($filters, $limit, $offset);
$totalMotors = $motor->getCount($filters);
$totalPages = ceil($totalMotors / $limit);

// Get brands for filter
$brands = $motor->getAllBrands();
?>

<div class="container-fluid">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-motorcycle me-2"></i>Data Motor</h2>
            <?php if (User::isAdmin()): ?>
            <a href="add_motor.php" class="btn btn-danger btn-custom">
                <i class="fas fa-plus me-2"></i>Tambah Motor
            </a>
            <?php endif; ?>
        </div>

        <!-- Filter & Search -->
        <form method="GET" action="">
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="🔍 Cari motor..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="brand">
                        <option value="">Semua Merek</option>
                        <?php foreach ($brands as $b): ?>
                        <option value="<?= htmlspecialchars($b['brand']) ?>" 
                                <?= (isset($_GET['brand']) && $_GET['brand'] == $b['brand']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['brand']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="Tersedia" <?= (isset($_GET['status']) && $_GET['status'] == 'Tersedia') ? 'selected' : '' ?>>Tersedia</option>
                        <option value="Terjual" <?= (isset($_GET['status']) && $_GET['status'] == 'Terjual') ? 'selected' : '' ?>>Terjual</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Motor List -->
        <div class="row">
            <?php if ($motors && count($motors) > 0): ?>
                <?php foreach ($motors as $m): ?>
                <div class="col-md-4">
                    <div class="card motor-card">
                        <div class="motor-img">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($m['brand']) ?> <?= htmlspecialchars($m['model']) ?></h5>
                            <p class="card-text">
                                <i class="fas fa-calendar me-2"></i><?= htmlspecialchars($m['year']) ?><br>
                                <i class="fas fa-palette me-2"></i><?= htmlspecialchars($m['color']) ?><br>
                                <span class="badge <?= $m['status'] == 'Tersedia' ? 'bg-success' : 'bg-secondary' ?> mt-2">
                                    <?= htmlspecialchars($m['status']) ?>
                                </span>
                            </p>
                            <h4 class="text-danger">Rp <?= number_format($m['price'], 0, ',', '.') ?></h4>
                            
                            <?php if (User::isAdmin()): ?>
                            <div class="d-flex gap-2 mt-3">
                                <a href="edit_motor.php?id=<?= $m['id'] ?>" class="btn btn-warning btn-sm flex-fill">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_motor.php?id=<?= $m['id'] ?>" 
                                   class="btn btn-danger btn-sm flex-fill"
                                   onclick="return confirm('Yakin ingin menghapus motor ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>Tidak ada data motor ditemukan.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?><?= !empty($_GET['brand']) ? '&brand=' . urlencode($_GET['brand']) : '' ?><?= !empty($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>