<?php
// pages/edit_motor.php

$pageTitle = 'Edit Motor';
include '../includes/header.php';

// Hanya admin yang bisa akses
User::requireAdmin();

$error = '';
$success = '';
$motor = new Motor();

// Get motor ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    header('Location: motors.php');
    exit;
}

// Get motor data
$motorData = $motor->getById($id);
if (!$motorData) {
    header('Location: motors.php');
    exit;
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $motor->id = $id;
    $motor->brand = trim($_POST['brand']);
    $motor->model = trim($_POST['model']);
    $motor->year = (int)$_POST['year'];
    $motor->price = (float)$_POST['price'];
    $motor->color = trim($_POST['color']);
    $motor->status = $_POST['status'];
    
    // Validasi
    if (empty($motor->brand) || empty($motor->model) || empty($motor->year) || 
        empty($motor->price) || empty($motor->color) || empty($motor->status)) {
        $error = 'Semua field harus diisi!';
    } elseif ($motor->year < 2000 || $motor->year > 2025) {
        $error = 'Tahun harus antara 2000-2025!';
    } elseif ($motor->price < 0) {
        $error = 'Harga tidak valid!';
    } else {
        if ($motor->update()) {
            $success = 'Motor berhasil diupdate!';
            $motorData = $motor->getById($id); // Refresh data
            header('Refresh: 2; url=motors.php');
        } else {
            $error = 'Gagal mengupdate motor!';
        }
    }
} else {
    // Populate form with existing data
    $_POST['brand'] = $motorData['brand'];
    $_POST['model'] = $motorData['model'];
    $_POST['year'] = $motorData['year'];
    $_POST['price'] = $motorData['price'];
    $_POST['color'] = $motorData['color'];
    $_POST['status'] = $motorData['status'];
}
?>

<div class="container-fluid">
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-edit me-2"></i>Edit Motor</h2>
            <a href="motors.php" class="btn btn-secondary btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i><?= $success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Merek Motor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="brand" required 
                                       value="<?= htmlspecialchars($_POST['brand']) ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="model" required
                                       value="<?= htmlspecialchars($_POST['model']) ?>">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="year" min="2000" max="2025" required
                                               value="<?= htmlspecialchars($_POST['year']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Warna <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="color" required
                                               value="<?= htmlspecialchars($_POST['color']) ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="price" min="0" required
                                               value="<?= htmlspecialchars($_POST['price']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" name="status" required>
                                            <option value="Tersedia" <?= $_POST['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                            <option value="Terjual" <?= $_POST['status'] == 'Terjual' ? 'selected' : '' ?>>Terjual</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning btn-custom">
                                    <i class="fas fa-save me-2"></i>Update Motor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>