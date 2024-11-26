<!-- cart.php -->
<?php 
include('koneksi.php');

// Query untuk mengambil data cart
$sql = "SELECT * FROM cart";
$result = mysqli_query($conn, $sql);

// Query untuk total harga
$total_query = "SELECT SUM(product_price * quantity) AS total FROM cart";
$total_result = mysqli_query($conn, $total_query);
$total = mysqli_fetch_assoc($total_result)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Parfum</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .cart-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .cart-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid #eee;
            position: relative;
            gap: 20px;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details {
            flex-grow: 1;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .product-price {
            color: #666;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .product-quantity {
            color: #888;
            margin-bottom: 10px;
        }

        .quantity-form {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .quantity-btn {
            background: #f0f0f0;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }

        .quantity-btn:hover {
            background: #e0e0e0;
        }

        .delete-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .delete-btn:hover {
            background: #ff0000;
        }

        .cart-total {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: right;
        }

        .cart-total strong {
            font-size: 20px;
            color: #333;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-top: 20px;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }

        .checkout-btn:hover {
            background: #45a049;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
            }

            .product-image {
                width: 100%;
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <h2>Keranjang Belanja Anda</h2>
            
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="cart-item">
                    <img src="<?php echo htmlspecialchars($row['product_image']); ?>" 
                         alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                         class="product-image">
                    
                    <div class="item-details">
                        <p class="product-name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                        <p class="product-price">Rp <?php echo number_format($row['product_price'], 0, ',', '.'); ?></p>
                        <p class="product-quantity">Jumlah: <?php echo $row['quantity']; ?></p>
                        
                        <div class="quantity-form">
                            <form action="update_quantity.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="decrease" class="quantity-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                            
                            <span><?php echo $row['quantity']; ?></span>
                            
                            <form action="update.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="increase" class="quantity-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                        
                        <form action="remove_from_cart.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>

            <div class="cart-total">
                <p><strong>Total Harga: Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></p>
                <button class="checkout-btn">Lanjutkan ke Pembayaran</button>
            </div>

        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                <p>Keranjang Anda kosong.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Fungsi untuk konfirmasi penghapusan item
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>