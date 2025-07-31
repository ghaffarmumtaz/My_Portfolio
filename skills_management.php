<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'include_Dbase.php';

// Fetch all skills in ASC order (oldest first)
$result = $conn->query("SELECT * FROM skills ORDER BY id ASC");
include 'header.php';
?>

<div class="container my-5">
  <h2 class="text-center mb-4 section-title">Manage Skills</h2>

  <!-- Add Skill Form -->
  <form action="add_skill.php" method="POST" class="row g-3 mb-4">
    <div class="col-md-6">
      <input type="text" name="skill_name" class="form-control" placeholder="Skill Name" required>
    </div>
    <div class="col-md-4">
      <select name="skill_level" class="form-select" required>
        <option value=""> Level</option>
        <option value="Beginner">Beginner</option>
        <option value="Intermediate">Intermediate</option>
        <option value="Expert">Expert</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Add</button>
    </div>
  </form>

  <!-- Skills Table -->
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Skill</th>
        <th>Level</th>
        <th>Created</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php $i = 1; while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['skill_name']) ?></td>
            <td><?= htmlspecialchars($row['skill_level']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
              <a href="edit_skill.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="delete_skill.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this skill?')" class="btn btn-sm btn-danger">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5" class="text-center">No skills found</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
