<?php
session_start();
include('koneksi.php');

// Cek apakah pengguna sudah login, jika tidak, gunakan sesi untuk menyimpan keranjang
if (!isset($_SESSION['user_id'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        // Menyimpan item ke keranjang dalam sesi
        $cart_item = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        ];
        
        // Menambahkan produk ke sesi keranjang
        $_SESSION['cart'][] = $cart_item;

        // Redirect ke cart.php setelah menambahkan produk
        header("Location: cart.php");
        exit();
    }

    // Menampilkan keranjang dari sesi
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
} else {
    // Jika pengguna sudah login, ambil data dari database seperti biasa
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Hitung total harga
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['product_price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Parfum</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Style */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f5f5f5; padding: 20px; }
        .cart-container { max-width: 1000px; margin: auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; padding-bottom: 10px; color: #333; border-bottom: 2px solid #eee; }
        .cart-item { display: flex; gap: 20px; padding: 20px; border-bottom: 1px solid #eee; align-items: center; }
        .product-image { width: 100px; height: 100px; border-radius: 8px; object-fit: cover; }
        .item-details { flex-grow: 1; }
        .product-name { font-size: 18px; color: #333; margin-bottom: 5px; font-weight: bold; }
        .product-price { font-size: 16px; color: #666; margin-bottom: 10px; }
        .quantity-form { display: flex; align-items: center; gap: 10px; }
        .quantity-btn { width: 30px; height: 30px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; background: #f0f0f0; transition: 0.2s; }
        .quantity-btn:hover { background: #e0e0e0; }
        .delete-btn { background: #ff4444; color: #fff; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; transition: 0.2s; }
        .delete-btn:hover { background: #ff0000; }
        .cart-total { margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: right; font-size: 20px; color: #333; }
        .checkout-btn { display: block; margin-left: auto; max-width: 200px; padding: 12px; color: #fff; background: #4CAF50; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: 0.2s; }
        .checkout-btn:hover { background: #45a049; }
        .empty-cart { text-align: center; padding: 40px; color: #666; }
        @media (max-width: 768px) { .cart-item { flex-direction: column; } .product-image { width: 100%; height: 200px; } }
    </style>
</head>
<body>
    <div class="cart-container">
        <?php if (count($cart_items) > 0): ?>
            <h2>Keranjang Belanja Anda</h2>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="product-image">
                    <div class="item-details">
                        <p class="product-name"><?php echo htmlspecialchars($item['product_name']); ?></p>
                        <p class="product-price">Rp <?php echo number_format($item['product_price'], 0, ',', '.'); ?></p>
                        <div class="quantity-form">
                            <!-- Add functionality for updating quantity if needed -->
                            <form action="update_quantity.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                                <button type="submit" name="action" value="decrease" class="quantity-btn"><i class="fas fa-minus"></i></button>
                            </form>
                            <span><?php echo $item['quantity']; ?></span>
                            <form action="update_quantity.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                                <button type="submit" name="action" value="increase" class="quantity-btn"><i class="fas fa-plus"></i></button>
                            </form>
                        </div>
                        <form action="remove_from_cart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" class="delete-btn"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">Total Harga: Rp <?php echo number_format($total, 0, ',', '.'); ?></div>
            <button class="checkout-btn" onclick="window.location.href='checkout.php'">Lanjutkan ke Pembayaran</button>

        <?php else: ?>
            <div class="empty-cart"><i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i><p>Keranjang Anda kosong.</p></div>
        <?php endif; ?>
    </div>
</body>
</html>
