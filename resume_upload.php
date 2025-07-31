<?php

include "header.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}


$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);

    $target_file = $target_dir . "resume.pdf"; // overwrite with fixed name

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
        $success = "Resume uploaded successfully!";
    } else {
        $error = "Error uploading resume.";
    }
}


?>

<div class="container my-5">
  <div class="card resume-upload">
    <div class="card-header bg-primary text-white">
      Upload Resume (PDF)
    </div>
    <div class="card-body">

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-8">
          <input type="file" name="resume" accept=".pdf" class="form-control" required>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-success w-100">Upload Resume</button>
        </div>
      </form>

    </div>
  </div>
</div>
