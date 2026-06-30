<?php
session_start();
include 'db.php';

if (!isset($_SESSION['login']) || ($_SESSION['role'] ?? '') !== 'admin') {
    die("Akses ditolak. Halaman ini khusus admin.");
}

$query = "
    SELECT o.id, o.total, u.name AS user_name, p.name AS product_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
";

$result = mysqli_query($conn, $query);
?>

<table border="1">
<tr><th>Nama User</th><th>Produk</th><th>Total</th></tr>
<?php while ($order = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= htmlspecialchars($order['user_name']); ?></td>
    <td><?= htmlspecialchars($order['product_name']); ?></td>
    <td>Rp <?= number_format($order['total']); ?></td>
</tr>
<?php } ?>
</table>