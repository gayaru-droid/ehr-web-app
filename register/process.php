<?php
    include('../dbcon.php');
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $nic=$_POST['nic'];
    $dob=$_POST['dob'];
    $role=$_POST['role'];

    $createtable="CREATE TABLE IF NOT EXISTS users(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        fname varchar(255) NOT NULL,
        lname VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL UNIQUE KEY,
        password VARCHAR(255) NOT NULL,
        nic INT NOT NULL,
        dob DATE NOT NULL,
        role varchar(255) NOT NULL
    )";
    $conn->query($createtable);

    $stmt=$conn->prepare('INSERT INTO users(fname,lname,username,password,nic,dob,role) VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('ssssiss',$fname,$lname,$username,$password,$nic,$dob,$role);

    if($stmt->execute()===TRUE){
        $stmt->close();
        $conn->close();
        header('location:../login/login.php');
        exit();
    }
    else{
        echo('Failed to insert data'.$stmt->error);
    }
    

?>