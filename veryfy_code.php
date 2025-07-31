<?php
session_start();
include 'include_Dbase.php';

$error = "";
$success = "";

// Step 1: Verify code
if (isset($_POST['verify_code'])) {
    $input = trim($_POST['code']);
    if (!isset($_SESSION['reset_code'], $_SESSION['reset_expires']) || time() > $_SESSION['reset_expires']) {
        $error = "Code expired. Please try again.";
    } elseif ($input == $_SESSION['reset_code']) {
        $_SESSION['verified'] = true;
        $success = "Code verified. Now set a new password.";
    } else {
        $error = "Invalid code.";
    }
}

// Step 2: Update password
if (isset($_POST['set_password']) && isset($_SESSION['verified']) && $_SESSION['verified']) {
    $new_pass = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("UPDATE clients SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_pass, $email);
    if ($stmt->execute()) {
        session_unset();
        session_destroy();
        header("Location: client_login.php");
        exit();
    } else {
        $error = "Something went wrong.";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container my-5 auth-wrapper">
  <h2 class="text-center section-title">Verify & Reset</h2>

  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

  <?php if (empty($_SESSION['verified'])): ?>
    <form method="POST" class="auth-form">
      <input type="text" name="code" class="form-control mb-3" placeholder="Enter verification code" required>
      <button type="submit" name="verify_code" class="btn btn-primary w-100">Verify Code</button>
    </form>
  <?php else: ?>
    <form method="POST" class="auth-form">
      <input type="password" name="new_password" class="form-control mb-3" placeholder="New password" required>
      <button type="submit" name="set_password" class="btn btn-success w-100">Set New Password</button>
    </form>
  <?php endif; ?>
</div>
