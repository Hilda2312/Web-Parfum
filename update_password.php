<?php
// Mulai session dan koneksi ke database
session_start();
include('koneksi.php');

// Tentukan username dan password baru
$username = 'hilda'; // Nama pengguna yang ingin diubah password-nya
$new_password = '12345'; // Password baru yang akan di-hash

// Hash password baru
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

// Update password di database
$query = "UPDATE user SET password = ? WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);
mysqli_stmt_execute($stmt);

// Cek apakah update berhasil
if(mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Password berhasil diperbarui untuk $username.";
} else {
    echo "Gagal memperbarui password.";
}

// Tutup koneksi
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
