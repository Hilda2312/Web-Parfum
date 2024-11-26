<?php
session_start(); // Mulai sesi untuk menyimpan keranjang belanja

// Cek apakah produk ditambahkan ke keranjang
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    
    // Jika keranjang belum ada, inisialisasi sebagai array kosong
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Cek apakah produk sudah ada di keranjang
    if (isset($_SESSION['cart'][$product_id])) {
        // Jika sudah ada, tambahkan kuantitasnya
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        // Jika belum ada, tambahkan produk baru ke keranjang
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        ];
    }

    // Redirect agar halaman tidak memposting ulang
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Essenza Parfum</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <!-- Navbar -->
  <header>
    <div class="logo">Essenza</div>
    <nav>
      <div class="navbar-container">
        <form action="search.php" method="GET" class="search-form">
          <input type="text" name="query" placeholder="Cari produk..." class="search-input">
          <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
        </form>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="#products">Produk</a></li>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="login.html">Masuk</a></li>
          <li><a href="cart.php"><i class="fa fa-shopping-cart"></i></a></li>
        </ul>
      </div>
    </nav>
  </header>
  

  <!-- Hero Section -->
  <section id="home" class="hero">
    <h1>Find the Fragrance That Captures You</h1>
    <p>High-quality fragrances at affordable prices</p>
  </section>

  <!-- Produk -->
  <section id="products" class="product-section">
    <h2>Produk Unggulan</h2>
    <div class="product-grid">
      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42519%2FID%2F42519_1.png&id=18661936&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Posess</h3>
        <p>Rp 250.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="1">
            <input type="hidden" name="product_name" value="Posess">
            <input type="hidden" name="product_price" value="250000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42519%2FID%2F42519_1.png&id=18661936&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
      </div>

      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42518%2FID%2F42518_1.png&id=19893026&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Dark Wood</h3>
        <p>Rp 250.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="2">
            <input type="hidden" name="product_name" value="Dark Wood">
            <input type="hidden" name="product_price" value="250000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42518%2FID%2F42518_1.png&id=19893026&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
      </div>
      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F38498%2FID%2F38498_1.png&id=18661906&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP" alt="Parfum 1">
        <h3>Divine</h3>
        <p>Rp 250.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="3">
            <input type="hidden" name="product_name" value="Divine">
            <input type="hidden" name="product_price" value="250000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F38498%2FID%2F38498_1.png&id=18661906&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP" alt="Parfum 1">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
      </div>

      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42517%2FID%2F42517_1.png&id=18761937&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Venture</h3>
        <p>Rp 300.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Venture">
            <input type="hidden" name="product_price" value="300000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42517%2FID%2F42517_1.png&id=18761937&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>

       </div>
      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42751%2FID%2F42751_1.png&id=18661938&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Love Potion</h3>
        <p>Rp 275.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="5">
            <input type="hidden" name="product_name" value="Love Potion">
            <input type="hidden" name="product_price" value="275000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42751%2FID%2F42751_1.png&id=18661938&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
       </div>
       <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F40809%2FID%2F40809_1.png&id=19981575&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Whispers</h3>
        <p>Rp 200.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="6">
            <input type="hidden" name="product_name" value="Whispers">
            <input type="hidden" name="product_price" value="200000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F35679%2FID%2F35679_1.png&id=18661896&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
       </div>
       <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42503%2FID%2F42503_1.png&id=19463876&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Giordani Gold</h3>
        <p>Rp 300.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="7">
            <input type="hidden" name="product_name" value="Giordani Gold">
            <input type="hidden" name="product_price" value="300000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42503%2FID%2F42503_1.png&id=19463876&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
      </div>
        </form>
      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F38538%2FID%2F38538_1.png&id=19463922&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Woody</h3>
        <p>Rp 200.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="8">
            <input type="hidden" name="product_name" value="Woody">
            <input type="hidden" name="product_price" value="200000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F38538%2FID%2F38538_1.png&id=19463922&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
       </div>
       <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F35679%2FID%2F35679_1.png&id=18661896&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>All or Nothing</h3>
        <p>Rp 300.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="9">
            <input type="hidden" name="product_name" value="All or Nothing">
            <input type="hidden" name="product_price" value="300000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F35679%2FID%2F35679_1.png&id=18661896&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
    </div>
    <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42495%2FID%2F42495_1.png&id=18661917&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Amber</h3>
        <p>Rp 350.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="10">
            <input type="hidden" name="product_name" value="Amber">
            <input type="hidden" name="product_price" value="350000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F42495%2FID%2F42495_1.png&id=18661917&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
      </div>
        </form>
      <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F34471%2FID%2F34471_1.png&id=2024-03-11T09-49-23-856Z_MediaMigration&version=1698807604&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Wild</h3>
        <p>Rp 200.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="11">
            <input type="hidden" name="product_name" value="Wild">
            <input type="hidden" name="product_price" value="200000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F34471%2FID%2F34471_1.png&id=2024-03-11T09-49-23-856Z_MediaMigration&version=1698807604&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
       </div>
       <div class="product">
        <img src="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F37214%2FID%2F37214_1.png&id=18661897&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
        <h3>Feel Good</h3>
        <p>Rp 200.000</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="12">
            <input type="hidden" name="product_name" value="Feel Good">
            <input type="hidden" name="product_price" value="200000.00">
            <input type="hidden" name="product_image" value="https://media-cdn.oriflame.com/productImage?externalMediaId=product-management-media%2FProducts%2F37214%2FID%2F37214_1.png&id=18661897&version=1&w=700&bc=%23f5f5f5&ib=%23f5f5f5&q=90&imageFormat=WebP">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
    </div>
  </section>

  <!-- Tentang Kami -->
  <section id="about" class="about-section">
    <h2>Tentang Kami</h2>
    <p>Essenza menawarkan parfum berkualitas tinggi dengan harga yang terjangkau.</p>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Essenza Parfum</p>
  </footer>

  <script src="scripts.js"></script>
</body>
</html>
