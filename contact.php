<?php include 'header.php'; ?>
<?php include 'include_Dbase.php'; ?>

<div class="container my-5">
  <h2 class="text-center mb-4 section-title">Contact Me</h2>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $phone = trim($_POST['phone']);
      $message = trim($_POST['message']);

      // Add country code if missing (assumes Pakistan +92)
      if (substr($phone, 0, 1) === '0') {
          $phone = '+92' . substr($phone, 1);
      }

      if ($name && $email && $phone && $message) {
          $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("ssss", $name, $email, $phone, $message);

          if ($stmt->execute()) {
              echo '<div class="alert alert-success">Message sent successfully!</div>';
          } else {
              echo '<div class="alert alert-danger">Error sending message.</div>';
          }

          $stmt->close();
      } else {
          echo '<div class="alert alert-warning">Please fill in all fields.</div>';
      }
  }
  ?>

  <form method="POST" class="contact-form">
    <div class="mb-3">
      <label class="form-label">Your Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Your Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Your WhatsApp Number</label>
      <input type="text" name="phone" class="form-control" placeholder="03XXXXXXXXX" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Your Message</label>
      <textarea name="message" rows="5" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Send Message</button>
  </form>
</div>
