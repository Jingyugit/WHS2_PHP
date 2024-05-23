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

 $userId = $_SESSION['useridx'];
 $conn = mysqli_connect('db', 'zmfl', '4213', 'test_db');

 $uploadDir = "./uploads";
 $allowedExtensions = array("jpg", "jpeg", "png", "gif");

 if (!empty($_FILES['board_path']['name'])) {
    $file = $_FILES['board_path'];
    $fileName = basename($file['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $pattern = '/^[a-zA-Z0-9_\.]+$/';
    if(!preg_match($pattern, $fileName)) {
        echo "wrong file name";
    }
    
    if (!in_array($fileExt, $allowedExtensions)) {
        echo "can't allowed file";
        exit;
    }

    $newFileName = uniqid() . "." . $fileExt;
    $destination = $uploadDir . "/" . $newFileName;

    if (!is_writable($uploadDir)) {
        echo "need authority" . $uploadDir;
        exit;
    }

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        echo "error upload file" . $file['error'];
        exit;
    }
 }

 $boardTitle = mysqli_real_escape_string($conn, $_POST['board_title']);
 $boardContent = mysqli_real_escape_string($conn, $_POST['board_content']);
 $boardPath = mysqli_real_escape_string($conn, $uploadDir);
 $boardFileName = mysqli_real_escape_string($conn, $newFileName ?? '');

 $XboardTitle = htmlspecialchars($boardTitle, ENT_QUOTES, 'UTF-8');
 $XboardContent = htmlspecialchars($boardContent, ENT_QUOTES, 'UTF-8');

 $sql = "INSERT INTO test_board (board_title, board_content, board_path, board_filename, board_date, user_id)
        VALUES ('$XboardTitle', '$XboardContent', '$boardPath', '$boardFileName', NOW(), '$userId')";

 $result = mysqli_query($conn, $sql);

 if (!$result) {
    echo "error" . mysqli_error($conn);
 } else {
    ?>
    <script>
        alert("board write success!");
        location.href = "main.php";
    </script>
    <?php
 }

 mysqli_close($conn);
?>