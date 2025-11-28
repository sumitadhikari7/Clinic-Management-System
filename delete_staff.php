<?php
session_start();
if(!isset($_SESSION['username']) || ($_SESSION['role']!=='admin')){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if(isset($_GET['staff_id'])){
    $id=$_GET['staff_id'];
    $sql="DELETE FROM staffs WHERE staff_id= ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        echo "<script>
        window.location.href='staff_edit.php'
        </script>";
    }
    else{
        echo "<script> 
        alert('Records were not deleted')
        </script>";
    }
    $stmt->close();
    $conn->close();
}
else{
    echo "<script> alert('No staff id was provided');</script>";
}