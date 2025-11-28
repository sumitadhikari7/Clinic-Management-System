<?php
include 'dbconnect.php';
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['doctor'];
    $date = $_POST['appointment_date'];
    $time = $_POST['time'];
    $status = $_POST['status'];


    $sql = "INSERT INTO appointments (patient_id, doctor, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);   
    if($stmt === false){
        die("Preparation Failed: " .$conn->error);
    }
    $stmt->bind_param("issss", $patient_id, $doctor, $date, $time, $status);

    if ($stmt->execute()) {
        header("Location: appoint.php");
        exit;
    } else {
        echo "Execute Error: " . $stmt->error;
    }
    
    $stmt->close();
}
    

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Appointment</title>
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
            background-image: url(https://www.medigy.com/offering/20449.JPEG);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Oswald', sans-serif;
            color: white;
            padding-bottom: 20px;
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

        form {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            margin: 0 auto 40px;
            width: 600px;
            font-weight: 700;
            font-size: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-size: 16px;
        }

        input,
        select {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-family: 'Oswald', sans-serif;
        }

        .btn {
            text-align: right;
            margin-top: 15px;
        }

        .btn input[type='submit'] {
            background-color: #00E5FF;
            width: 150px;
            border-radius: 6px;
            border: none;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            font-family: 'Oswald', sans-serif;
            transition: background-color 0.7s ease;
        }

        .btn input[type="submit"]:hover {
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
                <h1>Add New Appointment</h1>
            </div>
            <form action="appoint.php" method="post" id="appointmentform">
                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient</label>
                        <select name="patient_id" id="patient_id" required>
                            <option value="" disabled selected>Select Patient</option>
                            <?php
                            include 'dbconnect.php';
                            $sql="Select id, name from patients";
                            $result=mysqli_query($conn,$sql);
                            $num=mysqli_num_rows($result);

                            if($num>0)
                            {
                                while($row=mysqli_fetch_assoc($result))
                                {
                            ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="doctor">Doctor</label>
                        <select name="doctor" id="doctor">
                            <option value="" disabled selected>Select Doctor</option>
                            <?php
                            include 'dbconnect.php';
                            $sql="SELECT staff_id, name from staffs
                            WHERE role='Doctor'";
                            $result=mysqli_query($conn,$sql);
                            $num-mysqli_num_rows($result);

                            if($num>0){
                                while($row=mysqli_fetch_assoc($result))
                                {
                            ?>      <option value="<?php echo $row['staff_id'];?>"><?php echo $row['name'];?></option>  
                            <?php      
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" required />
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="btn">
                        <input type="submit" value="Add Appointment" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
