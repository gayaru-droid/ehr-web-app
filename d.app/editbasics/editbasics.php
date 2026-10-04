<?php
session_start();
if(!isset($_SESSION['p_id'])){
    header('location:../../login/login.php');
};
?>
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
                <p class=heading>Edit Basic Information</p>
                <p>Make your changes and update to save changes</p>
            </div>
            <div class="form">
                <form action="process.php" method="post">
                <div class="filed">
                    <label for="bgroup">Select Gender: </label><br>
                    <select name="gender" id="gender" class="gender">
                        <option value="Male" selected>Male</option>
                        <option value="Female" >Female</option>
                        </select>
                </div>
                <div class="filed">
                    <label for="bgroup">Select Blood Group: </label><br>
                    <select name="bgroup" id="bgroup" class="bgroup">
                        <option value="O+" selected>O+</option>
                        <option value="O-" >O-</option>
                        <option value="A+" >A+</option>
                        <option value="A-" >A-</option>
                        <option value="B+" >B+</option>
                        <option value="B-" >B-</option>
                        <option value="AB+" >AB+</option>
                        <option value="AB-" >AB-</option>
                        </select>
                </div>
                <div class="submit">
                    <input type="submit" value="Update" name="update">
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="sctrips.js"></script>
</html>