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
$stmt = $conn->prepare("SELECT * FROM doctors WHERE user_id=?");
$stmt->bind_param("s", $_SESSION['u_id']);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$_SESSION['d_name'] = $doctor['fname'];

$stmt = $conn->prepare("SELECT * FROM admit WHERE otp=? AND status='active'");
$stmt->bind_param("i", $_SESSION['otp']);
$stmt->execute();
$result = $stmt->get_result();
$admit = $result->fetch_assoc();
$_SESSION['p_id'] = $admit['p_id'];

$stmt = $conn->prepare("SELECT * FROM patients WHERE id=?");
$stmt->bind_param("i", $_SESSION['p_id']);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
$_SESSION['p_user_id'] = $patient['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION['p_user_id']);
$stmt->execute();
$result = $stmt->get_result();
$patient_user = $result->fetch_assoc();
$_SESSION['p_name'] = $patient_user['fname'] . ' ' . $patient_user['lname'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="title">
        <div class="welcome_text">
            <h1>Welcome back, Dr. <?php echo $_SESSION['d_name']; ?></h1>
            <p>You are currently examining <?php echo $_SESSION['p_name']; ?></p>
        </div>
        <div class="sessionbutton">
            <form action="?endsession=1" method="post">
                <input type="submit" value="End Session">
            </form>
        </div>
    </div>
</body>
</html>