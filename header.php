<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔔 Admin unread message count
$unread = 0;
if (isset($_SESSION['admin_logged_in'])) {
    include_once 'include_Dbase.php';
    $noti_result = $conn->query("SELECT COUNT(*) as unread FROM messages WHERE is_read = 0");
    $unread = $noti_result->fetch_assoc()['unread'];
}

// 🧠 Detect current page & admin tools
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin_page = in_array($current_page, [
  'admin_panel.php', 
  'skills_management.php', 
  'projects_management.php', 
  'resume_upload.php'
]);

// 🌐 Admin toggle logic (if not set, default to 2 - admin view)
if (!isset($_SESSION['admin_home_toggle'])) {
    $_SESSION['admin_home_toggle'] = 2;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Abdul Ghaffar | Portfolio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<body>

<!-- ✅ Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <!-- 🔁 HOME Brand -->
    <?php if (isset($_SESSION['admin_logged_in'])): ?>
      <a class="navbar-brand" href="admin_panel.php?admin_toggle_home=1"><i class="fas fa-house"></i> HOME</a>
    <?php else: ?>
      <a class="navbar-brand" href="index.php"><i class="fas fa-house"></i> HOME</a>
    <?php endif; ?>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
      <!-- Left Links -->
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_home_toggle'] === 2): ?>
          <!-- 🛠 Admin Panel Links -->
          <li class="nav-item">
            <a class="nav-link" href="admin_panel.php">
              Messages
              <?php if ($unread > 0): ?>
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1 rounded-circle">
                  <?= $unread ?>
                </span>
              <?php endif; ?>
            </a>
          </li>
          <li class="nav-item"><a class="nav-link" href="skills_management.php">Skills Management</a></li>
          <li class="nav-item"><a class="nav-link" href="projects_management.php">Projects Management</a></li>
          <li class="nav-item"><a class="nav-link" href="resume_upload.php">Upload Resume</a></li>
          <li class="nav-item">
            <li> <a class="nav-link" href="manage_research.php">Manage Research</a>
                    </li>

        <?php elseif (
          (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_home_toggle'] === 1) || 
          isset($_SESSION['client_logged_in'])
        ): ?>
          <!-- 👤 Client View -->
          <li class="nav-item"><a class="nav-link" href="projects.php">Projects</a></li>
          <li class="nav-item"><a class="nav-link" href="skills.php">Skills</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <?php endif; ?>
      </ul>

      <!-- Right Links -->
      <ul class="navbar-nav">
        <?php if (isset($_SESSION['admin_logged_in'])): ?>
          <li class="nav-item"><a class="nav-link" href="admin_logout.php">Admin Logout</a></li>
        <?php elseif (isset($_SESSION['client_logged_in'])): ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="client_login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="client_signup.php">Signup</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<!-- ✅ Navbar End -->



