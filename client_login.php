<?php
session_start();
include 'include_Dbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashed);
        $stmt->fetch();

        if (password_verify($password, $hashed)) {
            $_SESSION['client_logged_in'] = true;
            $_SESSION['client_name'] = $name;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "No account found.";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container my-5">
  <h2 class="text-center section-title">Client Login</h2>

  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

  <form method="POST" class="auth-form">
    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="admin_login">
    <a href="forgot_code.php">Forgot Password?</a><br>
    <a href="admin_panel.php">Admin Login?</a>
     </div> 
  </form>
</div>
