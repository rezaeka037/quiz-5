<?php
session_start();
include 'db.php';

// Wajib login, dan hanya boleh lihat profil sendiri
if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

$id = $_SESSION['user_id']; // ambil dari session, bukan dari GET

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan.");
}
?>

<h1><?= htmlspecialchars($data['name']); ?></h1>
<p><?= htmlspecialchars($data['email']); ?></p>