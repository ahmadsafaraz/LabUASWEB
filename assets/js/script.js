// assets/js/script.js

// Konfirmasi delete
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus motor ini?')) {
        window.location.href = 'delete_motor.php?id=' + id;
    }
    return false;
}

// Auto hide alerts
$(document).ready(function() {
    // Auto hide alert after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
    
    // Format number input for price
    $('input[name="price"]').on('input', function() {
        let value = $(this).val();
        if (value < 0) {
            $(this).val(0);
        }
    });
    
    // Validate year input
    $('input[name="year"]').on('input', function() {
        let value = $(this).val();
        let currentYear = new Date().getFullYear();
        
        if (value < 2000) {
            $(this).val(2000);
        } else if (value > currentYear) {
            $(this).val(currentYear);
        }
    });
});

// Form validation
function validateMotorForm() {
    let brand = $('input[name="brand"]').val().trim();
    let model = $('input[name="model"]').val().trim();
    let year = $('input[name="year"]').val();
    let price = $('input[name="price"]').val();
    let color = $('input[name="color"]').val().trim();
    
    if (!brand || !model || !year || !price || !color) {
        alert('Semua field harus diisi!');
        return false;
    }
    
    if (year < 2000 || year > 2025) {
        alert('Tahun harus antara 2000-2025!');
        return false;
    }
    
    if (price < 0) {
        alert('Harga tidak valid!');
        return false;
    }
    
    return true;
}