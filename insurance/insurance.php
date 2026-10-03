<?php
    session_start();
    include('../dbcon.php');
    if(!isset($_SESSION['patientdetails']['patient_id'])){
        header('location:../login/login.php');  
    }

    $stmt=$conn->prepare('SELECT * FROM insurances WHERE patient_id=?');
    $stmt->bind_param('i',$_SESSION['patientdetails']['patient_id']);
    $stmt->execute();

    $res=$stmt->get_result();
    $row=$res->fetch_assoc();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="side_bar">
            <div class="sidebar_main">
                <div id="navbar_row1">
                    <img src="../imgs/logo-tp-long.png" alt="logo" class="logo">
                </div>
                <div class="navigation">
                    <a href="../p.app/app.p.index.php" >Dashboard</a>
                    <a href="../prescription/prescription.php" >Prescriptions</a>
                    <a href="../healthrecords/healthrecords.php">Health records</a>
                    <a class=selected href="#">Insurance</a>
                </div>
            </div>
            <div class="account">
                <a href="#">Settings</a>
                <a href="../logout/logout.php">logout</a>
            </div>
        </div>
        <div class="main_content">
            <div class="welcome-text">
                <p>Insurance</p>
            </div>
            <div class="content">
                <P><?=$row['catagory']?></P>
            </div>
        </div>
    </div>
</body>
</html>
