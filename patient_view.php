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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient View</title>
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
                <h1>Patient Records</h1>
            </div>
            <form action="" method="GET">
                <label for="filter" id="fil">Filter by Status:</label>
                <select name="status" id="filter">
                    <option value=""<?php if(!isset($_GET['status'])|| $_GET['status']=='') echo 'selected';?>>All</option>
                    <option value="active"<?php if(isset($_GET['status'])&&$_GET['status']=='active') echo 'selected';?>>Active</option>
                    <option value="inactive"<?php if(isset($_GET['status'])&&$_GET['status']=='inactive') echo 'selected';?>>Inactive</option>
                    <option value="discharged"<?php if(isset($_GET['status'])&&$_GET['status']=='discharged') echo 'selected';?>>Discharged</option>
                    <option value="deceased"<?php if(isset($_GET['status'])&&$_GET['status']=='deceased') echo 'selected';?>>Deceased</option>
                </select>
                <script>
                    document.getElementById("filter").addEventListener("change",function(){
                        this.form.submit();
                    });
                </script>
            </form>
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
                </tr>

                <?php
                    include 'dbconnect.php';
                    $status_filter = $_GET['status'] ?? '';
                    // if status_fikter exists it uses its value otherwise uses empty ''.

                    if ($status_filter !== '') {
                        $sql = "Select * from patients
                                WHERE patients.status = '$status_filter'";
                    } else {
                        $sql = "SELECT * from patients";
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
