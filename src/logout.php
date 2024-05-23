<?php
 session_start();

 session_unset();
 session_destroy();
?>
<script>
    alert("logout");
    location.href = "index.php";
</script>