<?php
include 'koneksi.php';

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['nama_produk'] . "</h3>";
        echo "<p>Rp " . $row['harga'] . "</p>";
        echo "<img src='" . $row['gambar'] . "' alt='" . $row['nama_produk'] . "' width='200px'>";
        echo "<a href='add_to_cart.php?id=" . $row['id_produk'] . "'>Tambah ke Keranjang</a>";
        echo "</div>";
    }
} else {
    echo "Tidak ada produk.";
}
?>
