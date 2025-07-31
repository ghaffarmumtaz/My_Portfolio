<?php
include 'include_Dbase.php';
include 'header.php';

// Fetch skills in descending order (newest first)
$result = $conn->query("SELECT * FROM skills ORDER BY id DESC");
?>

<div class="container my-5">
  <h2 class="text-center mb-4 section-title">My Skills</h2>

  <div class="row g-4">
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card skill-card p-3 text-center">
            <h5 class="mb-2"><?= htmlspecialchars($row['skill_name']) ?></h5>
            <span class="badge bg-success"><?= htmlspecialchars($row['skill_level']) ?></span>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">No skills available at the moment.</p>
    <?php endif; ?>
  </div>
</div>


