<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
$id=$_GET['item_id'];
$sql="Select * from inventory where item_id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Inventory</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url(https://img.freepik.com/premium-vector/professional-medical-inventory-hospital-with-first-aid-thermometer_906149-68773.jpg?w=2000);
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            background-attachment: fixed;
            padding-bottom: 20px;
            font-family: 'Oswald', sans-serif;
        }
        .welcome {
            background-color: rgba(255, 255, 255, 0.05);
            margin: 20px 5px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding-bottom: 60px;
        }

        .heading{
            text-align:center;
        }

        .welcome h1 {
            color: red;
            background-color:rgba(0, 0, 0, 0.2);
            border radius:10px;
            font-weight: 700;
            text-align: center;
            padding: 20px 0;
            text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.5);
            display:inline-block;
            margin:0 auto;
        }

        form {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin: 0 auto 40px;
            width: 600px;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }

        form label {
            display: block;
            margin: 12px 0 7px;
        }

        form input, select {
            width: 95%;
            padding: 12px;
            font-family: 'Oswald', sans-serif;
        }

        .form-submit {
            text-align: right;
            margin-top: 15px;
        }

        .form-submit input[type="submit"] {
            width: 150px;
            background-color: #00E5FF;
            color: black;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            font-family: 'Oswald', sans-serif;
            transition: background-color 0.7s ease;
        }

        .form-submit input[type="submit"]:hover {
            background-color: green;
            color: white;
        }
        
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="welcome">
            <div class="heading">
                <h1>Update Inventory Item</h1>
            </div>
            <form action="" method="post">
                <label for="iname">Item Name</label>
                <input type="text" id="iname" name="iname" value="<?php echo $row['item_name'];?>" required>
                <label for="cat">Category</label>
                <select name="cat" id="cat" required>
                    <option value="" disabled <?php if(empty($row['category'])) echo 'selected'; ?>>Select a category</option>
                    <option value="Medicine" <?php if($row['category']=='Medicine') echo 'selected';?>>Medicine</option>
                    <option value="Equipments" <?php if($row['category']=='Equipments') echo 'selected';?>>Equipments</option>
                    <option value="Antibiotics" <?php if($row['category']=='Antibiotics') echo 'selected';?>>Antibiotics</option>
                    <option value="Vaccine" <?php if($row['category']=='Vaccine') echo 'selected';?>>Vaccine</option>
                    <option value="Disposables" <?php if($row['category']=='Disposables') echo 'selected';?>>Disposables</option>
                    <option value="First Aid" <?php if($row['category']=='First Aid') echo 'selected';?>>First Aid</option>
                </select>
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?php echo $row['quantity'];?>" required>
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" value="<?php echo $row['expiry_date'];?>">
                <label for="sname">Supplier Name</label>
                <input type="text" id="sname" name="sname" value="<?php echo $row['supplier_name'];?>" required>
                <label for="date_received">Received On</label>
                <input type="date" name="date_received" id="date_received" value="<?php echo $row['received_on'];?>" required>
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="Available" <?php if($row['status']=='Available') echo 'selected';?>>Available</option>
                    <option value="Low Stock" <?php if($row['status']=='Low Stock') echo 'selected';?>>Low Stock</option>
                    <option value="Expired" <?php if($row['status']=='Expired') echo 'selected';?>>Expired</option>
                </select>
                <div class="form-submit">
                    <input type="submit" value="Update Item" name="update">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST['update'])){
    $name= $_POST['iname'];
    $category= $_POST['cat'];
    $quantity= $_POST['quantity'];
    $expiry_date= $_POST['expiry_date'];
    $supplier_name= $_POST['sname'];
    $received= $_POST['date_received'];
    $status= $_POST['status'];

    $updatesql= "Update inventory set 
    item_name='$name',
    category='$category',
    quantity = '$quantity',
    expiry_date = '$expiry_date',
    supplier_name = '$supplier_name',
    received_on = '$received',
    status = '$status'
    where item_id = '$id'";

    $updateresult= mysqli_query($conn,$updatesql);

    if($updateresult){
        echo "<script> window.location.href='inventory_edit.php';</script>";
    }else{
        echo "<script> alert('Error updating item');</script>";
    }
}
?>
