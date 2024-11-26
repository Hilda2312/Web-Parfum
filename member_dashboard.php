<?php
session_start();
if ($_SESSION['role'] != 'member') {
    header('Location: login.php'); // Redirect to login if not a member
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member</title>
    <link rel="stylesheet" href="dashboardmember.css">
</head>
<body>
    <div class="sidebar">
        <h2>Member Dashboard</h2>
        <ul>
            <li><a href="#profile">Profil Saya</a></li>
            <li><a href="#transactions">Riwayat Transaksi</a></li>
            <li><a href="#rewards">Poin & Rewards</a></li>
            <li><a href="#notifications">Notifikasi</a></li>
            <li><a href="#settings">Pengaturan Akun</a></li>
            <li><a href="index.html">Keluar</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <header>
            <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
        </header>
        
        <section id="profile">
            <h2>Profil Saya</h2>
            <p>Nama: <?php echo $_SESSION['username']; ?></p>
            <p>Email: example@mail.com</p>
            <p>Level Member: Gold</p>
        </section>

        <section id="transactions">
            <h2>Riwayat Transaksi</h2>
            <p>Menampilkan transaksi terbaru Anda.</p>
            <!-- Sample transaction history -->
            <ul>
                <li>Pembelian Produk A - Rp500.000 - 01 Nov 2024</li>
                <li>Pembelian Produk B - Rp250.000 - 20 Okt 2024</li>
            </ul>
        </section>

        <section id="rewards">
            <h2>Poin & Rewards</h2>
            <p>Poin Anda: 120</p>
            <p>Hadiah tersedia untuk ditukar: Diskon 20%, Voucher Produk</p>
        </section>

        <section id="notifications">
            <h2>Notifikasi</h2>
            <ul>
                <li>Promo spesial akhir tahun hingga 50%!</li>
                <li>Pesanan Anda telah dikirim.</li>
            </ul>
        </section>

        <section id="settings">
            <h2>Pengaturan Akun</h2>
            <button>Ubah Kata Sandi</button>
            <button>Log Aktivitas</button>
        </section>
    </div>

    <script>
        function copyReferral() {
            const copyText = document.querySelector('#referral input');
            copyText.select();
            document.execCommand("copy");
            alert("Kode referral disalin: " + copyText.value);
        }
    </script>
      <!-- Section untuk Benefits -->
        <section id="benefits" class="benefits-section">
            <div class="benefit-container">
                <div class="benefit-item">
                    <img src="https://media-id-cdn.oriflame.com/contentMedia/?externalMediaId=aeb16f40-cf9b-4048-807c-c029753cc6e7&mimeType=image%2fsvg%2bxml&la=id-ID&imageFormat=Jpeg&q=70" alt="Welcome Discount Icon">
                    <h3>Welcome Discount 15% dan Cashback 15%</h3>
                    <p>Dapatkan diskon langsung sebesar 15% pada pesanan pertama dan Cashback 15% untuk semua pesanan berikutnya.</p>
                </div>

                <div class="benefit-item">
                    <img src="https://media-id-cdn.oriflame.com/contentMedia/?externalMediaId=3b7d7f2e-6f7e-46fb-8f99-b22657cba580&mimeType=image%2fsvg%2bxml&la=id-ID&imageFormat=Jpeg&q=70" alt="Welcome Program Icon">
                    <h3>Welcome Program dan Gratis Ongkos Pengiriman</h3>
                    <p>Nikmati rangkaian produk dari Welcome Program kami, dan dapatkan gratis ongkir dengan minimum pembelanjaan.</p>
                </div>

                <div class="benefit-item">
                    <img src="https://media-id-cdn.oriflame.com/contentMedia/?externalMediaId=f76c89c2-6fca-4592-9849-2002a8985450&mimeType=image%2fsvg%2bxml&la=id-ID&imageFormat=Jpeg&q=70g" alt="Affiliate Discount Icon">
                    <h3>Affiliate Discount 10%</h3>
                    <p>Dapatkan tambahan komisi 10% yang akan ditambahkan ke Oriflame Wallet dari semua pesanan teman yang Kamu rekomendasikan.</p>
                </div>
            </div>
        </section>

    </div>
</body>
</html>
