<?php
    $hostname='localhost';
    $user='root';
    $pw='';
    $db='mylogin';


$conn=new mysqli($hostname,$user,$pw,$db);
if($conn->connect_error){
    die("Connection Failed: ".$conn->connect_error);
}
//echo('connected sucsussfully');
?>