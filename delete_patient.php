<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="DELETE FROM patients WHERE id= ?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        echo "<script>
        window.location.href='patient_edit.php'
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
    echo "<script>
    alert('No patient id was provided')
    </script>";
}
?>