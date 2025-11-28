<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $start = isset($_POST['sdate']) ? $_POST['sdate'] : '';
    $end = isset($_POST['edate']) ? $_POST['edate'] : '';

    if (!$type || !$start || !$end) {
        echo '<tr><td colspan="3">Missing Required Parameters</td></tr>';
        exit;
    }

    switch ($type) {
        case 'visits':
            $sql = "SELECT name, visit_date, diagnosis FROM patients
                    WHERE visit_date BETWEEN ? AND ? ORDER BY visit_date ASC";
            break;

        case 'appointments':
            $sql = "SELECT 
                    a.*, 
                    p.name AS patient_name, 
                    s.name AS doctor_name ,
                    a.appointment_time AS appointment_time
                    FROM appointments a
                    JOIN patients p ON a.patient_id = p.id
                    JOIN staffs s ON a.doctor = s.staff_id
                    WHERE a.appointment_date BETWEEN ? AND ?
                    ORDER BY a.appointment_date ASC";
            break;

        case 'inventories':
            $sql = "SELECT item_name, quantity, expiry_date FROM inventory
                    WHERE expiry_date BETWEEN ? AND ? ORDER BY expiry_date ASC";
            break;

        default:
            echo '<tr><td colspan="3">Invalid Report Type</td></tr>';
            exit;
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo '<tr><td colspan="3">Prepare failed: ' . $conn->error . '</td></tr>';
        exit;
    }

    $stmt->bind_param("ss", $start, $end);

    if (!$stmt->execute()) {
        echo '<tr><td colspan="3">Execute failed: ' . $stmt->error . '</td></tr>';
        $stmt->close();
        $conn->close();
        exit;
    }

    $result = $stmt->get_result();
    if (!$result) {
        echo '<tr><td colspan="3">Query failed: ' . $stmt->error . '</td></tr>';
        $stmt->close();
        $conn->close();
        exit;
    }

    if ($result->num_rows === 0) {
        echo '<tr><td colspan="3">No records found</td></tr>';
        $stmt->close();
        $conn->close();
        exit;
    }

    while ($row = $result->fetch_assoc()) {
        switch ($type) {
            case 'visits':
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['visit_date']}</td>
                        <td>{$row['diagnosis']}</td>
                      </tr>";
                break;

            case 'appointments':
                echo "<tr>
                        <td>{$row['patient_name']}</td>
                        <td>{$row['doctor_name']}</td>
                        <td>{$row['appointment_time']}</td>
                      </tr>";
                break;

            case 'inventories':
                echo "<tr>
                        <td>{$row['item_name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['expiry_date']}</td>
                      </tr>";
                break;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<tr><td colspan="3">Invalid request method</td></tr>';
    exit;
}
?>
