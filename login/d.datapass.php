<?php
session_start();
    $stmt=$conn->prepare("SELECT * FROM users WHERE username=?;");
    $stmt->bind_param('s',$_SESSION['username']);
    $stmt->execute();
    $res=$stmt->get_result();
    $row=$res->fetch_assoc();
    $id=$row['id'];
    $_SESSION['u_id']=$id;
    $fname=$row['fname'];
    $lname=$row['lname'];

    $stmt2=$conn->prepare("SELECT * FROM doctors WHERE user_id=?;");
    $stmt2->bind_param('s',$row['id']);
    $stmt2->execute();
    $res=$stmt2->get_result();
    $row=$res->fetch_assoc();
    echo($id);
    if(!$row){
        $stmt1=$conn->prepare("INSERT INTO doctors(user_id,fname,lname) VALUES(?,?,?);");
        $stmt1->bind_param('iss',$id,$fname,$lname);
        $stmt1->execute();
    }
?>
