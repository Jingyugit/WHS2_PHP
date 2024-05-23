<?php
 session_start();

 if (!isset($_SESSION['useridx'])) {
    ?>
    <script>
        alert("login plz");
        location.href = "index.php";
    </script>
    <?php
    exit;
 }

 $allowedDir = 'uploads/';
 $filePath = isset($_GET['board_path']) ? $_GET['board_path'] : '';
 $fileName = basename($filePath);

 if (file_exists($filePath) && is_readable($filePath)) {
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-Length: " . filesize($filePath));
    readfile($filePath);
 } else {
    echo "file not found";
 }
?>