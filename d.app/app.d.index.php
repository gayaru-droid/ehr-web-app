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
    $stmt->bind_param('i',$_SESSION['p_id']);
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
    <div class="content">
        <div class="grapharea">
            <div class="grapsearch">
                    <p>Select Record :</p>
                    <form action="?get=1" method="GET">
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
        <div class="secondary_area">
            <div class="ongoingprescriptions">
                <div class="text">
                    <p>Ongoing Prescriptions</p>
                    <P>See All</P>
                    <?php
                        $sql1="SELECT 
                                    p.medicine_name,
                                    p.date_time,
                                    p.dosage,
                                    p.quantity,
                                    CASE
                                        WHEN CURDATE() < p.start_date THEN 'Upcoming'
                                        WHEN CURDATE() BETWEEN p.start_date AND p.end_date THEN 'Active'
                                        WHEN p.end_date<CURDATE() THEN 'Completed'
                                    END AS status,
                                    CONCAT(d.fname, ' ', d.lname) AS doctor_name
                                FROM prescriptions p
                                JOIN doctors d ON p.doctor_id = d.id
                                WHERE p.patient_id = ?";

                        $stmt=$conn->prepare($sql1);
                        $stmt->bind_param('i',$_SESSION['p_id']);
                        $stmt->execute();


                        $res=$stmt->get_result();

                        $ongoingprescriptions=[
                        ];


                        while($row=$res->fetch_assoc()){
                            if($row['status']==='Active'){
                                $ongoingprescriptions[]=$row;
                            };
                        };

                        /*echo(json_encode($ongoingprescriptions));*/
                        $stmt->close();
                    ?>
                </div>
            </div>
            <div class="editbasics">
                <p>Edit Basics</p>
                <div class="editbasicsbuttons">
                    <a href="../d.app/app.d.editbasics.php">Edit</a>
                </div>
            </div>
            <div class="addmesurment">
                <p>Add Measurement</p>
                <div class="editbasicsbuttons">
                    <a href="../d.app/app.d.addmeasurement.php">Add</a>
                </div>
            </div>
            <div class="addprescription">
                <p>Add Prescription</p>
                <div class="editbasicsbuttons">
                    <a href="../d.app/app.d.addprescription.php">Add</a>
                </div>
            </div>
            <div class="addmedicalreport">
                <p>Add Medical Report</p>
                <div class="editbasicsbuttons">
                    <img src='../imgs/externallink.png'>
                    <a href="../d.app/app.d.addmedicalreport.php">uploadfile</a>
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