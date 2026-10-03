<?php
session_start();
    $stmt=$conn->prepare("SELECT id FROM users WHERE username=?;");
    $stmt->bind_param('s',$_SESSION['username']);
    $stmt->execute();
    $res=$stmt->get_result();
    $row=$res->fetch_assoc();
    $id=$row['id'];

    $stmt2=$conn->prepare("SELECT * FROM patients WHERE user_id=?;");
    $stmt2->bind_param('s',$row['id']);
    $stmt2->execute();
    $res=$stmt2->get_result();
    $row=$res->fetch_assoc();
    echo($id);
    if(!$row){
        $stmt1=$conn->prepare("INSERT INTO patients(user_id) VALUES(?);");
        $stmt1->bind_param('s',$id);
        $stmt1->execute();
    }
?>
