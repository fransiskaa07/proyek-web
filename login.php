<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css"/>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>HelloBuddy</h1>
            <img src="img/logo2.jpg" alt="Logo">
        </div>
        <div class="login-card">
            <p class="login-box-msg">Please sign in to continue</p>
            <form action="ceklogin.php" method="post">
                <div class="input-group">
                    <input name="Username" type="text" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <input name="Password" type="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
