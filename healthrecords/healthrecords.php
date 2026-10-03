<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location:../login/login.php');
    exit();
}
$title = '';
$dataJson = '[]';
$labelsJson = '[]';

$alowedInputs=['oxygen','glucose','heartrate','diastolic','systolic','bmi','weight','height'];
if(isset($_GET['graphtitle'])){

    include('../dbcon.php');
    $title=$_GET['graphtitle'];
    $beginAtZero=$_GET['beginAtZero'] ?? 'false';

    if(!in_array($title,$alowedInputs,true)){
        echo('injection detacted');
        exit();
    }

    $stmt=$conn->prepare("SELECT `$title`,date_time FROM measurements WHERE patient_id=? ORDER BY date_time ASC");
    $stmt->bind_param('i',$_SESSION['patientdetails']['patient_id']);
    $stmt->execute();

    $res=$stmt->get_result();
    $labels=[];
    $data=[];
    while($row=$res->fetch_assoc()){
        $data[]=$row[$title];
        $labels[]=$row['date_time'];
}

$dataJson=json_encode($data);
$labelsJson=json_encode($labels);

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
                    <a href="../prescription/prescription.php" >Prescriptions</a>
                    <a class=selected href="../healthrecords/healthrecords.php">Health records</a>
                    <a href="../insurance/insurance.php">Insurance</a>
                </div>
            </div>
            <div class="account">
                <a href="#">Settings</a>
                <a href="../logout/logout.php">logout</a>
            </div>
        </div>
        <div class="main_content">
            <div class="welcome-text">
                <p>Comprahansive health records</p>
            </div>
            <div class="content">
                <div class="grapharea">
                    <div class="grapsearch">
                        <p>Select Record :</p>
                        <form action="healthrecords.php" method="GET">
                            <select id='graphtitle' name='graphtitle'>
                                <option value='height'>height</option>
                                <option value='weight'>weight</option>
                                <option value='bmi'>bmi</option>
                                <option value='systolic'>systolic</option>
                                <option value='diastolic'>diastolic</option>    
                                <option value='heartrate'>heartrate</option>
                                <option value='glucose'>glucose</option>
                                <option value='oxygen'>oxygen</option>
                            </select>
                            <div class="checkbox">
                                <label for="beginAtZero">Begin At Zero</label>
                                <input type="checkbox" id="beginAtZero" name="beginAtZero" value="true">
                            </div>
                            <button type='submit' class='graphsearchsubmit'>Search</button>
                        </form>
                    </div>
                    <div class="graph">
                        <p class=graphtitle><?=$title;?></p>
                        <canvas id='graphcanvas'>

                        </canvas>
                    </div>
                </div>
                <div class="secondaryarea">
                    <div class="linkbutton">
                        <p>Download Center</p>
                        <div class="externallinkimg">
                            <a href='https://drive.google.com/drive/' target='_blanck'>
                                <img src='../imgs/externallink.png'>
                            </a>
                        </div>
                    </div>
                    <div class="linkbutton">
                        <p>Request Detailed Report</p>
                        <div class="externallinkimg">
                            <a href='https://drive.google.com/drive/' target='_blanck'>
                                <img src='../imgs/externallink.png'>
                            </a>
                        </div>
                    </div>
                    <div class="linkbutton">
                        <p>Resuets Consultant</p>
                        <div class="externallinkimg">
                            <a href='https://drive.google.com/drive/' target='_blanck'>
                                <img src='../imgs/externallink.png'>
                            </a>
                        </div>
                    </div>
                    <div class="linkbutton">
                        <p>Support</p>
                        <div class="externallinkimg">
                            <a href='https://drive.google.com/drive/' target='_blanck'>
                                <img src='../imgs/externallink.png'>
                            </a>
                        </div>
                    </div>
                    <div class="linkbutton">
                        <p>Contact Us</p>
                        <div class="externallinkimg">
                            <a href='https://drive.google.com/drive/' target='_blanck'>
                                <img src='../imgs/externallink.png'>
                            </a>
                        </div>
                    </div>
                    <div class="importants">

                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        const ctx=document.getElementById('graphcanvas');
        const data=<?php echo $dataJson;?>;
        const labels=<?php echo $labelsJson;?>;
        const beginAtZero=<?php echo $beginAtZero; ?>;

        new Chart(ctx,{
            type:'bar',
            data:{
                labels:labels,
                datasets:[{
                    label:'<?=$title?>',
                    data:data,
                    borderWidth:1
                }]
            },
            options:{
                responsive:true,
                scales:{
                    y:{
                        beginAtZero:beginAtZero
                    }
                }
            }
        });
    </script>
</body>
</html>
