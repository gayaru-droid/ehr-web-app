<?php 
session_start();
include('../dbcon.php');
if(!isset($_SESSION['patientdetails']['patient_id'])){
    header('location:../login/login.php');  
}


?>