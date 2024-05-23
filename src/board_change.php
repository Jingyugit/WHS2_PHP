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

 $boardIdx = mysqli_real_escape_string($conn, $_POST['board_idx']);
 settype($boardIdx, 'integer');

 $boardTitle = mysqli_real_escape_string($conn, $_POST['board_title']);
 $boardContent = mysqli_real_escape_string($conn, $_POST['board_content']);

 $XboardTitle = htmlspecialchars($boardTitle, ENT_QUOTES, 'UTF-8');
 $XboardContent = htmlspecialchars($boardContent, ENT_QUOTES, 'UTF-8');

 $checkUser = "SELECT user_id FROM test_board WHERE board_idx = $boardIdx";
 $checkResult = mysqli_query($conn, $checkUser);

 if ($checkUser && mysqli_num_rows($checkResult) > 0) {
    $userRow = mysqli_fetch_assoc($checkResult);
    $uuser = $userRow['user_id'];

    if ($uuser != $userId) {
        ?>
        <script>
            alert("need authority");
            location.href = "main.php";
        </script>
        <?php
        exit;
    }
 } else {
    echo "fail to find board";
    exit;
 }

 $uploadDir = "./uploads";
 $allowedExtensions = array("jpg", "jpeg", "png", "gif");

 if (!empty($_FILES['board_path']['name'])) {
    $file = $_FILES['board_path'];
    $fileName = basename($file['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $pattern = '/^[a-zA-Z0-9_\.]+$/';
    if (!preg_match($pattern, $fileName)) {
        echo "Invalid file name";
        exit;
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

    $boardPath = mysqli_real_escape_string($conn, $uploadDir);
    $boardFileName = mysqli_real_escape_string($conn, $newFileName);

    $sql = "UPDATE test_board SET board_title = '$XboardTitle', board_content = '$XboardContent', board_path = '$boardPath', board_filename = '$boardFileName', board_date = NOW() WHERE board_idx = $boardIdx AND user_id = $userId";
 } else {
    $sql = "UPDATE test_board SET board_title = '$XboardTitle', board_content = '$XboardContent', board_date = NOW() WHERE board_idx = $boardIdx AND user_id = $userId";
 }

 $result = mysqli_query($conn, $sql);
 
 if (!$result) {
    echo 'error' . mysqli_error($conn);
 } else {
?>
 <script>
    alert("board update success!");
    location.href = "main.php";
 </script>
<?php
 }
 mysqli_close($conn);
?>