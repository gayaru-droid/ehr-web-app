<?php
session_start();
include('../dbcon.php');
if(!isset($_SESSION['username'])) {
    header('location:../login/login.php');
    exit();
}
if (isset($_GET['endsession'])) {
    $stmt=$conn->prepare("UPDATE admit SET status='ended' WHERE otp=?");
    $stmt->bind_param("i", $_SESSION['otp']);
    $stmt->execute();
    session_destroy();
    header('location:../doctorsend/addmission.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors app</title>
</head>
<body>
    <h1>Hello doctor</h1>
    <form action="?endsession=1" method="post">
        <input type="submit" value="End Session">
    </form>
</body>
</html>