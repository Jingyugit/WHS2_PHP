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

 if (isset($_POST['comment_idx']) && isset($_POST['board_idx'])) {
    $commentIdx = $_POST['comment_idx'];
    $boardIdx = $_POST['board_idx'];
    
    $userSql = "SELECT username FROM test_user WHERE useridx = $userId";
    $userResult = mysqli_query($conn, $userSql);
    $userRow = mysqli_fetch_assoc($userResult);
    $chatUser = $userRow['username'];

    $deleteSql = "DELETE FROM test_chat WHERE chat_idx = $commentIdx AND chat_user = '$chatUser'";
    $deleteResult = mysqli_query($conn, $deleteSql);

    if ($deleteResult && mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('chat delete complete'); location.href = 'board_content.php?board_idx=$boardIdx';</script>";
    } else {
        echo "<script>alert('need authority'); location.href = 'board_content.php?board_idx=$boardIdx';</script>";
    }
 }
 mysqli_close($conn);
?>