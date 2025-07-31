<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'include_Dbase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['skill_name']);
    $level = $conn->real_escape_string($_POST['skill_level']);
    $conn->query("INSERT INTO skills (skill_name, skill_level) VALUES ('$name', '$level')");
}
header("Location: skills_management.php");
exit();
?>
