<?php
 $conn = mysqli_connect('db', 'zmfl', '4213', 'test_db');

 $userId = mysqli_real_escape_string($conn, $_POST['userid']);
 $userPw = mysqli_real_escape_string($conn, $_POST['userpw']);
 $userName = mysqli_real_escape_string($conn, $_POST['username']);
 $userPhone = mysqli_real_escape_string($conn, $_POST['userphone']);
 $userEmail = mysqli_real_escape_string($conn, $_POST['useremail']);
 
 if (empty($userId) || empty($userPw) || empty($userName) || empty($userPhone) || empty($userEmail)) {
   echo "<script>alert('input all'); location.href = 'regist.php';</script>";
   exit;
 }

 $sql = "SELECT * FROM test_user WHERE userid = '$userId'";
 $result = mysqli_query($conn, $sql);

 if (mysqli_num_rows($result) > 0) {
   echo "<script>alert('existing id'); location.href = 'regist.php';</script>";
   exit;
 }

 $sql = "INSERT INTO test_user
         (userid, userpw, username, userphone, useremail, regdate)
         VALUES
         ('$userId', '$userPw', '$userName', '$userPhone', '$userEmail', NOW())";
 $result = mysqli_query($conn, $sql);

 if ($result === false) {
    echo 'error';
    error_log(mysqli_error($conn));
 } else {
?>
 <script>
    alert("registration success!");
    location.href = "index.php";
 </script>
<?php
 }
 mysqli_close($conn);
?>