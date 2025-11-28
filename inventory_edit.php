<?php 
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['item_id'], $_POST['status'])){
    $id=$_POST['item_id'];
    $new_status=$_POST['status'];
    $updatesql ="UPDATE inventory SET status='$new_status' WHERE item_id=$id";
    mysqli_query($conn,$updatesql);

    header("Location:inventory_edit.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointment View</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Oswald', sans-serif;
            color: white;
            background-image: url(https://img.freepik.com/premium-vector/professional-medical-inventory-hospital-with-first-aid-thermometer_906149-68773.jpg?w=2000);
            background-size: cover;
        }

        .welcome {
            background-color: rgba(255, 255, 255, 0.05);
            margin: 0 5px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            padding-bottom: 60px;
            margin-top: 20px;
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

        table {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            margin: 20px auto 50px auto;
            font-family: 'Oswald', sans-serif;
            text-align: center;
            border-collapse: collapse;
            width: 90%;
            max-width: 900px;
        }

        table th {
            background-color: red;
            padding: 10px;
        }

        table td {
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: rgba(90, 10, 249, 0.2);
        }

        .edit {
            background-color: darkgreen;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            margin-right: 10px;
            text-decoration: none;
        }

        .dlt {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            text-decoration: none;
        }

        .edit:hover {
            background-color: #00E5FF;
            color: black;
        }

        .dlt:hover {
            background-color: blueviolet;
        }

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="welcome">
            <div class="heading">
                <h1>Inventory List</h1>
            </div>
            <table cellpadding="7">
                <tr>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Supplier Name</th>
                    <th>Received On</th>
                    <th>Status</th>
                    <th colspan="2">Actions</th>
                </tr>

                <?php
                    include 'dbconnect.php';
                    $sql="Select * from inventory";
                    $result=mysqli_query($conn,$sql);
                    $num=mysqli_num_rows($result);

                    if($num>0){
                        while($row = mysqli_fetch_assoc($result))
                    {
                ?>

                <tr>
                    <td><?php echo $row['item_id'];?></td>
                    <td><?php echo $row['item_name'];?></td>
                    <td><?php echo $row['category'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td><?php echo $row['expiry_date'];?></td>
                    <td><?php echo $row['supplier_name'];?></td>
                    <td><?php echo $row['received_on'];?></td>
                    <td>
                        <form action="" method="POST" style="margin:0;">
                            <input type="hidden" name="item_id" value="<?php echo $row['item_id'];?>">
                            <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; background-color:aqua;" >
                                <option value="Available" <?php if($row['status']=='Available') echo 'selected';?>>Available</option>
                                <option value="Expired" <?php if($row['status']=='Expired') echo 'selected';?>>Expired</option>
                                <option value="Low Stock" <?php if($row['status']=='Low Stock') echo 'selected';?>>Low Stock</option>
                            </select>
                        </form>
                    </td>
                
                   <td>
                        <a class="edit" href="updt_inventory.php?item_id=<?php echo $row['item_id']; ?>">Update</a>
                    </td>
                    <td>
                        <a class="dlt" href="delete_invent.php?item_id=<?php echo $row['item_id']; ?>" onclick="return confirm('Are you sure you want to delete this inventory?')">Delete</a>
                    </td>

                </tr>
                <?php
            }
        }
    ?>

            </table>
        </div>
    </div>
</body>

</html>