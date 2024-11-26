<?php
session_start();
include('koneksi.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Menghindari SQL Injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Query untuk mengambil data pengguna
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Cek apakah username ditemukan dan password cocok
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'admin') {
        header('Location: admin_dashboard.html'); // Halaman admin
    } else {
        header('Location: index.php'); // Halaman member
    }
} else {
    echo "<p>Username atau password salah. <a href='login.php'>Coba lagi</a></p>";
}
?>
