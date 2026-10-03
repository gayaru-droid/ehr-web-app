<?php 
session_start();
include('../dbcon.php');

header('Content-Type: application/json');


$patient_id=$_SESSION['patientdetails']['patient_id'];

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
$stmt->bind_param('i',$_SESSION['patientdetails']['patient_id']);
$stmt->execute();


$res=$stmt->get_result();

$prescriptions=[
    'active'=>[],
    'upcoming'=>[],
    'completed'=>[]
];


while($row=$res->fetch_assoc()){
    $statuskey=strtolower($row['status']);
    if(isset($prescriptions[$statuskey])){
        $prescriptions[$statuskey][]=$row;
    };
};

echo(json_encode($prescriptions));
$stmt->close();
?>