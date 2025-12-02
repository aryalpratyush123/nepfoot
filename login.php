<?php
require_once 'includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (empty($password)) $errors[] = 'Password required.';
    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id,name,email,password,role FROM users WHERE email=? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($user = $res->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                // login success
                unset($user['password']);
                $_SESSION['user'] = $user;
                header('Location: dashboard.php');
                exit;
            } else $errors[] = 'Invalid credentials.';
        } else $errors[] = 'Invalid credentials.';
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login - NepFoot</title><link rel="stylesheet" href="assets/style.css"></head><body>
<?php include 'parts/header.php'; ?>
<main class="container card">
  <h2>Login</h2>
  <?php if(isset($_GET['registered'])): ?><div style="color:green">Registration successful. Please login.</div><?php endif; ?>
  <?php if(!empty($errors)): ?><div style="color:red"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div><?php endif; ?>
  <form method="post">
    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <button class="btn" type="submit">Login</button>
  </form>
</main>
<?php include 'parts/footer.php'; ?>
</body></html>
