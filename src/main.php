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

 $sql = "SELECT * FROM test_board";
 $result = mysqli_query($conn, $sql);
 $list = '';

 while ($row = mysqli_fetch_assoc($result)) {
   $list = $list."<li><a href=\"board_content.php?board_idx={$row['board_idx']}\">{$row['board_title']}</li>";
 }

 $article = array(
  'title' => ''
 );

 $update = '';
 $info = '';

 if (isset($_GET['board_idx'])) {
  $boardIdx = mysqli_real_escape_string($conn, $_GET['board_idx']);
  settype($boardIdx, 'integer');

  $boardsql = "SELECT * FROM test_board LEFT JOIN test_user ON test_board.user_id = test_user.useridx WHERE board_idx = $boardIdx";
  $getResult = mysqli_query($conn, $boardsql);

  if ($getResult && mysqli_num_rows($getResult) > 0) {
    $row = mysqli_fetch_assoc($getResult);
    $article['title'] = htmlspecialchars($row['board_title']);
  } else {
    echo "fail to find board";
    exit;
  }

  $update = '<a href = "board_update.php?board_idx='.$_GET['board_idx'].'">update board</a>';
 }

?>
<!DOCTYPE html>
<html lang="ko">
<head>
 <title>notice board</title>
 <style>
    h1 {
      text-align: center;
    }
    h5 {
      text-align: right;
    }
 </style>
</head>
<body>
 <h1>
    <?php echo "NOTICE BOARD"?>
    <h5>
      <a href = "login_info.php">MyInfo</a>
    </h5>
    <h5>
      <a href = "logout.php">logout</a>
    </h5>
 </h1>
 <hr>
 <h5>
   <a href = "board_write.php">create board</a>
 </h5>
 <h1><?=$list?></h1>
</body>
</html>