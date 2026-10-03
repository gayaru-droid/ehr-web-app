<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="title">
                <p class=heading>Start Today</p>
                <p>Welcome to SyncMedi,Your beloved medicare</p>
            </div>
            <div class="form">
                <form action="process.php" method="post">
                <div class="name">
                    <div class="filed">
                    <label for="fname">First Name: </label><br>
                    <input type="text" name="fname" id="fname">
                    </div>
                    <div class="filed">
                        <label for="lname">Last Name: </label><br>
                        <input type="text" name="lname" id="lname">
                    </div>
                </div>
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
                <div class="filed">
                    <label for="nic">National ID Card No: </label><br>
                    <input type="text" name="nic" id="nic">
                </div>
                <div class="filed">
                    <label for="dob">Date of Birth: </label><br>
                    <input type="date" name="dob" id="dob">
                </div>
                <div class="filed">
                    <select name="role" id="role" class="role">
                        <option value="patient" selected>Patient</option>
                        <option value="doctor" >Doctor</option>
                        </select>
                </div>
                <div class="submit">
                    <input type="submit" value="register" name="register">
                </div>
                </form>
            </div>
            <div class="end">
                <p>If you already have an account?</p><a href="../login/login.php">Login</a>
            </div>
        </div>
    </div>
</body>
<script src="sctrips.js"></script>
</html>