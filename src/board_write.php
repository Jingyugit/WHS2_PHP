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
 <form action = "board_create.php" method="POST" enctype="multipart/form-data">
    <p><input type = "text" name = "board_title" id = "board_title" placeholder="title"></p>
    <p><textarea name = "board_content" id = "board_content" placeholder = "content"></textarea></p>
    <!--<p><input type = "hidden" value = "30000" name = "MAX_FILE_SIZE"></p>-->
    <p><input type = "file" name = "board_path" id = "board_path"></p>
    <p><input type = "submit" value = "write"></p>
 </form>
 
</body>
</html>