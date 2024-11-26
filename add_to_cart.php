<?php
session_start();
include('koneksi.php');

// Fungsi untuk menambahkan atau memperbarui produk di session keranjang
function addToCartSession($product_id, $product_name, $product_price, $product_image) {
    // Cek apakah keranjang sudah ada di session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Jika produk sudah ada di keranjang session, tambahkan quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        // Jika belum ada, tambahkan sebagai produk baru
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data produk dari form
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = isset($_POST['product_price']) ? filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT) : 0;
    $product_image = isset($_POST['product_image']) ? mysqli_real_escape_string($conn, $_POST['product_image']) : 'default_image.jpg';

    // Validasi data produk
    if ($product_id > 0 && $product_price > 0) {
        // Tambahkan produk ke session keranjang
        addToCartSession($product_id, $product_name, $product_price, $product_image);

        // Cek apakah produk juga perlu ditambahkan atau diperbarui di tabel database `cart`
        $check_query = "SELECT * FROM cart WHERE product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Jika produk sudah ada, update quantity di database
            $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = '$product_id'";
            mysqli_query($conn, $update_query);
        } else {
            // Jika produk belum ada, tambahkan sebagai entri baru di database
            $insert_query = "INSERT INTO cart (product_id, product_name, product_price, product_image, quantity) 
                             VALUES ('$product_id', '$product_name', '$product_price', '$product_image', 1)";
            mysqli_query($conn, $insert_query);
        }

        // Redirect ke halaman keranjang setelah menambah produk
        header("Location: cart.php");
        exit();
    } else {
        echo "ID produk atau harga tidak valid!";
    }
}
?>
