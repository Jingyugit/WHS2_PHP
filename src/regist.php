<!DOCTYPE html>
<html lang="ko">
<head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="./lib/css/style.css">
 <title>regist</title>
</head>
<body>
    <div id="regist_wrap" class="wrap">
        <div>
            <h1>Registration</h1>
            <form action="regist_ok.php" method="post" name="regiform" id="regist_form" class="form" onsubmit="return sendit()">
                <p><input type="text" name="userid" id="userid" placeholder="ID"></p>
                <p><input type="password" name="userpw" id="userpw" placeholder="Password"></p>
                <p><input type="password" name="userpw_ch" id="userpw_ch" placeholder="Check Password"></p>
                <p><input type="text" name="username" id="username" placeholder="Name"></p>
                <p><input type="text" name="userphone" id="userphone" placeholder="Phone Number"></p>
                <p><input type="text" name="useremail" id="useremail" placeholder="E-mail"></p>
                <p><input type="submit" value="Sign Up" class="signup_btn"></p>
                <a href = "index.php">login</a>
            </form>
        </div>
    </div>
</body>
