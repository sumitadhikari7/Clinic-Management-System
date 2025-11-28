<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';
$id=$_GET['id'];
$sql="SELECT * FROM patients WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
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
            <form action="" method="post" id="patientform">
                <label for="pname">Patient Name</label>
                <input type="text" id="pname" name="pname" value="<?php echo $row['name'];?>" required>
                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="<?php echo $row['age'];?>" required>
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male"<?php if($row['gender']=='male') echo 'selected';?>>Male</option>
                    <option value="female" <?php if($row['gender']=='female') echo 'selected';?>>Female</option>
                    <option value="other" <?php if($row['gender']=='other') echo 'selected';?>>Others</option>
                </select>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" value="<?php echo $row['address'];?>" required>
                <label for="contact">Phone Number</label>
                <input type="tel" name="contact" id="contact" value="<?php echo $row['phone'];?>" required>
                <label for="vdate">Visit Date</label>
                <input type="date" id="vdate" name="vdate" value="<?php echo $row['visit_date'];?>" required>
                <label for="diagnosis">Diagnosis</label>
                <input type="text" name="diagnosis" id="diagnosis" value="<?php echo $row['diagnosis'];?>" required>
                <label for="prescribe">Prescribed Medication</label>
                <input type="text" name="prescribe" id="prescribe" value="<?php echo $row['medication'];?>" required>
                <label for="fdate">Follow-up Date</label>
                <input type="date" id="fdate" name="fdate" value="<?php echo $row['followup_date'];?>">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="active" selected>Active</option>
                    <option value="discharged" <?php if($row['status']=='discharged') echo 'selected';?>>Discharged</option>
                    <option value="inactive" <?php if($row['status']=='inactive') echo 'selected';?>>Inactive</option>
                    <option value="deceased" <?php if($row['status']=='deceased') echo 'selected'?>>Deceased</option>
                </select>
                <div class="form-submit">
                    <input type="submit" value="Update Patient" name="update">
                </div>
            </form>
        </div>
    </div>
    <script>
        function logout() {
            window.location.href = "login.html";
        }
    </script>
</body>
</html>
<?php
if(isset($_POST['update'])){
    $name=$_POST['pname'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $address=$_POST['address'];
    $contact=$_POST['contact'];
    $vdate=$_POST['vdate'];
    $diagnosis=$_POST['diagnosis'];
    $prescribe=$_POST['prescribe'];
    $fdate=$_POST['fdate'];
    $status=$_POST['status'];

    $updatesql= "UPDATE patients SET
    name='$name',
    age='$age',
    gender='$gender',
    address='$address',
    phone='$contact',
    visit_date='$vdate',
    diagnosis='$diagnosis',
    medication='$prescribe',
    followup_date='$fdate',
    status='$status'
    where id='$id'";

    $updateresult=mysqli_query($conn,$updatesql);

    if($updateresult){
        echo "<script> window.location.href='patient_edit.php';</script>";
    }
    else{
        echo "<script> alert('Error updating item');</script>";
    }
}
?>
