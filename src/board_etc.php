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
 $chatUser = $_SESSION['username'];

 $conn = mysqli_connect('db', 'zmfl', '4213', 'test_db');

 if(isset($_GET['board_idx']) && !empty($_GET['board_idx'])) {
    $boardIdx = $_GET['board_idx'];
 } elseif(isset($_POST['board_idx']) && !empty($_POST['board_idx'])) {
    $boardIdx = $_POST['board_idx'];
 } else {
    echo "error";
    exit;
 }

 $chatContent = mysqli_real_escape_string($conn, $_POST['chat_content']);
 
 $sql = "INSERT INTO test_chat (chat_content, chat_id, chat_user, chat_date)
         VALUES ('$chatContent', '$boardIdx', '$chatUser', now())";

 $result = mysqli_query($conn, $sql);

 if (!$result) {
    echo "error" . mysqli_error($conn);
 } else {
    echo "<script>alert('chat write success!'); location.href = 'board_content.php?board_idx=$boardIdx';</script>";
 }

 mysqli_close($conn);
?>