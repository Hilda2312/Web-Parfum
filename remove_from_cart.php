<?php
session_start();
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Hapus item dari sesi keranjang jika pengguna belum login
    if (!isset($_SESSION['user_id'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex setelah penghapusan
                break;
            }
        }
    } else {
        // Jika pengguna login, hapus dari database
        $user_id = $_SESSION['user_id'];
        $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header("Location: cart.php"); // Redirect kembali ke cart.php
    exit();
}
mysqli_close($conn);
