<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'include_Dbase.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);

    $stmt = $conn->prepare("INSERT INTO research (title, description, link) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $link);
    $stmt->execute();
    header("Location: admin_research.php");
    exit();
}
?>

<div class="container my-5">
  <h2>Add Research</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Link</label>
      <input type="url" name="link" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Add</button>
  </form>
</div>
<?php include 'footer.php'; ?>
