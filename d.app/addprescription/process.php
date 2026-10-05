<?php
session_start();
if(!isset($_SESSION['p_id'])){
    header('location:../../login/login.php');
};
if(isset($_POST)){
    include('../../dbcon.php');
    $stmt=$conn->prepare('INSERT INTO `prescriptions`(`patient_id`, `medicine_name`, `dosage`, `quantity`, `start_date`, `end_date`, `doctor_id`) VALUES (?,?,?,?,?,?,?)');
    $stmt->bind_param('ississi',$_SESSION['p_id'],$_POST['medname'],$_POST['dosage'],$_POST['quantity'],$_POST['start_date'],$_POST['end_date'],$_SESSION['d_id']);
    $stmt->execute();

    header('location:../app.d.index.php');
}
?>