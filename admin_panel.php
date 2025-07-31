<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'include_Dbase.php';

// WhatsApp reply processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    $id = intval($_POST['message_id']);
    $reply = trim($_POST['reply']);
    $whatsapp = $_POST['client_whatsapp'];

    if ($reply && $whatsapp) {
        $conn->query("UPDATE messages SET status = 'Replied' WHERE id = $id");
        $_SESSION['whatsapp_link'] = "https://wa.me/" . urlencode($whatsapp) . "?text=" . urlencode($reply);
        $_SESSION['reply_success'] = "WhatsApp reply link generated.";
    } else {
        $_SESSION['reply_error'] = "Reply or WhatsApp number missing.";
    }

    header("Location: admin_panel.php");
    exit();
}
?>

<?php include 'header.php'; ?>
<div class="container my-5">
    <h2 class="mb-4">Admin Panel - WhatsApp Replies</h2>

    <?php
    if (isset($_SESSION['reply_success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['reply_success'] . '</div>';
        unset($_SESSION['reply_success']);
    }
    if (isset($_SESSION['reply_error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['reply_error'] . '</div>';
        unset($_SESSION['reply_error']);
    }
    if (isset($_SESSION['whatsapp_link'])) {
        echo '<a class="btn btn-success mb-3" href="' . $_SESSION['whatsapp_link'] . '" target="_blank">Send via WhatsApp</a>';
        unset($_SESSION['whatsapp_link']);
    }

    $result = $conn->query("SELECT * FROM messages ORDER BY id DESC");

    while ($row = $result->fetch_assoc()) {
        echo '<div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">From: ' . htmlspecialchars($row['name']) . '</h5>
                <p><strong>WhatsApp:</strong> ' . htmlspecialchars($row['phone']) . '</p>
                <p><strong>Message:</strong> ' . htmlspecialchars($row['message']) . '</p>
                <p><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>';

        echo '<form method="POST" class="mt-3">
            <input type="hidden" name="message_id" value="' . $row['id'] . '">
            <input type="hidden" name="client_whatsapp" value="' . htmlspecialchars($row['phone']) . '">

            <div class="mb-2">
                <textarea name="reply" rows="3" class="form-control" placeholder="Type your WhatsApp reply..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Generate WhatsApp Reply</button>
        </form>
        </div></div>';
    }
    ?>

   
    
</div>
