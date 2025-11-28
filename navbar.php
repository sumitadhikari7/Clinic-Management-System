<?php
$role=$_SESSION['role'] ?? null;

if($role=='admin'){
    $dashboardlink='admin_dashboard.php';

}elseif($role=='staff'){
    $dashboardlink='staff_dashboard.php';
}else{
    $dashboardlink='login.php';
}
?>
<div class="navbar">
            <h1>HealthTrack</h1>
            <div class="links">
                <a href="<?php echo $dashboardlink;?>">Dashboard</a>
                <div class="dropdown">
                    <a href="#">Patients</a>
                    <div class="drop-content">
                        <a href="patient.php">Add Patient</a>
                        <a href="patient_view.php">View Patients</a>
                        <a href="patient_edit.php">Edit Patients</a>
                    </div>          
                </div>
                <div class="dropdown">
                    <a href="#">Appointments</a>
                    <div class="drop-content">
                        <a href="appoint.php">Add Appointments</a>
                        <a href="appoint_view.php">View Appointments</a>
                        <a href="appoint_edit.php">Edit Appointments</a>
                    </div>
                </div>
                <?php if($role=='admin'):?>
                <div class="dropdown">
                    <a href="#">Staffs</a>
                    <div class="drop-content">
                        <a href="staff.php">Add Staffs</a>
                        <a href="staff_view.php">View Staffs</a>
                        <a href="staff_edit.php">Edit Staffs</a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="dropdown">
                    <a href="#">Inventory</a>
                    <div class="drop-content">
                        <a href="inventory.php">Add Inventory</a>
                        <a href="inventory_view.php">View Inventory</a>
                        <a href="inventory_edit.php">Edit Inventory</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="report.php">Generate Report</a>
                </div>
                <a href="logout.php">Logout</a>
            </div>
        </div>
