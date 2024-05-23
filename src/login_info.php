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

 $sql = $sql = "SELECT * FROM test_user WHERE useridx = $userId";
 $result = mysqli_query($conn, $sql);
 $list = '';

 if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $userName = htmlspecialchars($row['username']);
    $userPhone = htmlspecialchars($row['userphone']);
    $userEmail = htmlspecialchars($row['useremail']);
    $regDate = htmlspecialchars($row['regdate']);
 } else {
    echo "fail to find board";
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
 <h1>name: &nbsp;<?=$userName?></h1>
 <h1>phone: &nbsp;<?=$userPhone?></h1>
 <h1>email: &nbsp;<?=$userEmail?></h1>
 <h1>creation date: &nbsp;<?=$regDate?></h1>
</body>