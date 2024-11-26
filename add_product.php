<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];

    // Handle image upload
    $image_path = 'images/' . basename($_FILES['product_image']['name']);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path);

    // Insert product into cart
    $sql = "INSERT INTO cart (product_name, product_price, quantity, product_image) VALUES ('$product_name', '$product_price', '$quantity', '$image_path')";
    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
