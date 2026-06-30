<?php

// Sebaiknya pakai .env, tapi untuk contoh ini pakai getenv dengan fallback
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'app_user';      // jangan pakai root
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'ecommerce';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal. Silakan coba lagi nanti.");
}

mysqli_set_charset($conn, "utf8mb4");

?>