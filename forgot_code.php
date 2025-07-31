<?php
session_start();
include 'include_Dbase.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $code = rand(100000, 999999);
        $expires = time() + 300;

        // Store code in session
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code'] = $code;
        $_SESSION['reset_expires'] = $expires;

        // You would send the code via email here.
        // For local testing, just show it.
        $success = "Verification code sent to <strong>$email</strong>. Use this: <code>$code</code>";
        // TODO: Use mail() function or SMTP for real sending.
    } else {
        $error = "Email not found.";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container my-5 auth-wrapper">
  <h2 class="text-center section-title">Forgot Password</h2>

  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

  <form method="POST" class="auth-form">
    <i
