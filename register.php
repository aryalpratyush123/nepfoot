<?php
require_once 'includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'customer';

    $errors = [];
    if (strlen($name) < 3) $errors[] = 'Name must be at least 3 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if (!in_array($role, ['admin','seller','customer'])) $role = 'customer';

    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email=?');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $ins = $conn->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
            $ins->bind_param('ssss',$name,$email,$hash,$role);
            if ($ins->execute()) {
                header('Location: login.php?registered=1');
                exit;
            } else {
                $errors[] = 'Database error.';
            }
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Register - NepFoot</title><link rel="stylesheet" href="assets/style.css"></head><body>
<?php include 'parts/header.php'; ?>
<main class="container card">
  <h2>Register</h2>
  <?php if(!empty($errors)): ?><div style="color:red"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
  <form method="post" novalidate>
    <div class="form-group"><label>Name</label><input type="text" name="name" required minlength="3" value="<?php echo isset($name)?htmlspecialchars($name):''; ?>"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="<?php echo isset($email)?htmlspecialchars($email):''; ?>"></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required minlength="6"></div>
    <div class="form-group"><label>Role</label>
      <select name="role">
        <option value="customer">Customer</option>
        <option value="seller">Seller</option>
      </select>
    </div>
    <button class="btn" type="submit">Register</button>
  </form>
</main>
<?php include 'parts/footer.php'; ?>
</body></html>
