<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if(isset($_GET['appointment_id'])){
    $id=$_GET['appointment_id'];
    $sql="DELETE  FROM appointments WHERE appointment_id= ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        echo "<script>
        window.location.href='appoint_edit.php'
        </script>";
    }
    else{
        echo "<script> 
        alert('Records were not deleted')
        </script>";
    }
    $stmt->close();
    $conn->close();
}else{
    echo "<script> alert('No appointment id was provided');</script>";
}
?>