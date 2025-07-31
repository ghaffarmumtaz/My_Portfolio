<?php include 'header.php'; ?>
<?php include 'include_Dbase.php'; ?>

<div class="container my-5">
  <h2 class="text-center mb-4">Research Work</h2>
  <div class="row">
    <?php
    $result = $conn->query("SELECT * FROM research ORDER BY id DESC");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-6 mb-4">
                    <div class="card h-100 shadow">
                      <div class="card-body">
                        <h5 class="card-title">'.htmlspecialchars($row['title']).'</h5>
                        <p class="card-text">'.htmlspecialchars($row['description']).'</p>
                        <a href="'.htmlspecialchars($row['link']).'" target="_blank" class="btn btn-primary">Read More</a>
                      </div>
                    </div>
                  </div>';
        }
    } else {
        echo "<p class='text-center'>No research work available at the moment.</p>";
    }
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>
