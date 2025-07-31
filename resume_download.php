<?php
$resume_path = "uploads/resume.pdf";

if (file_exists($resume_path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="AbdulGhaffar_Resume.pdf"');
    readfile($resume_path);
    exit();
} else {
    echo "Resume not found.";
}
?>
