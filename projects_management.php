<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'include_Dbase.php';

// ✅ Handle Add Project
if (isset($_POST['add_project'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $link = $conn->real_escape_string($_POST['project_link']);
    $conn->query("INSERT INTO projects (title, description, project_link) VALUES ('$title', '$desc', '$link')");
    header("Location: projects_management.php");
    exit();
}

// ✅ Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM projects WHERE id = $id");
    header("Location: projects_management.php");
    exit();
}

// ✅ Get All Projects
$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");

include 'header.php';
?>

<div class="container my-5">
  <h2 class="text-center section-title">Manage Projects</h2>

  <!-- Add Project Form -->
  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="title" class="form-control" placeholder="Project Title" required>
    </div>
    <div class="col-md-5">
      <input type="text" name="project_link" class="form-control" placeholder="Project URL (optional)">
    </div>
    <div class="col-md-3">
      <button type="submit" name="add_project" class="btn btn-primary w-100">Add Project</button>
    </div>
    <div class="col-12">
      <textarea name="description" class="form-control" placeholder="Project Description" rows="3" required></textarea>
    </div>
  </form>

  <!-- Project Table -->
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Link</th>
        <th>Created</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php $i = 1; while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
            <td>
              <?php if (!empty($row['project_link'])): ?>
                <a href="<?= $row['project_link'] ?>" target="_blank">View</a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?= $row['created_at'] ?></td>
            <td>
              <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this project?')" class="btn btn-sm btn-danger">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">No projects found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
