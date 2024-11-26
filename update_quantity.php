<?php
session_start();
include('koneksi.php');

// Pastikan ini adalah request POST dan ada id produk serta aksi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['action'])) {
    $product_id = $_POST['id'];
    $action = $_POST['action'];

    // Jika pengguna belum login, lakukan perubahan kuantitas di sesi
    if (!isset($_SESSION['user_id'])) {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] == $product_id) {
                    // Tambah atau kurangi kuantitas berdasarkan aksi
                    if ($action === 'increase') {
                        $item['quantity']++;
                    } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                        $item['quantity']--;
                    }
                    break;
                }
            }
            unset($item); // Hapus referensi untuk menghindari kesalahan
        }
    } else {
        // Jika pengguna login, lakukan perubahan kuantitas di database
        $user_id = $_SESSION['user_id'];

        // Ambil kuantitas saat ini dari database
        $query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $current_quantity);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Perbarui kuantitas di database berdasarkan aksi
        if ($action === 'increase') {
            $new_quantity = $current_quantity + 1;
        } elseif ($action === 'decrease' && $current_quantity > 1) {
            $new_quantity = $current_quantity - 1;
        } else {
            $new_quantity = $current_quantity; // Tidak ada perubahan jika kuantitas kurang dari 1
        }

        // Update kuantitas di database
        $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iii', $new_quantity, $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Redirect kembali ke halaman keranjang
    header("Location: cart.php");
    exit();
}

// Tutup koneksi database
mysqli_close($conn);
?>
