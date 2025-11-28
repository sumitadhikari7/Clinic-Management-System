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
    <title>Generate Report</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Oswald', sans-serif;
            
        }

        body {
            background-image: url(https://img.freepik.com/premium-vector/professional-medical-inventory-hospital-with-first-aid-thermometer_906149-68773.jpg?w=2000);
            background-size: cover;
            background-repeat: no-repeat;
            color: white;
            background-attachment: fixed;
            padding-bottom: 20px;
        }

        .welcome {
            background-color: rgba(255, 255, 255, 0.05);
            margin: 20px 5px;
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
        .output{
            text-align:center;
        }
        .output h4 {
            color: red;
            background-color:rgba(0, 0, 0, 0.2);
            border radius:10px;
            font-weight: 700;
            padding: 20px 0;
            text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.5);
            display:inline-block;
            margin:20px auto;
        }
        .form-submit {
            text-align: right;
            margin-top: 15px;
        }

        .form-submit input[type='button'] {
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

        .form-submit input[type="button"]:hover {
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
                <h1>Generate Report</h1>
            </div>
            <form action="report.php" method="post">
                <label for="reportType">Report Type</label>
                <select name="reportType" id="reportType">
                    <option value="visits">Visits</option>
                    <option value="appointments">Appointments</option>
                    <option value="inventories">Inventories</option>
                </select>
                
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate">

                <label for="end_date">End Date</label>
                <input type="date" name="endDate" id="endDate">

                <div class="form-submit">
                    <input type="button" value="Generate Report" id="reportGenerate">
                </div>
            </form>
            <div class="output" id="output">
                <h4>Report Preview</h4>
                <table>
                    <thead id="outputhead"></thead>
                    <tbody id="outputbody"></tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const reporttype= document.getElementById('reportType');
        const outputHead = document.querySelector('#outputhead');
        const outputBody= document.getElementById('outputbody');
        const output= document.getElementById('output');

        function update(type){
            let headers= '';
            switch(type){
                case 'visits':
                    headers = '<th>Patients</th><th>Date</th><th>Diagnosis</th>';
                    break;
                    case 'appointments':
                    headers = '<th>Patient</th><th>Doctor</th><th>Time</th>';
                    break;
                    case 'inventories':
                    headers = '<th>Item</th><th>Quantity</th><th>Expiry Date</th>';
                    break;
                    default:
                    headers = '<th>Data</th>';
                }
                outputHead.innerHTML= `<tr>${headers}</tr>`;
        }
        reporttype.addEventListener('change', function() {
            update(reporttype.value)
        });

        document.getElementById('reportGenerate').addEventListener('click',()=>{
            const type=reporttype.value;
            const sdate=document.getElementById('startDate').value;
            const edate=document.getElementById('endDate').value;

            if(!sdate || !edate){
                alert('Select both start and end date');
                return;
            }
            const body= new URLSearchParams({type, sdate, edate});
            fetch('reportfetch.php',{
                method: 'POST',
                body
            })
            .then(res=>res.text())
            .then(data=>{
                output.style.display='block';
                outputBody.innerHTML=data || '<tr><td colspan="3"> No data found</td></tr>';
            })
            .catch(()=> alert('Error fetching report.'));
        });
    </script>
    
</body>
</html>