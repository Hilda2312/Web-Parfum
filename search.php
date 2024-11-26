<?php
session_start();
include('koneksi.php'); // Koneksi ke database

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query)) {
    $sql = "SELECT * FROM produk WHERE nama_produk LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="product-container">';
        while ($row = mysqli_fetch_assoc($result)) {
            $product_price = isset($row['harga']) ? $row['harga'] : 0;
            $product_image = isset($row['gambar']) ? $row['gambar'] : '';

            // Pastikan gambar dapat ditampilkan dengan benar
            // Periksa apakah gambar menggunakan URL relatif atau absolut
            if (filter_var($product_image, FILTER_VALIDATE_URL)) {
                $image_src = $product_image; // Gambar sudah berupa URL lengkap
            } else {
                $image_src = 'img/' . $product_image; // Path relatif ke folder img
            }

            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($image_src) . '" alt="' . htmlspecialchars($row['nama_produk']) . '">';
            echo '<h3>' . htmlspecialchars($row['nama_produk']) . '</h3>';
            echo '<p>Rp ' . number_format($product_price, 0, ',', '.') . '</p>';

            // Form Tambah ke Keranjang
            echo '<form action="cart.php" method="POST">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['id_produk']) . '">';
            echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row['nama_produk']) . '">';
            echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($product_price) . '">';
            echo '<input type="hidden" name="product_image" value="' . htmlspecialchars($product_image) . '">';
            echo '<button type="submit" class="add-to-cart-btn">Tambah ke Keranjang</button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>Produk tidak ditemukan.</p>';
    }
} else {
    echo '<p>Masukkan kata kunci pencarian.</p>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Produk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Styling */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .search-container { display: flex; justify-content: center; margin: 20px 0; }
        .search-container form { display: flex; gap: 10px; }
        .search-container input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px; }
        .search-container button { padding: 10px 20px; background-color: #ff4d4d; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .search-container button:hover { background-color: #ff1a1a; }
        
        .product-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; padding: 20px; }
        .product-card { background-color: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; width: 250px; }
        .product-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
        .product-card h3 { font-size: 18px; color: #333; margin-bottom: 5px; }
        .product-card p { font-size: 16px; color: #666; margin-bottom: 10px; }
        .add-to-cart-btn { background: #ff4d4d; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .add-to-cart-btn:hover { background: #ff1a1a; }
        
        /* Responsif */
        @media (max-width: 768px) {
            .product-container { flex-direction: column; align-items: center; }
            .product-card { width: 100%; margin-bottom: 20px; }
        }
    </style>
</head>
<body>
    <!-- Pencarian Produk -->
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="query" placeholder="Cari produk..." value="<?php echo htmlspecialchars($query); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>
</body>
</html>
