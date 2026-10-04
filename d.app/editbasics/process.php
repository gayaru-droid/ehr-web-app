<?php
session_start();
if(!isset($_SESSION['p_id'])){
    header('location:../../login/login.php');
};
if(isset($_POST)){
    include('../../dbcon.php');
    $stmt=$conn->prepare('UPDATE patients SET gender=?, bgroup=? WHERE id=?');
    $stmt->bind_param('ssi',$_POST['gender'],$_POST['bgroup'],$_SESSION['p_id']);
    $stmt->execute();

    header('location:../app.d.index.php');
}
?>