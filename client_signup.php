<?php
session_start();
include 'include_Dbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM clients WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "⚠️ This email is already registered. Please login or use a different email.";
    } else {
        $stmt = $conn->prepare("INSERT INTO clients (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['client_logged_in'] = true;
            $_SESSION['client_name'] = $name;
            header("Location: index.php");
            exit();
        } else {
            $error = "Something went wrong while registering. Please try again.";
        }
    }
}
?>

<?php include 'header.php'; ?>
<div class="container my-5">
  <h2 class="text-center section-title">Client Sign Up</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="auth-form">
    <input type="text" name="name" class="form-control mb-3" placeholder="Your Name" required>
    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
    <button type="submit" class="btn btn-success w-100">Sign Up</button>
  </form>
</div>
