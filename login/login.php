<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="title">
                <p class=heading>Welcome</p>
                <p>Welcome back to SyncMedi,Your beloved medi care</p>
            </div>
            <div class="form">
                <form action="process.php" method="post">
                <div class="filed">
                    <label for="username">Username: </label><br>
                    <input type="text" name="username" id="username">
                </div>
                <div class="filed">
                    <label for="password">Password: </label><br>
                    <div class=input-group>
                        <input type="password" name="password" id="password">
                        <div class="pwtoggle">
                            <p id='show'>Show</p>
                            <p id="hide">Hide</p>
                        </div>
                    </div>
                </div>
                <div class="submit">
                    <input type="submit" value="Login" name="login">
                </div>
                </form>
            </div>
            <div class="end">
                <p>If you dont have an account?</p><a href="../register/register.php">Register</a>
            </div>
        </div>
    </div>
</body>
<script src="sctrips.js"></script>
</html>