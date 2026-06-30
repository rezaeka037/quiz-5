<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
    die("Akses ditolak.");
}

$id = $_SESSION['user_id']; // bukan dari $_POST, supaya tidak bisa edit user lain
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Data tidak valid.");
}

$stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $id);
mysqli_stmt_execute($stmt);

echo "Berhasil";

?>