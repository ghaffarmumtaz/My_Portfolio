<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'include_Dbase.php';
include 'mail_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = intval($_POST['message_id']);
    $reply = trim($_POST['reply']);
    
    // Get client email & name
    $stmt = $conn->prepare("SELECT name, email FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    $stmt->fetch();
    $stmt->close();

    if ($name && $email && $reply) {
        $subject = "Reply to Your Message";
        $sent = sendMailToClient($email, $name, $subject, nl2br($reply));
        
        if ($sent) {
            $update = $conn->prepare("UPDATE messages SET status='Replied', reply=? WHERE id=?");
            $update->bind_param("si", $reply, $message_id);
            $update->execute();
            $update->close();
            header("Location: admin_panel.php?sent=1");
        } else {
            header("Location: admin_panel.php?sent=0");
        }
    }
}
