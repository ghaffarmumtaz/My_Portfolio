<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'include_Dbase.php';
include 'header.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM research WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);

    $stmt = $conn->prepare("UPDATE research SET title=?, description=?, link=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $description, $link, $id);
    $stmt->execute();
    header("Location: admin_research.php");
    exit();
}
?>

<div class="container my-5">
  <h2>Edit Research</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" required><?= htmlspecialchars($row['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Link</label>
      <input type="url" name="link" class="form-control" value="<?= htmlspecialchars($row['link']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
<?php include 'footer.php'; ?>
