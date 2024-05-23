<!DOCTYPE html>
<html lang="ko">
<head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="./lib/css/style.css">
 <title>test</title>
</head>
<body>
<div id="login_wrap">
    <div>
        <h1>Login</h1>
        <form action="login.php" method="post" id="login_ok">
            <p><input type="text" name="userid" id="userid" placeholder="ID"></p>
            <p><input type="password" name="userpw" id="userpw" placeholder="Password"></p>
            <p><input type="submit" value="Login" class="login_btn"></p>
        </form>
        <p class="regist_btn"> &nbsp;<a href="regist.php">Sign Up</a></p>
    </div>
</div>
</body>