<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //it will run only after the fotm is submitted.
    $name = $_POST['pname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $vdate = $_POST['vdate'];
    $diagnosis = $_POST['diagnosis'];
    $prescribe = $_POST['prescribe'];
    $fdate = $_POST['fdate']; 
    $status = $_POST['status'];

    $sql = "INSERT INTO patients (name, age, gender, address, phone, visit_date, diagnosis, medication, followup_date, status) VALUES (?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sissssssss", $name, $age, $gender, $address, $contact, $vdate, $diagnosis, $prescribe, $fdate, $status);

    if ($stmt->execute()) {
        header("Location: patient.php");
        exit;
    } else {
        echo "Execute error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient</title>
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
            background-image: url(https://medicaldialogues.in/h-upload/2022/12/09/193335-alcohol-withdrawal-syndrome.jpg);
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
                <h1>Add New Patient</h1>
            </div>
            <form action="patient.php" method="post" id="patientform">
                <label for="pname">Patient Name</label>
                <input type="text" id="pname" name="pname" required>
                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Others</option>
                </select>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" required>
                <label for="contact">Phone Number</label>
                <input type="tel" name="contact" id="contact" required>
                <label for="vdate">Visit Date</label>
                <input type="date" id="vdate" name="vdate" required>
                <label for="diagnosis">Diagnosis</label>
                <input type="text" name="diagnosis" id="diagnosis" required>
                <label for="prescribe">Prescribed Medication</label>
                <input type="text" name="prescribe" id="prescribe" required>
                <label for="fdate">Follow-up Date</label>
                <input type="date" id="fdate" name="fdate">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="active" selected>Active</option>
                    <option value="discharged">Discharged</option>
                    <option value="inactive">Inactive</option>
                    <option value="deceased">Deceased</option>
                </select>
                <div class="form-submit">
                    <input type="submit" value="Add Patient">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
