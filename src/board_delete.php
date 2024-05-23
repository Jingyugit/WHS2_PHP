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
 
 $boardIdx = mysqli_real_escape_string($conn, $_POST['board_idx']);
 settype($boardIdx, 'integer');

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

 $sql = "DELETE FROM test_board WHERE board_idx = $boardIdx";
 $result = mysqli_query($conn, $sql);

 if (!$result) {
    echo 'error' . mysqli_error($conn);
 } else {
?>
 <script>
    alert("board delete success!");
    location.href = "main.php";
 </script>
<?php
 }
 mysqli_close($conn);
?>