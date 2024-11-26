<?php
session_start();
include('koneksi.php');

// Jika keranjang kosong, beri peringatan dan hentikan
if (empty($_SESSION['cart'])) {
    echo "Keranjang Anda kosong.";
    exit;
}

// Hitung total harga
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Cek apakah pengguna sudah login atau tidak
    if (isset($_SESSION['user_id'])) {
        // Pengguna login, ambil id_user dari session
        $user_id = $_SESSION['user_id'];

        // Menyimpan data pesanan ke database dengan user_id
        $order_query = "INSERT INTO orders (id_user, harga, status, payment_method) VALUES (?, ?, 'pending', ?)";
        if ($stmt = mysqli_prepare($conn, $order_query)) {
            // Bind parameter
            mysqli_stmt_bind_param($stmt, "ids", $user_id, $total_price, $payment_method);
            // Eksekusi query
            if (mysqli_stmt_execute($stmt)) {
                $order_id = mysqli_insert_id($conn);

                // Simpan detail pesanan ke dalam tabel order_items
                foreach ($_SESSION['cart'] as $item) {
                    $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                    if ($stmt_item = mysqli_prepare($conn, $order_item_query)) {
                        // Bind parameter
                        mysqli_stmt_bind_param($stmt_item, "iiii", $order_id, $item['product_id'], $item['quantity'], $item['product_price']);
                        // Eksekusi query
                        mysqli_stmt_execute($stmt_item);
                    }
                }

                // Mengupdate total harga order
                $update_order_query = "UPDATE orders SET harga = ? WHERE order_id = ?";
                if ($stmt_update = mysqli_prepare($conn, $update_order_query)) {
                    // Bind parameter
                    mysqli_stmt_bind_param($stmt_update, "di", $total_price, $order_id);
                    // Eksekusi query
                    mysqli_stmt_execute($stmt_update);
                }

                // Kosongkan keranjang setelah pemesanan berhasil
                unset($_SESSION['cart']);

                echo "Pesanan berhasil! Terima kasih atas pembelian Anda.";
            } else {
                echo "Terjadi kesalahan saat memproses pesanan.";
            }

            // Tutup statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Terjadi kesalahan saat memproses pesanan.";
        }
    } else {
        // Pengguna tidak login, simpan pesanan tanpa user_id
        $order_query = "INSERT INTO orders (harga, status, payment_method, name, address, phone) 
                        VALUES ('$total_price', 'pending', '$payment_method', '$name', '$address', '$phone')";
        if (mysqli_query($conn, $order_query)) {
            $order_id = mysqli_insert_id($conn);

            // Simpan detail pesanan ke dalam tabel order_items
            foreach ($_SESSION['cart'] as $item) {
                $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                     VALUES ('$order_id', '{$item['product_id']}', '{$item['quantity']}', '{$item['product_price']}')";
                mysqli_query($conn, $order_item_query);
            }

            // Mengupdate total harga order
            $update_order_query = "UPDATE orders SET harga = '$total_price' WHERE order_id = '$order_id'";
            mysqli_query($conn, $update_order_query);

            // Kosongkan keranjang setelah pemesanan berhasil
            unset($_SESSION['cart']);

            echo "Pesanan berhasil! Terima kasih atas pembelian Anda.";
        } else {
            echo "Terjadi kesalahan saat memproses pesanan.";
        }
    }
}
?>
