<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'include_Dbase.php';
include 'header.php';
?>

<div class="container my-5">
  <h2 class="mb-4">Manage Research</h2>

  <a href="add_research.php" class="btn btn-success mb-3">Add New Research</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Link</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM research ORDER BY id DESC");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td><a href='{$row['link']}' target='_blank'>Open</a></td>
                <td>
                  <a href='edit_research.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                  <a href='delete_research.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
