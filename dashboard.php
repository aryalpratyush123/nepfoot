<?php
require_once 'includes/functions.php';
require_login();
$user = current_user();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Dashboard - NepFoot</title><link rel="stylesheet" href="assets/style.css"></head><body>
<?php include 'parts/header.php'; ?>
<main class="container card">
  <h2>Dashboard</h2>
  <p>Welcome, <?php echo esc($user['name']); ?> (<?php echo esc($user['role']); ?>)</p>
  <?php if($user['role'] === 'admin'): ?>
    <ul>
      <li><a href="admin/products.php">Manage Products</a></li>
      <li><a href="admin/users.php">Manage Users</a></li>
    </ul>
  <?php elseif($user['role'] === 'seller'): ?>
    <ul>
      <li><a href="seller/products.php">My Products</a></li>
    </ul>
  <?php else: ?>
    <p><a href="products.php">Browse Products</a></p>
  <?php endif; ?>
</main>
<?php include 'parts/footer.php'; ?>
</body></html>
