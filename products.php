<?php
include 'db.php';

$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$stmt = mysqli_prepare($conn, "SELECT name, price FROM products LIMIT ? OFFSET ?");
mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
?>
<div>
    <h3><?= htmlspecialchars($row['name']); ?></h3>
    <p>Rp <?= number_format($row['price']); ?></p>
</div>
<?php
}
?>