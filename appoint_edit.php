<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}

include 'dbconnect.php';

if(isset($_GET['action'],$_GET['id'])){
    $id=intval($_GET['id']);
    $action=$_GET['action'];

    if($action==='cancel'){
        $newstatus='cancelled';
    }elseif($action==='complete'){
        $newstatus='completed';
    }
    else{
        $newstatus=null;
    }
    if($newstatus){
        $update_sql="Update appointments Set status='$newstatus'
        where appointment_id=$id";
        mysqli_query($conn,$update_sql);
    }
    header("Location: appoint_edit.php");
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
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Oswald', sans-serif;
            color: white;
            background: url(https://www.medigy.com/offering/20449.JPEG) no-repeat center center fixed;
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
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            margin-right: 10px;
            text-decoration: none;
        }

        .cancel {
            background-color: rgba(226, 211, 0, 1);
            color: white;
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            text-decoration:none;
        }
        .complete {
            background-color: blue;
            color: white;
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            text-decoration:none;
        }

        .edit:hover {
            background-color: #00E5FF;
            color: black;
        }

        .cancel:hover {
            background-color: blueviolet;
        }
        .complete:hover {
            background-color: rgba(226, 211, 0, 1);
            color: black;
        }
        #fil{
            margin-left:10px;
            color:blue;
            font-size:20px;
            font-weight:bold;
        }
        .delete:hover {
            background-color: purple;
            color: black;
        }
        .delete {
            background-color: red;
            color: white;
            padding: 5px 20px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;
            transition: background-color 0.7s ease;
            margin-right: 10px;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="welcome">
            <div class="heading">
                <h1>Appointments List</h1>
            </div>
            <form action="" method="GET">
                <label for="filter" id="fil">Filter by Status:</label>
                <select name="status" id="filter">
                    <option value=""<?php if(!isset($_GET['status'])|| $_GET['status']=='') echo 'selected';?>>All</option>
                    <option value="scheduled"<?php if(isset($_GET['status'])&&$_GET['status']=='scheduled') echo 'selected';?>>Scheduled</option>
                    <option value="completed"<?php if(isset($_GET['status'])&&$_GET['status']=='completed') echo 'selected';?>>Completed</option>
                    <option value="cancelled"<?php if(isset($_GET['status'])&&$_GET['status']=='cancelled') echo 'selected';?>>Cancelled</option>
                </select>
                <script>
                    document.getElementById("filter").addEventListener("change",function(){
                        this.form.submit();
                    });
                </script>
            </form>
            <table cellpadding="7">
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th colspan=4>Actions</th>
                </tr>
                <?php
                    include 'dbconnect.php';
                    $status_filter = $_GET['status'] ?? '';
                    // if status_fikter exists it uses its value otherwise uses empty ''.

                    if ($status_filter !== '') {
                        $sql = "SELECT 
                                a.*, 
                                p.name AS patient_name, 
                                s.name AS doctor_name 
                                FROM appointments a
                                JOIN patients p ON a.patient_id = p.id
                                JOIN staffs s ON a.doctor = s.staff_id
                                WHERE a.status = '$status_filter'";
                    } else {
                        $sql = "SELECT 
                                a.*, 
                                p.name AS patient_name, 
                                s.name AS doctor_name 
                                FROM appointments a
                                JOIN patients p ON a.patient_id = p.id
                                JOIN staffs s ON a.doctor = s.staff_id";
                    }


                    $result=mysqli_query($conn,$sql);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    $num=mysqli_num_rows($result);

                    if($num>0){
                        while ($row=mysqli_fetch_assoc($result))
                        {
                ?>
                <tr>
                    <td><?php echo $row['appointment_id'];?></td>
                    <td><?php echo $row['patient_name'];?></td>
                    <td><?php echo $row['doctor_name'];?></td>
                    <td><?php echo $row['appointment_date'];?></td>
                    <td><?php echo $row['appointment_time'];?></td>
                    <td><?php echo $row['status'];?></td>

                    <td>
                        <a class="edit" href="updt_appoint.php?appointment_id=<?php echo $row['appointment_id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="cancel" href="appoint_edit.php?action=cancel&id=<?php echo $row['appointment_id'];?>"
                        onclick="if('<?php echo $row['status'];?>'!=='cancelled')
                        {return confirm('Are you sure you want to cancel this appointment?');}
                        else{return false;}">Cancel</a>
                    </td>
                    <td>
                        <a class="complete" href="appoint_edit.php?action=complete&id=<?php echo $row['appointment_id'];?>" 
                        onclick="if('<?php echo $row['status'];?>'!=='completed')
                        {return confirm('Are you sure you want to mark this appointment as completed?');}
                        else{return false;}">Complete</a>
                    </td>
                    <td>
                        <a class="delete" href="delete_appoint.php?appointment_id=<?php echo $row['appointment_id']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
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
