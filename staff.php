<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['role']!=='admin'){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $name=$_POST['name'];
    $role=$_POST['role'];
    $department=$_POST['department'];
    $contact=$_POST['tel'];
    $email=$_POST['email'];
    $joined=$_POST['join'];

    $sql= "INSERT INTO staffs(name,role,department,contact,email,joined) VALUES(?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    if($stmt===false){
        die("Preparation failed: " .$conn->error);
    }
    $stmt->bind_param('ssssss',$name,$role,$department,$contact,$email,$joined);

    if($stmt->execute()){
        header("Location: staff.php");
        exit;
    }
    else{
        echo "Execute error: " .$stmt->error;
    }
    $stmt->close();
}
$conn->close();
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
        html,
        body {
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
            margin: 0 auto 40px;
            width: 600px;
            border-radius: 10px;
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            flex: 1;
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
                <h1> Add New Staff Records</h1>
            </div>
            <form action="staff.php" method="post" id="staff-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" required>

                            <option value="Doctor">Doctor</option>
                            <option value="Nurse">Nurse</option>
                            <option value="Receptionist">Receptionist</option>
                            <option value="Pharmacist">Pharmacist</option>
                            <option value="Cleaner">Cleaner</option>
                            <option value="" disabled selected>Select Role</option>
                        </select>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" id="department">
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Emergency">Emergency</option>
                            <option value="" selected disabled>Select Department</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="tel" name="tel" id="tel">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="joindate">Joined On</label>
                        <input type="date" id="join" name="join">
                    </div>
                </div>
                <div class="btn">
                    <input type="submit" value="Add Staff">
                </div>
            </form>
           
        </div>
    </div>

</body>

</html>