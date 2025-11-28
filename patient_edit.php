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

    if($action==='discharge'){
        $newstatus='discharged';
    }
    else{
        $newstatus=null;
    }
    if($newstatus){
        $updatesql="UPDATE patients SET status='discharged'
        where id=$id";
        mysqli_query($conn,$updatesql);
    }
    header("Location:patient_edit.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient View</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
    <style>
        /* Same CSS as form page */
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Oswald', sans-serif;
        }

        body {
            background-image: url(https://medicaldialogues.in/h-upload/2022/12/09/193335-alcohol-withdrawal-syndrome.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            background-attachment: fixed;
            padding-bottom: 20px;
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

        .discharge {
            background-color: blueviolet;
            color: white;
            padding: 5px 10px;
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

        .discharge:hover {
            background-color: red;
        }

        table caption {
            font-size: 40px;
            color: chartreuse;
            margin-bottom: 15px;
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
            text-decoration: none;
        }
        .delete:hover {
            background-color: purple;
            color: black;
        }

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
    
        <div class="welcome">
            <div class="heading">
                <h1>Patient Records</h1>
            </div>
            <table cellpadding="7">
                <tr>
                    <th>Patient ID</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Visit Date</th>
                    <th>Diagnosis</th>
                    <th>Medication</th>
                    <th>Follow-up Date</th>
                    <th>Status</th>
                    <th colspan=3>Actions</th>
                </tr>

                <?php
                    include 'dbconnect.php';
                    $sql="Select * from patients";
                    $result=mysqli_query($conn,$sql);
                    $num=mysqli_num_rows($result);

                    if($num>0){
                        while($row=mysqli_fetch_assoc($result))
                        {
                ?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['age'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td><?php echo $row['address'];?></td>
                    <td><?php echo $row['phone'];?></td>
                    <td><?php echo $row['visit_date'];?></td>
                    <td><?php echo $row['diagnosis'];?></td>
                    <td><?php echo $row['medication'];?></td>
                    <td><?php echo $row['followup_date'];?></td>
                    <td><?php echo $row['status'];?></td>
                    <td>
                        <a class="edit" href="updt_patient.php?id=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="discharge" 
                        href="patient_edit.php?action=discharge&id=<?php echo $row['id'];?>"
                        onclick="if('<?php echo trim(strtolower($row['status'])); ?>' !== 'discharged') {
                                        return confirm('Are you sure you want to discharge this patient?');
                                    } else {
                                        return false;
                                    }">Discharge
                        </a>

                    </td>
                    <td>
                        <a class="delete" href="delete_patient.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this patient record?')">Delete</a>
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
