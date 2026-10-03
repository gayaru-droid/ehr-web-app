<?php
    include('dataretrive.php');
    if(!isset($_SESSION['patientdetails']['patient_id'])){
        header('location:../login/login.php');  
    }
    if(isset($_GET['admit'])){
        $otp = random_int(1000, 9999);

        $stmt=$conn->prepare('UPDATE admit SET status="expired" where p_id=? and status="pending"');
        $stmt->bind_param('i',$_SESSION['patientdetails']['patient_id']);
        $stmt->execute();

        $stmt=$conn->prepare('INSERT INTO admit (p_id,date,otp) VALUES (?,NOW(),?);');
        $stmt->bind_param('ii',$_SESSION['patientdetails']['patient_id'], $otp);
        $stmt->execute();
    }
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
                    <a href="#" class=selected>Dashboard</a>
                    <a href="../prescription/prescription.php">Prescriptions</a>
                    <a href="../healthrecords/healthrecords.php">Health records</a>
                    <a href="../insurance/insurance.php">Insurance</a>
                </div>
            </div>
            <div class="account">
                <a href="#">Settings</a>
                <a href="../logout/logout.php">logout</a>
            </div>
        </div>
        <div class="main_content">
            <div class=dashboard>
                <div class="welcome-text">
                    <p>Welcome back,<?= $_SESSION['patientdetails']['fname']?>
                    </p>
                    <div class="admit">
                        <div class="admit">
                            <a href="?admit=1" class="admit-link" id="admitLink">
                                <img src="../imgs/admit.png" alt="admit">
                            </a>
                        </div>  
                    </div>
                </div>
                <div class="statusarea">
                    <div class="status" id=st1>
                        <div class="img">
                            <img src="../imgs/bpresure.png">
                        </div>
                        <div class="text">
                            <p>Blood Presure</p>
                            <h3>
                            <?=$_SESSION['patientdetails']['lastsystolic']?>/<?=$_SESSION['patientdetails']['lastdiastolic']?> mmHg
                            </h3>
                        </div>
                        <div class="verdict">

                        </div>
                    </div>
                    <div class="status" id=st2>
                        <div class="img">
                            <img src="../imgs/glucose.png">
                        </div>
                        <div class="text">
                            <p>Glucose Level</p>
                            <h3>
                                <?=$_SESSION['patientdetails']['lastglucose']?> mg/dl
                            </h3>
                        </div>
                        <div class="verdict">

                        </div>
                    </div>
                    <div class="status" id=st3>
                        <div class="img">
                            <img src="../imgs/hrate.png">
                        </div>
                        <div class="text">
                            <p>Heart Rate</p>
                            <h3>
                                <?=$_SESSION['patientdetails']['lastheartrate']?> bpm
                            </h3>
                        </div>
                        <div class="verdict">

                        </div>
                    </div>
                    <div class="status" id=st4>
                        <div class="img">
                            <img src="../imgs/oxygen.png">
                        </div>
                        <div class="text">
                            <p>Oxygen Level</p>
                            <h3>
                                <?=$_SESSION['patientdetails']['lastoxygen']?> %
                            </h3>
                        </div>
                        <div class="verdict">

                        </div>
                    </div>
                </div>
                <div class="grpaharea">
                    <div class="graph1">
                        <h3>Blood Glucose</h3>
                        <?php include('../graphs/bloodglucose/bloodglucose.php'); ?>
                    </div>
                    <div class="graph2">
                        <div class="graph2container">
                            <?php include('../graphs/bpressuredist/bpressuredist.php'); ?>
                        </div>
                        <h3>Blood Presure Distribution</h3> 
                    </div>
                </div>
            </div>
            <div class="hero_card">
                <div class="profilepic">
                    <img src="../imgs/profile.jpg" id="profilepic">
                    <p class="name">
                        <?= $patientdetails["fname"].' '.$patientdetails['lname']?>
                    </p>
                </div>
                <div class="userdetails">
                    <div class="medicaldetails">
                        <div id="row1">
                            <div class=singledetail>
                                <img src="../imgs/gender.png">
                                <div class="detailtext">
                                    <p class="dt">Gender</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['gender']?></p>
                                </div>
                            </div>
                            <div class=singledetail>
                                <img src="../imgs/age.png">
                                <div class="detailtext">
                                    <p class="dt">Age</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['age']?></p>
                                </div> 
                            </div>
                        </div>
                        <div id="row2">
                            <div class=singledetail>
                                <img src="../imgs/blood.png">
                                <div class="detailtext">
                                    <p class="dt">Blood Group</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['bgroup']?></p>
                                </div>
                            </div>
                            <div class=singledetail>
                                <img src="../imgs/bmi.png">
                                <div class="detailtext">
                                    <p class="dt">BMI</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['lastbmi']?></p>
                                </div>
                            </div>
                        </div>
                            <div id="row3">
                            <div class=singledetail>
                                <img src="../imgs/height.png">
                                <div class="detailtext">
                                    <p class="dt">Height</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['lastheight']?> cm</p>
                                </div>
                            </div>
                            <div class=singledetail  >
                                <img src="../imgs/weight.png">
                                <div class="detailtext">
                                    <p class="dt">Weight</p>
                                    <p class="dd"><?= $_SESSION['patientdetails']['lastweight']?> kg</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="allinfo">
                    <p>Show All Information</p>
                </div>
            </div>
        </div>
        <div class="mobile_bar">
            <div class="mobile_bar_details">
                <div class="mobile_navigations">
                    <img src="../imgs/home.png" alt="home">
                    <img src="../imgs/prescription.png" alt="prescriptions">
                    <img src="../imgs/records.png" alt="records">
                    <img src="../imgs/insurance.png" alt="insuarance">
                    <img src="../imgs/account.png" alt="account">
                </div>
            </div>
        </div>
    </div>
    <script>
        const otp=<?= json_encode($otp ?? '0000') ?>;
        window.addEventListener('load', (event) => {
            console.log('The page, including images and stylesheets, is fully loaded.');
            if(otp !== '0000'){
                alert('Your OTP for admission is: ' + otp);
            }
        });

    </script>
</body>
</html>
