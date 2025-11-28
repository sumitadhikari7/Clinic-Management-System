<?php

session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!=='admin'){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';

$activepatients= $conn->query("SELECT COUNT(*) AS total from patients where status='active'")->fetch_assoc()['total'];
$discharged=$conn->query("SELECT COUNT(*) AS total from patients where status='discharged'")->fetch_assoc()['total'];
$deceased=$conn->query("SELECT COUNT(*) AS total from patients where status='deceased'")->fetch_assoc()['total'];
$inactive=$conn->query("SELECT COUNT(*) AS total from patients where status='inactive'")->fetch_assoc()['total'];

//For staff
$totalstaff=$conn->query("SELECT COUNT(*) AS total from staffs")->fetch_assoc()['total'];
$availablestaff=$conn->query("SELECT COUNT(*) AS total from staffs where status='Available'")->fetch_assoc()['total'];
$onleavestaff=$conn->query("SELECT COUNT(*) AS total from staffs where status='On Leave'")->fetch_assoc()['total'];



//Appointment
$scheduled=$conn->query("SELECT COUNT(*) AS total from appointments where status='scheduled'")->fetch_assoc()['total'];
$completed=$conn->query("SELECT COUNT(*) AS total from appointments where status='completed'")->fetch_assoc()['total'];
$cancelled=$conn->query("SELECT COUNT(*) AS total from appointments where status='cancelled'")->fetch_assoc()['total'];

//Inventory
$totalinvent=$conn->query("SELECT COUNT(*) AS total from inventory")->fetch_assoc()['total'];
$available=$conn->query("SELECT COUNT(*)AS total from inventory where status='Available'")->fetch_assoc()['total'];
$lowstock=$conn->query("SELECT COUNT(*)AS total from inventory where status='Low Stock'")->fetch_assoc()['total'];
$expired=$conn->query("SELECT COUNT(*)AS total from inventory where status='Expired'")->fetch_assoc()['total'];

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background-image: url(https://static.vecteezy.com/system/resources/previews/006/712/985/non_2x/abstract-health-medical-science-healthcare-icon-digital-technology-science-concept-modern-innovation-treatment-medicine-on-hi-tech-future-blue-background-for-wallpaper-template-web-design-vector.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Oswald', sans-serif;
            background-attachment: fixed;
        }


        .welcome {
            background-color: rgba(255, 255, 255, 0.05);
            height: 1060px;
            margin: 0 5px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .welcome h1 {
            color: white;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            text-align: center;
            padding: 20px 0;
        }


        .stats{
            display:flex;
            gap:50px;
            justify-content:center;
            flex-wrap:wrap;
        }
        .statgroup{
            background: rgba(0,0,0,0.7);
            border-radius: 15px;
            width: 300px;
            padding:20px;
            box-shadow:0 0 15px aqua;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .statgroup:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 28px rgba(244, 0, 0, 0.85);
        }
        .circle{
            width: 100px;
            height:100px;
            border-radius:50%;
            border:5px solid red;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            font-weight:bold;
            color:white;
            margin: 0 auto 25px;
        } 
        .label{
            color:white;
            font-weight:bold;
            font-size:20px;
            margin-bottom:25px;
            text-align:center;
        }
        .plabel{
            color:white;
            font-weight:bold;
        }
        .progressgroup{
            margin-bottom:12px;
        }
        progress{
            width:100%;
            height:20px;
            border-radius:10px;
            overflow:hidden;
            -webkit-appearance:none;
        }
        progress::-webkit-progress-bar{
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        progress::-webkit-progress-value{
            background-color:aqua;
            border-radius:10px;
        }
        .pvalue{
            font-size:16px;
            font-weight:bold;
            text-align:right;
            color:white;
        }

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main">
        
        <div class="welcome">
            <h1>Welcome, Admin</h1>
            <div class="stats">
                <!-- Patients -->
                <div class="statgroup" onclick="window.location.href='patient_edit.php'">
                    <div class="circle"><?php echo $activepatients; ?></div>
                    <div class="label">Active Patients</div>
                    <div class="progressgroup">
                        <div class="plabel">Discharged</div>
                        <progress max="<?php echo $activepatients+$discharged+$deceased+$inactive;?>" value="<?php echo $discharged; ?>"></progress>
                        <div class="pvalue"><?php echo $discharged; ?></div>
                    </div>
                    <div class="progressgroup">
                        <div class="plabel">Deceased</div>
                        <progress max="<?php echo $activepatients+$discharged+$deceased+$inactive;?>" value="<?php echo $deceased; ?>"></progress>
                        <div class="pvalue"><?php echo $deceased; ?></div>
                    </div>
                    <div class="progressgroup">
                        <div class="plabel">Inactive</div>
                        <progress max="<?php echo $activepatients+$discharged+$deceased+$inactive;?>" value="<?php echo $inactive; ?>"></progress>
                        <div class="pvalue"><?php echo $inactive; ?></div>
                    </div>
                </div>

                <!-- Staffs -->
                <div class="statgroup" onclick="window.location.href='staff_edit.php'">
                    <div class="circle"><?php echo $totalstaff; ?> </div>
                    <div class="label">Active Staffs</div>
                    <div class="progressgroup">
                        <div class="plabel">Available</div>
                        <progress max="<?php echo $totalstaff;?>" value="<?php echo $availablestaff;?>"></progress>
                        <div class="pvalue"><?php echo $availablestaff;?></div>
                    </div>
                    <div class="progressgroup">
                        <div class="plabel">On Leave</div>
                        <progress max="<?php echo $totalstaff;?>" value="<?php echo $onleavestaff;?>"></progress>
                        <div class="pvalue"><?php echo $onleavestaff;?></div>
                    </div>
                </div>

                <!-- Appointments -->
                <div class="statgroup" onclick="window.location.href='appoint_edit.php'">
                    <div class="circle"><?php echo $scheduled; ?> </div>
                    <div class="label">Scheduled Appointments</div>
                    <div class="progressgroup">
                        <div class="plabel">Completed</div>
                        <progress max="<?php echo $scheduled+$completed+$cancelled;?>" value="<?php echo $completed; ?>"></progress>
                        <div class="pvalue"><?php echo $completed;?></div>
                    </div>
                    <div class="progressgroup">
                        <div class="plabel">Cancelled</div>
                        <progress max="<?php echo $scheduled+$completed+$cancelled;?>" value="<?php echo $cancelled; ?>"></progress>
                        <div class="pvalue"><?php echo $cancelled;?></div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="statgroup" onclick="window.location.href='inventory_edit.php'">
                    <div class="circle"><?php echo $totalinvent; ?></div>
                    <div class="label">Available Inventory</div>
                    <div class="progressgroup">
                        <div class="plabel">Low Stock</div>
                        <progress max="<?php echo $totalinvent;?>" value="<?php echo $lowstock; ?>"></progress>
                        <div class="pvalue"><?php echo $lowstock; ?></div>
                    </div>
                    <div class="progressgroup">
                        <div class="plabel">Expired</div>
                        <progress max="<?php echo $totalinvent;?>" value="<?php echo $expired; ?>"></progress>
                        <div class="pvalue"><?php echo $expired; ?></div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

            