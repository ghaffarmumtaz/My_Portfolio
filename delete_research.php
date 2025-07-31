<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'include_Dbase.php';

$id = intval($_GET['id']);
$conn->query("DELETE FROM research WHERE id = $id");

header("Location: admin_research.php");
exit();
?>
