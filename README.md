# UAS-PEM-WEB

# 1. PENJELASAN SISTEM
🎯 Tujuan Sistem
Aplikasi web untuk mengelola data penjualan motor dengan sistem manajemen CRUD (Create, Read, Update, Delete) yang dilengkapi dengan autentikasi user berbasis role (Admin dan User).
🏗️ Konsep Dasar
Sistem ini dibangun dengan konsep:

OOP (Object-Oriented Programming): Menggunakan class untuk Database, Motor, dan User
Modular: Pemisahan file berdasarkan fungsi (config, classes, includes, pages)
MVC-like: Separation of Concerns antara logic, data, dan view
Responsive: Mobile-first design dengan Bootstrap 5
Secure: Menggunakan prepared statements, password hashing, dan session management

👥 User Roles
Admin

Full akses sistem (CRUD)
Dapat menambah motor baru
Dapat mengedit data motor
Dapat menghapus motor
Melihat semua data dan statistik

User

Read-only access
Hanya dapat melihat data motor
Dapat menggunakan filter dan search
Tidak dapat melakukan perubahan data

# 2. Struktur Folder 
motor-sales/
│
├── config/                      # Konfigurasi sistem
│   └── database.php            # Koneksi database, timezone, session
│
├── classes/                     # Class OOP
│   ├── Database.php            # Class untuk koneksi & query database
│   ├── Motor.php               # Class untuk operasi CRUD motor
│   └── User.php                # Class untuk autentikasi user
│
├── includes/                    # Template reusable
│   ├── header.php              # HTML head, load CSS, navbar
│   ├── navbar.php              # Navigation bar
│   └── footer.php              # Scripts, closing tags
│
├── assets/                      # Static files
│   ├── css/
│   │   └── style.css           # Custom styling
│   ├── js/
│   │   └── script.js           # Custom JavaScript
│   └── images/                 # Folder untuk gambar
│
├── pages/                       # Halaman aplikasi
│   ├── dashboard.php           # Halaman statistik
│   ├── motors.php              # List motor dengan filter
│   ├── add_motor.php           # Form tambah motor
│   ├── edit_motor.php          # Form edit motor
│   └── delete_motor.php        # Handler hapus motor
│
├── auth/                        # Autentikasi
│   ├── login.php               # Halaman login
│   └── logout.php              # Handler logout
│
├── .htaccess                    # URL routing & security
├── index.php                    # Landing page
└── database.sql                 # SQL setup


# 3. FUNGSIONAL SISTEM
AUTENTIKASI & AUTORISASI
Login System
Fungsi:

Validasi username dan password
Membuat session jika login berhasil
Redirect berdasarkan role
Menampilkan error jika login gagal

# Security Features:

Password di-hash dengan password_hash() (bcrypt)
Menggunakan prepared statements (SQL injection protection)
Session-based authentication
Input validation & sanitization

# Logout System
Fungsi:

Menghapus semua session
Destroy session
Redirect ke login


# Session Management
File: classes/User.php
Method:

isLoggedIn() - Cek apakah user sudah login
isAdmin() - Cek apakah user adalah admin
requireLogin() - Paksa login, redirect jika belum
requireAdmin() - Paksa admin, redirect jika bukan admin
getCurrentUser() - Ambil info user dari session

# DASHBOARD
Halaman Dashboard
File: pages/dashboard.php
Fungsi:

Menampilkan statistik sistem
Welcome message
Quick navigation

Statistik yang Ditampilkan:

Total Motor - Jumlah semua motor di database
Motor Tersedia - Motor dengan status "Tersedia"
Total Merek - Jumlah merek motor yang berbeda


# CRUD OPERATIONS (Admin Only)
CREATE - Tambah Motor
File: pages/add_motor.php
Akses: Admin only (User::requireAdmin())
Form Fields:

Merek (required)
Model (required)
Tahun (required, 2000-2025)
Harga (required, > 0)
Warna (required)
Status (Tersedia/Terjual)

# PAGINATION SYSTEM
Konsep Pagination
Problem:
Jika ada 100 motor, loading semua sekaligus akan:

Lambat (query besar)
Berat di browser (render banyak card)
User experience buruk (scroll panjang)

Solution:
Bagi data menjadi halaman-halaman kecil (6 motor per halaman)


# Halaman Login
<img width="1920" height="1080" alt="Screenshot (200)" src="https://github.com/user-attachments/assets/4acd9b7f-12f4-4f3c-a900-dae4d4cf0633" />


# Dashboard
<img width="1920" height="1080" alt="Screenshot (201)" src="https://github.com/user-attachments/assets/9b617087-2b68-4bb4-b62d-9c448d8241ff" />


# Data Motor
<img width="1920" height="1080" alt="Screenshot (202)" src="https://github.com/user-attachments/assets/f3d39949-b94d-4ad7-93d8-b8a0f2561e5a" />



# Tambah Barang
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/86ee622b-a3b4-43a7-b19e-9e816a90870e" />

# Edit Barang

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/512cc293-5874-499e-81ac-b1e90b77f0bf" />



# Hapus Barang
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/03e6d3a2-6fc5-4048-81ac-215ecfe81b8a" />



# Pagination
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/89ac75ad-0d85-41d3-a032-5a09c8815c79" />


