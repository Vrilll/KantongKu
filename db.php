<?php
// Pengaturan koneksi database
$host = 'localhost';
$username = 'root';
$password = ''; // Kosongkan jika tidak ada password
$database = 'kantongku2';

// Buat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set a good character set
$conn->set_charset("utf8mb4");
?>