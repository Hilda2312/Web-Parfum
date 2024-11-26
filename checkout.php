<?php
session_start();
include('koneksi.php');

// Inisialisasi variabel total di luar blok kondisi
$total = 0;

// Ambil data dari keranjang di sesi
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Hitung total harga
foreach ($cart_items as $item) {
    $total += $item['product_price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Parfum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #f44336; /* Merah */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #e53935; /* Merah lebih gelap saat hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        td img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            padding: 10px 0;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
        }

        .summary p {
            font-size: 18px;
            margin: 10px 0;
        }

        .summary .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #f44336; /* Merah */
        }
    </style>
</head>
<body>

<header>
    <h1>Essenza</h1>
</header>

<div class="container">
    <h2>Checkout</h2>

    <form action="konfirmasi.html" method="POST">
        <h3>Informasi Pengiriman</h3>
        <div class="form-group">
            <label for="name">Nama Lengkap:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="address">Alamat Pengiriman:</label>
            <textarea id="address" name="address" required></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Nomor Telepon:</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <h3>Detail Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><img src="<?php echo $item['product_image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>"></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rp <?php echo number_format($item['product_price'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($item['product_price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary">
            <p>Total Harga: <span class="total-price">Rp <?php echo number_format($total, 0, ',', '.'); ?></span></p>
        </div>

        <h3>Pilih Metode Pembayaran</h3>
        <div class="form-group">
            <label for="payment_method">Metode Pembayaran:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="credit_card">Kartu Kredit</option>
                <option value="bank_transfer">Transfer Bank</option>
                <option value="cash_on_delivery">Bayar Di Tempat</option>
            </select>
        </div>

        <button type="submit" class="btn">Konfirmasi Pembayaran</button>
    </form>
</div>

</body>
</html>
