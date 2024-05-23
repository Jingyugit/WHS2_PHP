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
 $userName = $_SESSION['username'];

 $conn = mysqli_connect('db', 'zmfl', '4213', 'test_db');

 $sql = "SELECT * FROM test_board";
 $result = mysqli_query($conn, $sql);
 $list = '';

 while ($row = mysqli_fetch_assoc($result)) {
   $list .= "<li>{$row['board_title']}</li>";
 }

 $article = array(
  'title' => '',
  'content' => '',
  'file' => '',
  'name' => '',
  'time' => '',
  'username' => ''
 );

 $update = '';
 $delete = '';
 $u_name = '';
 $chats = '';

 if (isset($_GET['board_idx'])) {
  $boardIdx = mysqli_real_escape_string($conn, $_GET['board_idx']);
  settype($boardIdx, 'integer');

  if (!isset($_SESSION['boardHit'])) {
    $_SESSION['boardHit'] = array();
  }

  if (!in_array($boardIdx, $_SESSION['boardHit'])) {
    $updateSql = "UPDATE test_board SET board_hits = board_hits + 1 WHERE board_idx = $boardIdx";
    mysqli_query($conn, $updateSql);
    $_SESSION['boardHit'][] = $boardIdx;
  }

  $boardsql = "SELECT * FROM test_board LEFT JOIN test_user ON test_board.user_id = test_user.useridx WHERE board_idx = $boardIdx";
  $getResult = mysqli_query($conn, $boardsql);

  if ($getResult && mysqli_num_rows($getResult) > 0) {
    $row = mysqli_fetch_assoc($getResult);
    $article['title'] = htmlspecialchars($row['board_title']);
    $article['content'] = htmlspecialchars($row['board_content']);
    $article['file'] = htmlspecialchars($row['board_path']);
    $article['name'] = htmlspecialchars($row['board_filename']);
    $article['time'] = htmlspecialchars($row['board_date']);
    $article['username'] = htmlspecialchars($row['username']);
    $article['hits'] = $row['board_hits'];
  } else {
    echo "fail to find board";
    exit;
  }

  $chatsql = "SELECT * FROM test_chat WHERE chat_id = $boardIdx ORDER BY chat_date ASC";
  $chatResult = mysqli_query($conn, $chatsql);

  if ($chatResult && mysqli_num_rows($chatResult) > 0) {
    while ($chatRow = mysqli_fetch_assoc($chatResult)) {
      $chats .= '<div class="comment">';
      $chats .= '<p>' . htmlspecialchars($chatRow['chat_content']) . ' <h5>' .htmlspecialchars($chatRow['chat_user']).'&nbsp&nbsp' . htmlspecialchars($chatRow['chat_date']) . '</h5></p>';
      $chats .= '</div>';

      if ($_SESSION['username'] === $chatRow['chat_user']) {
        $chats .= '<form action="board_chat_delete.php" method="post">
                    <input type="hidden" name="comment_idx" value="' . $chatRow['chat_idx'] . '">
                    <input type="hidden" name="board_idx" value="' . $boardIdx . '">
                    <h5><input type="submit" value="delete"></h5>
                  </form>';
      } else {
        $chats .= '<br>';
      }
    }
  }

  $update = '<a href = "board_update.php?board_idx='.$_GET['board_idx'].'">update board</a>';
  $delete = '
    <form action = "board_delete.php" method = "post">
      <input type = "hidden" name = "board_idx" value = "'.$_GET['board_idx'].'">
      <input type = "submit" value = "delete">
    </form>
  ';
  $u_name = "<p> {$article['username']}</p>";
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
    .center-image {
        display: block;
        margin: 0 auto;
    }
    .chat-group {
      text-align: center;
    }
    .chat-group textarea{
      width: 400px;
      height: 60px;
      padding: 10px;
      resize: none;
    }
 </style>
</head>
<body>
 <h1>
    <a href = "main.php">NOTICE BOARD</a>
    <h5>
      <a href = "logout.php">logout</a>
    </h5>
 </h1>
 <hr>
 <h5>
   <a href = "board_write.php">create board</a>
 </h5>
 <h5><?=$update?></h5>
 <h5><?=$delete?></h5>
 <h1><?=$article['title']?></h1>
 <h1><?=$article['content']?></h1>
 <input type = "image" src = "<?php echo $article['file']."/".$article['name']; ?>" name = "img" alt ="board" class="center-image">
 <h1><a href = "uploads/<?php echo $article['name']; ?>" download><?php echo $article['name']; ?></a></h1>
 <h5>HIT:  <?php echo $article['hits']; ?></h5>
 <h5><?=$u_name?></h5>
 <h5><?=$article['time']?></h5>
 <hr>
 <br>
 <br>
 <form action="board_etc.php" method="POST">
    <input type="hidden" name="board_idx" value="<?php echo $_GET['board_idx']; ?>">
    <div class="chat-group">
      <textarea name="chat_content" id="chat_content" placeholder="chat"></textarea>
      <input type="submit" value="post" class="chat_btn">
    </div>
 </form>
 <h5>chat</h5>
 <div class="chat-group">
    <?php echo $chats; ?>
 </div>
</body>
</html>