<?php
session_start();
if(!isset($_SESSION['p_id'])){
    header('location:../../login/login.php');
};
if(isset($_POST)){
    include('../../dbcon.php');
    $stmt=$conn->prepare('INSERT INTO `measurements`(`patient_id`, `height`, `weight`, `bmi`, `systolic`, `diastolic`, `heartrate`, `glucose`, `oxygen`) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->bind_param('iiidiiiii',$_SESSION['p_id'],$_POST['height'],$_POST['weight'],$_POST['bmi'],$_POST['systolic'],$_POST['diastolic'],$_POST['heartrate'],$_POST['glucose'],$_POST['oxygen']);
    $stmt->execute();

    header('location:../app.d.index.php');
}
?>