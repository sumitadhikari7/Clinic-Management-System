<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!=='admin'){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staffs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url(https://i.pinimg.com/originals/82/19/9e/82199ef2f8dce12e20693f1d18d1bc7d.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            background-attachment: fixed;
            padding-bottom: 20px;
            font-family: 'Oswald', sans-serif;
        }
        .welcome {
            background-color: rgba(255, 255, 255, 0.05);
            height: auto;
            margin: 0 5px;
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

        table {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            margin: 20px auto 50px auto;
            font-family: 'Oswald', sans-serif;
            text-align: center;
            border-collapse: collapse;
        }

        table th {
            background-color: red;
        }

        tr:nth-child(even) {
            background-color: rgba(90, 10, 249, 0.2);
        }

        table caption {
            font-size: 40px;
            color: chartreuse;
            margin-bottom: 15px;
        }

        .active {
            background-color: green;
            border-radius: 10px;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: 700;
            display: block;
            text-align: left;
            padding-left: 19px;
            user-select: none;
        }

        .leave {
            background-color: yellow;
            color: black;
            border-radius: 10px;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: 700;
            display: inline-block;
            user-select: none;
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
                <h1>Staff Records</h1>
            </div>
            <form action="" method="GET">
                <label for="filter" id="fil">Filter By Role</label>
                <select name="role" id="filter">
                    <option value=""<?php if(!isset($_GET['role'])|| $_GET['role']=='') echo 'selected';?>>All</option>
                    <option value="Doctor"<?php if(isset($_GET['role'])&&$_GET['role']=='Doctor') echo 'selected';?>>Doctor</option>
                    <option value="Nurse"<?php if(isset($_GET['role'])&&$_GET['role']=='Nurse') echo 'selected';?>>Nurse</option>
                    <option value="Pharmacist"<?php if(isset($_GET['role'])&&$_GET['role']=='Pharmacist') echo 'selected';?>>Pharmacist</option>
                    <option value="Receptionist"<?php if(isset($_GET['role'])&&$_GET['role']=='Receptionist') echo 'selected';?>>Receptionist</option>
                    <option value="Cleaner"<?php if(isset($_GET['role'])&&$_GET['role']=='Cleaner') echo 'selected';?>>Cleaner</option>
                </select>
                <script>
                        document.getElementById("filter").addEventListener("change", function(){
                            this.form.submit();
                        })
                    </script>
            </form>
            <table cellpadding="7">
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Joined On</th>
                    <th>Status</th>
                </tr>
                <?php
                    include 'dbconnect.php';
                    $role_filter = $_GET['role'] ?? '';
                    if($role_filter!==''){
                        $sql="Select * from staffs
                        WHERE staffs.role='$role_filter'";
                    }
                    else{
                        $sql="Select * from staffs";
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
                    <td><?php echo $row['staff_id'];?></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['role'];?></td>
                    <td><?php echo $row['department'];?></td>
                    <td><?php echo $row['contact'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['joined'];?></td>
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