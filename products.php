<?php
require_once 'includes/functions.php';
$q = '';
if (!empty($_GET['q'])) $q = $conn->real_escape_string($_GET['q']);
$sql = "SELECT p.*, u.name as seller_name FROM products p LEFT JOIN users u ON p.seller_id=u.id";
if ($q) $sql .= " WHERE p.name LIKE '%$q%' OR p.brand LIKE '%$q%'";
$res = $conn->query($sql);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Products - NepFoot</title><link rel="stylesheet" href="assets/style.css"></head><body>
<?php include 'parts/header.php'; ?>
<main class="container">
  <h2>Products</h2>
  <form method="get"><input type="text" name="q" placeholder="search" value="<?php echo htmlspecialchars($q); ?>"> <button class="btn">Search</button></form>
  <?php while($row = $res->fetch_assoc()): ?>
    <div class="card">
      <h3><?php echo esc($row['name']); ?> - Rs <?php echo esc($row['price']); ?></h3>
      <p><strong>Brand:</strong> <?php echo esc($row['brand']); ?> | <strong>Size:</strong> <?php echo esc($row['size']); ?></p>
      <p><?php echo nl2br(esc($row['description'])); ?></p>
      <p><small>Seller: <?php echo esc($row['seller_name'] ?? 'Admin'); ?></small></p>
    </div>
  <?php endwhile; ?>
</main>
<?php include 'parts/footer.php'; ?>
</body></html>
