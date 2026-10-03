<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location:../login/login.php');
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
                    <a href="../p.app/app.p.index.php" >Dashboard</a>
                    <a href="#" class=selected>Prescriptions</a>
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
                    <p>Welcome back,<?= $_SESSION['patientdetails']["fname"]?>
                    </p>
                </div>
                <div class="presctipton-section">
                    <div class="button_area">
                        <form class='search-box'>
                            <input type='text' id='search' name='search'>
                            <button id='submit' value='search'>Search</button>
                        </form>
                        <p id='reload'>Reload</p>
                    </div>
                    <div class="prescriptions">
                        <div class="prescriptionarea-heading">
                            <h2>Active Prescriptions</h2>
                        </div>
                        <div id="active-prescription-container">
                            <p class="loading-text">Loading prescriptions...</p>
                        </div>
                    </div>
                    <div class="prescriptions">
                        <div class="prescriptionarea-heading">
                            <h2>Upcoming Prescriptions</h2>
                        </div>
                        <div id="upcoming-prescription-container">
                            <p class="loading-text">Loading prescriptions...</p>
                        </div>
                    </div>
                    <div class="prescriptions">
                        <div class="prescriptionarea-heading">
                            <h2>Completed Prescriptions</h2>
                        </div>
                        <div id="completed-prescription-container">
                            <p class="loading-text">Loading prescriptions...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero_card">
                <div class="profilepic">
                    <img src="../imgs/profile.jpg" id="profilepic">
                    <p class="name">
                        <?= $_SESSION['patientdetails']["fname"].' '.$_SESSION['patientdetails']['lname']?>
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
    <script src="scripts.js"></script>
</body>
</html>
