<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
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
        .heading{
            text-align:center;
        }
        #filter{
            background-color:aqua;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            height:30px;
        }
        #fil{
            margin-left:10px;
            color:blue;
            font-size:20px;
            font-weight:bold;
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
            <form action="" method="GET">
                <label for="filter" id="fil">Filter By Status</label>
                <select name="status" id="filter">
                    <option value=""<?php if(!isset($_GET['status'])|| $_GET['status']=='') echo 'selected';?>>All</option>
                    <option value="Available"<?php if(isset($_GET['status'])&&$_GET['status']=='Available') echo 'selected';?>>Available</option>
                    <option value="Low Stock"<?php if(isset($_GET['status'])&&$_GET['status']=='Low Stock') echo 'selected';?>>Low Stock</option>
                    <option value="Expired"<?php if(isset($_GET['status'])&&$_GET['status']=='Expired') echo 'selected';?>>Expired</option>
                </select>
                <script>
                        document.getElementById("filter").addEventListener("change", function(){
                            this.form.submit();
                        })
                </script>
            </form>
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
                </tr>

                <?php
                    include 'dbconnect.php';
                    $status_filter = $_GET['status'] ?? '';
                    if($status_filter!==''){
                        $sql="Select * from inventory
                        WHERE inventory.status='$status_filter'";
                    }
                    else{
                        $sql="Select * from inventory";
                    }
                    $result=mysqli_query($conn,$sql);
                    if(!$result){
                        die("Query Failed: ".mysqli_error($conn));
                    }
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
                    <td><?php echo $row['status'];?></td>
                
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