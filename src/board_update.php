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
   $list .= "<li>{$row['board_title']}</li>";
 }

 $article = array(
  'title' => '',
  'content' => '',
  'file' => '',
  'name' => '',
  'time' => ''
 );

 $update = '';

 if (isset($_GET['board_idx'])) {
  $boardIdx = mysqli_real_escape_string($conn, $_GET['board_idx']);
  settype($boardIdx, 'integer');

  $boardsql = "SELECT board_title, board_content, board_path, board_filename, board_date FROM test_board WHERE board_idx = $boardIdx";
  $getResult = mysqli_query($conn, $boardsql);

  if ($getResult && mysqli_num_rows($getResult) > 0) {
      $row = mysqli_fetch_assoc($getResult);
      $article['title'] = htmlspecialchars($row['board_title']);
      $article['content'] = htmlspecialchars($row['board_content']);
      $article['file'] = htmlspecialchars($row['board_path']);
      $article['name'] = htmlspecialchars($row['board_filename']);
      $article['time'] = htmlspecialchars($row['board_date']);
      $update = 'update';
  } else {
      echo "fail to find board";
      exit;
  }
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
    <a href = "main.php">NOTICE BOARD</a>
    <h5>
      <a href = "logout.php">logout</a>
    </h5>
 </h1>
 <hr>
 <form action = "board_change.php" method="POST" enctype="multipart/form-data">
    <input type ="hidden" name = "board_idx" value = "<?=$_GET['board_idx']?>">
    <p><input type = "text" name = "board_title" id = "board_title" placeholder="title" value="<?=$article['title']?>"></p>
    <p><textarea name = "board_content" id = "board_content" placeholder = "content"><?=$article['content']?></textarea></p>
    <p>existed <a href="<?php echo $article['file'] . '/' . $article['name']; ?>" target="_blank"><?php echo $article['name']; ?></a></p>
    <input type = "image" src = "<?php echo $article['file']."/".$article['name']; ?>" name = "img" alt ="logo" class="center-image">
    <!-- <p><input type = "hidden" value = "30000" name = "MAX_FILE_SIZE"></p> -->
    <p><input type = "file" name = "board_path" id = "board_path"><?=$article['name']?></p>
    <p><input type = "submit" value = "update"></p>
 </form>
 
</body>
</html>