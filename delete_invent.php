<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if(isset($_GET['item_id'])){
    $id=$_GET['item_id'];
    $sql="DELETE from inventory WHERE item_id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        echo "<script>
        window.location.href='inventory_edit.php'
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
    alert('No item id is provided')
    </script>";
}
?>