<?php
 $conn = mysqli_connect('db', 'zmfl', '4213', 'test_db');

 $uid = mysqli_real_escape_string($conn, $_POST['userid']);
 $upw = mysqli_real_escape_string($conn, $_POST['userpw']);

 $sql = "SELECT useridx, userid, userpw, username, loginLimit, userLocked FROM test_user WHERE userid = '{$uid}'";

 $result = mysqli_query($conn, $sql);

 if ($result && mysqli_num_rows($result) == 1) {
   $row = mysqli_fetch_assoc($result);

   if ($row['userLocked'] == 1) {
      ?>
      <script>
          alert("call manager");
          location.href = "index.php";
      </script>
      <?php
      exit;
   }

   if ($row['userpw'] == $upw) {
      $resetLimit = "UPDATE test_user SET loginLimit = 0 WHERE userid = '{$uid}'";
      mysqli_query($conn, $resetLimit);


      session_start();
      session_regenerate_id();
      $_SESSION['userid'] = $row['userid'];
      $_SESSION['useridx'] = $row['useridx'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['boardHit'] = array();
?>
   <script>
      alert("login success!");
      location.href = "main.php";
   </script>
<?php
   } else {
      $updateLimit = "UPDATE test_user SET loginLimit = loginLimit + 1 WHERE userid = '{$uid}'";
      mysqli_query($conn, $updateLimit);

      $loginLimitLeft = 5 - $row['loginLimit'];
        if ($loginLimitLeft <= 0) {
            $lockAccount = "UPDATE test_user SET userlocked = 1 WHERE userid = '{$uid}'";
            mysqli_query($conn, $lockAccount);

            ?>
            <script>
                alert("call manager");
                location.href = "index.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Login failed <?php echo $loginLimitLeft; ?> left.");
                location.href = "index.php";
            </script>
            <?php
        }
   }
 } else {
?>
   <script>
      alert("login fail");
      location.href = "index.php";
   </script>
<?php
}
?>