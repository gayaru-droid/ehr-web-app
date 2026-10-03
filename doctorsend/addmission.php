<?php
session_start();
if(!isset($_SESSION['username'])) {
    header('location:../login/login.php');
    exit();
}
if(isset($_POST['admit'])) {
    include('../dbcon.php');
    $otp = $_POST['otp'];
    
    $stmt = $conn->prepare("SELECT p_id FROM admit WHERE otp=?");
    $stmt->bind_param("i", $otp);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if($row) {
        $stmt = $conn->prepare("SELECT * FROM doctors WHERE user_id=?");
        $stmt->bind_param("s", $_SESSION['u_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $d_id = $row['id'];
        
        $stmt=$conn->prepare("UPDATE admit SET d_id=? WHERE otp=?");
        $stmt->bind_param("ii", $d_id, $otp);
        $stmt->execute();

        $stmt=$conn->prepare("UPDATE admit SET status='active' WHERE otp=?");
        $stmt->bind_param("i", $otp);
        $stmt->execute();
        echo "<script>alert('" . $d_id . "');</script>";
        }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="title">
                <p class=heading>Addmitting</p>
                <p>Enter the patient's OTP to proceed:</p>
            </div>
            <div class="form">
                <form action="?post=1" method="post">
                <div class="filed">
                    <label for="otp">Enter Patient's OTP: </label><br>
                    <input type="text" name="otp" id="otp">
                </div>
                <div class="submit">
                    <input type="submit" value="Admit" name="admit">
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>