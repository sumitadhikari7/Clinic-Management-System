<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!=='admin'){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['staff_id'], $_POST['status'])){
    $id=$_POST['staff_id'];
    $new_status=$_POST['status'];

    $updatesql ="UPDATE staffs SET status='$new_status' WHERE staff_id=$id";
    mysqli_query($conn,$updatesql);

    header("Location:staff_edit.php");
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

        .edit {
            background-color: darkgreen;
            color: white;
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            text-decoration: none;
        }

        .delete {
            background-color: red;
            color: white;
            padding: 5px 15px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            text-decoration: none;
        }

        table caption {
            font-size: 40px;
            color: chartreuse;
            margin-bottom: 15px;
        }

        .edit:hover {
            background-color: #00E5FF;
            color: black;
        }

        .delete:hover {
            background-color: blueviolet;
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

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="welcome">
            <div class="heading">
                <h1>Staff Records</h1>
            </div>
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
                    <th colspan=2>Actions</th>
                </tr>
                <?php
                    include 'dbconnect.php';
                    $sql="Select * from staffs";
                    $result=mysqli_query($conn,$sql);
                    $num=mysqli_num_rows($result);

                    if($num>0)
                    {
                        while($row=mysqli_fetch_assoc($result))
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
                    <td>
                        <form method="POST" style="margin: 0;">
                            <input type="hidden" name="staff_id" value="<?php echo $row['staff_id']; ?>">
                            <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; background-color:aqua;">
                                <option value="Available" <?php if($row['status'] == 'Available') echo 'selected'; ?>>Available</option>
                                <option value="On Leave" <?php if($row['status'] == 'On Leave') echo 'selected'; ?>>On Leave</option>
                            </select>
                        </form>
                    </td>

                    <td>
                        <a class="edit" href="updt_staff.php?staff_id=<?php echo $row['staff_id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="delete" href="delete_staff.php?staff_id=<?php echo $row['staff_id']; ?>" onclick=" return confirm('Are you sure you want to delete this staff?')">Delete</a>
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