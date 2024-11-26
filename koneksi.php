<?php
$host = 'localhost'; // Nama host
$user = 'root'; // Username database
$pass = ''; // Password database
$dbname = 'toko_parfum'; // Nama database

$conn = new mysqli($host, $user, $pass, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
