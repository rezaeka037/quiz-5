<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login.");
}

$user_id = $_SESSION['user_id']; // bukan dari POST
$product_id = (int)($_POST['product_id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 0);

if ($product_id <= 0 || $qty <= 0) {
    die("Data order tidak valid.");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Produk tidak ditemukan.");
}

$total = $product['price'] * $qty;

mysqli_begin_transaction($conn);
try {
    $stmt2 = mysqli_prepare($conn,
        "INSERT INTO orders (user_id, product_id, qty, total) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt2, "iiid", $user_id, $product_id, $qty, $total);
    mysqli_stmt_execute($stmt2);

    mysqli_commit($conn);
    echo "Order berhasil";
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Order gagal, silakan coba lagi.";
}

?>