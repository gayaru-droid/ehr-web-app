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
    <div class="basicdetails">
        <h2>Basic Details</h2>
        <div class="basicdetailsarea">
            <?php
                $stmt=$conn->prepare("SELECT * FROM patients WHERE id=?");
                $stmt->bind_param('i', $_SESSION['p_id']);
                $stmt->execute();
                $patient_details = $stmt->get_result()->fetch_assoc();

                
                $stmt=$conn->prepare("SELECT * FROM measurements WHERE patient_id=? ORDER BY date_time DESC LIMIT 1");
                $stmt->bind_param('i',$_SESSION['p_id']);
                $stmt->execute();
                $measurements=$stmt->get_result();
                $latest_measurement=$measurements->fetch_assoc();

                if(!$patient_details || !$latest_measurement){
                    echo 'Patient or measurement not found';
                    exit();
                }

            ?>
            <div class="personal_details">
                <div class="titles"><h3>Personal Details</h3></div>
                <div class="details">
                    <p><strong>Name : </strong><?=$_SESSION['p_name']?></p>
                    <p><strong>Date of Birth : </strong><?=$patient_user['dob']?></p>
                    <p><strong>Blood Group : </strong><?=$patient_details['bgroup']?></p>
                    <p><strong>Gender : </strong><?=$patient_details['gender']?></p>
                    <p><strong>NIC no : </strong><?=$patient_user['nic']?></p>
                </div>
            </div>
            
            <div class="contact_details">
                <div class="titles"><h3>Contact Details</h3></div>
                <div class="details">
                    <p><strong>Email : </strong><?=$patient_user['username']?></p>
                    <p><strong>Contact No : </strong><?=$patient_user['contact_no']?></p>
                    <p><strong>Address : </strong><?=$patient_user['username']?></p>
                </div>  
            </div>  
            
            <div class="least_measurments">
                <div class="titles"><h3>Least Measurements</h3></div>
                <div class="details">
                    <p><strong>Height : </strong><?=$latest_measurement['height']?> cm</p>
                    <p><strong>Weight : </strong><?=$latest_measurement['weight']?> kg</p>
                    <p><strong>BMI : </strong><?=$latest_measurement['bmi']?></p>
                    <p><strong>Blood Presure : </strong><?=$latest_measurement['systolic']?>/<?=$latest_measurement['diastolic']?> mmHg</p>
                    <p><strong>Heart Rate : </strong><?=$latest_measurement['heartrate']?> bpm</p>
                    <p><strong>Blood Glucose : </strong><?=$latest_measurement['glucose']?> mg/dl</p>
                    <p><strong>Blood Glucose : </strong><?=$latest_measurement['oxygen']?> %</p>
                </div>
            </div>
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
                </div>
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
                <div class="prescriptionarea">
                    <?php
                        if(count($ongoingprescriptions)===0){
                            echo("<p>No ongoing prescriptions</p>");
                        }else{
                            foreach($ongoingprescriptions as $prescription){
                                echo("<div class='prescriptioncard'>");
                                echo("<p><strong>Medicine Name:</strong> ".$prescription['medicine_name']."</p>");
                                echo("<p><strong>Dosage:</strong> ".$prescription['dosage']."</p>");
                                echo("<p><strong>Quantity:</strong> ".$prescription['quantity']."</p>");
                                echo("<p><strong>Date Time:</strong> ".$prescription['date_time']."</p>");
                                echo("<p><strong>Doctor Name:</strong> ".$prescription['doctor_name']."</p>");
                                echo("</div>");
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="moreactions">
                <div class="addmedicalreport">
                    <p>Add Medical Report</p>
                    <div class="addmedicalreportbuttons">
                        <label for="medical_report">
                            <img src='../imgs/upload.png' id='upload_icon' alt='Upload Icon' width='20' height='20'>
                        </label>
                        <a href="../d.app/app.d.addmedicalreport.php">uploadfile</a>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="file" name="medical_report" id="medical_report">
                            <input type="submit" value="Upload">      
                        </form>
                    </div>
                </div>
                <div class="secondaryactions">
                    <div class="vieweditbasics">
                        <p>Edit Basics</p>
                        <div class="moreactionsbuttons">
                            <a href="../d.app/editbasics/editbasics.php">Edit</a>
                        </div>
                    </div>
                    <div class="addmesurment">
                        <p>Add Measurement</p>
                        <div class="moreactionsbuttons">
                            <a href="../d.app/addmeasurement/addmeasurement.php">Add</a>
                        </div>
                    </div>
                    <div class="addprescription">
                        <p>Add Prescription</p>
                        <div class="moreactionsbuttons">
                            <a href="../d.app/app.d.addprescription.php">Add</a>
                        </div>
                    </div>
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
        <script>
            document.getElementById('medical_report').addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
            // Change image source to tick icon when a file is selected
            document.getElementById('upload_icon').src = '../imgs/tick.png';
            } else {
            // Revert back to upload icon if selection is cleared
            document.getElementById('upload_icon').src = '../imgs/upload.png';
            }
}           );
        </script>
</body>
</html>