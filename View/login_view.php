<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập T-eComm</title>
    <link rel="stylesheet" href="View/css/fontawesome/css/all.css">
    <link rel="stylesheet" href="View/css/login.css">
</head>

<body>
    <div class="container">
        <div class="h1">
            <h1>T - eComm LOGIN</h1>
        </div>
        <div class="form">
            <form action="index.php" method="post">
                <input type="hidden" name="control" value="require_login">
                <div class="lable">
                    <p id="label">Login Now</p>
                </div>
                <div class="account" style="display:flex">
                    <input id="user" name="account" type="text" placeholder="Account">
                    <i id="user_icon" class="fas fa-user"></i>
                </div>
                <div class="password" style="display:flex">
                    <input id="pass" name="password" type="password" placeholder="Password">
                    <i id="pass_icon" class="fas fa-lock"></i>
                </div>
                <div class="button">
                    <button>Login</button>
                </div>
                <label id="errorLogin"><?= $error_login ?></label>

                <div class="notRemember">
                    <label style="color: white;">Not a member?</label>
                    <a href="index.php?router=customer&control=register" style="color: orange;">Signup now</a>
                </div>
                <div class="forgotPass">
                    <label style="color: white;">Forgot password?</label>
                    <a href="index.php?router=customer&control=forgot_password" style="color: orange;">Click here</a>
                </div>

                <br><br><br>
            </form>
        </div>
        <div class="footer">
            <label>T-eComm for sale 06-2020 $</label>
        </div>
    </div>
</body>

</html>