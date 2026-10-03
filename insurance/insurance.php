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

    $provider_stmt=$conn->prepare('SELECT * FROM insurancecompanies WHERE id=?');
    $provider_stmt->bind_param('i',$row['ip_id']);
    $provider_stmt->execute();

    $provider_res=$provider_stmt->get_result();
    $provider_row=$provider_res->fetch_assoc();
    $provider=$provider_row['name'];

    
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
                <div class="detailcard">
                    <div class="title">
                        <h2>Insurance Details</h2>
                    </div>
                    <div class="details">
                        <div class="personal_details">
                            <p><strong>Name:</strong> <?=$_SESSION['patientdetails']['fname'] . " " . $_SESSION['patientdetails']['lname']?></p>
                            <p><strong>Date of Birth:</strong> <?=$_SESSION['patientdetails']['dob']?></p>
                            <p><strong>NIC:</strong> <?=$_SESSION['patientdetails']['nic']?></p>
                            <p><strong>Phone:</strong> <?=$_SESSION['patientdetails']['phone']?></p>
                        </div>
                        <div class="providerdetails">
                            <p><strong>Category:</strong> <?=$row['category']?></p>
                            <p><strong>Provider:</strong> <?=$provider?></p>
                            <p><strong>Policy Number:</strong> <?=$row['policy_number']?></p>
                            <p><strong>Provider Contact:</strong> <?=$provider_row['contact_no']?></p>
                        </div>
                    </div>
                    <div class="coverage">
                        <h3>Coverage Details</h3>
                        <p><strong>Coverage Amount:</strong> <?=$row['coverage']?></p>
                        <p><strong>Coverage Start Date:</strong> <?=$row['coverage_start_date']?></p>
                        <p><strong>Coverage End Date:</strong> <?=$row['coverage_end_date']?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
