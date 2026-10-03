<?php
    session_start();
    include('../dbcon.php');

    $username=$_POST["username"];
    $password=$_POST["password"];

    $stmt=$conn->prepare("SELECT * FROM users WHERE username= ? and password= ?");
    $stmt->bind_param("ss",$username,$password);
    $stmt->execute();

    $res=$stmt->get_result();
    $row=$res->fetch_assoc();

    if($row){
        $role=$row['role'];
        $_SESSION['username']=$username;
        if($role=='patient'){
            include('./datapass.php');
            header("location:../p.app/app.p.index.php");
            }
        else{
            header('location:../d.app/app.d.index.php');
        }
        $conn->close();
        exit();
    }
    else{
        header("location:login.php");
        //die("Loggin Failed".$conn->error);
        exit();
    };
    
?>