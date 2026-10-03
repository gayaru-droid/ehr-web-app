<?php 
/*
Varibale Outputs--------------------------

   $_SESSION['patientdetails']['parameters']

    parameters->
        id=User id
        patient_id=patient ID
        fname= first name
        lname= last name
        dob= bate of birth
        age= Age
        gender=gender
        bgroup= Blood group
        lastheight=Last Height
        lastweight=Last weight
        lastbmi=Last BMI value
        lastsystolic=
        lastdiastolic=
        lastheartrate=
        lastglucose=
        lastoxygen=
        lastmesuredate=Last messured date
*/

session_start();
include('../dbcon.php');
if(!isset($_SESSION['username'])){
    header('location:../login/login.php');
    exit();
}
else{
    $stmt=$conn->prepare("SELECT * FROM users WHERE username=?;");
    $stmt->bind_param('s',$_SESSION['username']);
    $stmt->execute();

    $res=$stmt->get_result();
    $row=$res->fetch_assoc();

    $id=$row['id'];
    $fname=$row['fname'];
    $lname=$row['lname'];
    $dob=new DateTime($row['dob']);

    $curruntdate=new DateTime('today');
    $age=$dob->diff($curruntdate)->y;


    /*echo $fname;
    echo $lname;
    echo $dob->format('Y-m-d');
    echo $age;*/

    $stmt=$conn->prepare("SELECT id,gender,bgroup FROM patients WHERE user_id=?");
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $res=$stmt->get_result();
    $row=$res->fetch_assoc();

    $gender=$row['gender'];
    $bgroup=$row['bgroup'];
    $patient_id=$row['id'];

    $_SESSION['patient_id']=$patient_id;
    /*echo $bgroup;
    echo $gender;
    exit();*/

    $stmt=$conn->prepare("SELECT height,weight,bmi,systolic,diastolic,heartrate,glucose,oxygen,date_time FROM measurements WHERE patient_id=? ORDER BY date_time DESC LIMIT 1");
    $stmt->bind_param('s',$patient_id);
    $stmt->execute();
    $res=$stmt->get_result();
    $row=$res->fetch_assoc();
    
    $lastheight=$row['height'];
    $lastweight=$row['weight'];
    $lastbmi=$row['bmi'];
    $lastsystolic=$row['systolic'];
    $lastdiastolic=$row['diastolic'];
    $lastheartrate=$row['heartrate'];
    $lastglucose=$row['glucose'];
    $lastoxygen=$row['oxygen'];
    $lastmesuredate=$row['date_time'];

    /*echo $lastheight.'<br>';
    echo $lastbloodpresure.'<br>';
    echo $lastweight.'<br>';
    echo $lastmesuredate.'<br>';
    exit();*/

    $unsafepatientdetails = [
        'id'=>$id,
        'patient_id'=>$patient_id,
        'fname' => $fname,
        'lname'=>$lname,
        'dob'=>$dob->format('Y-m-d'),
        'age'=>$age,
        'gender'=>$gender,
        'bgroup'=>$bgroup,
        'lastheight'=>$lastheight,
        'lastweight'=>$lastweight,
        'lastbmi'=>$lastbmi,
        'lastsystolic'=>$lastsystolic,
        'lastdiastolic'=>$lastdiastolic,
        'lastheartrate'=>$lastheartrate,
        'lastglucose'=>$lastglucose,
        'lastoxygen'=>$lastoxygen,
        'lastmesuredate'=>$lastmesuredate
    ];
    $patientdetails=array_map('htmlspecialchars',$unsafepatientdetails);
    $_SESSION['patientdetails']=$patientdetails;
}

?>