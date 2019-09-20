<?php
session_start();
include("includes/header.php");
include("controllers/db.php");
$students = "";
$lecturers = "";
$sql = "SELECT COUNT(*) AS scount FROM logins WHERE user_role = 'student'";
$result = $conn->query($sql);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        $students = $row["scount"];
    }
}
$sql2 = "SELECT COUNT(*) AS lcount FROM logins WHERE user_role = 'lecturer'";
$result2 = $conn->query($sql2);
if($result2->num_rows == 1){
    while($row2 = $result2->fetch_assoc()){
        $lecturers = $row2["lcount"];
    }
}

?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Home";
</script>

<div class="container"  style="text-align: center;">
    <div class="img">
        <img src="images/tms-logo.png" alt="TMS Logo">
    </div>
</div>
<div class="container" style="text-align: center;">
    <div class="txt">
        <h1>Welcome to the Timetable Management System</h1>
    </div>
</div>
<br>
<div class="container" style="text-align: center;">
    <div class="txt">
        <h2>The system is serving:</h2>
    </div>
</div>

<div class="container">
    <div class="card" style="background: #ffc107;">
    <i class="fas fa-user-graduate" style="text-align: center; font-size: 75px;"></i>
        <div class="card-body">
            <h1><?php echo $students; ?></h1>
            <h3 class="card-text">Students</h3>
        </div>
    </div>
    <div class="card" style="background: #dc3545;">
    <i class="fas fa-chalkboard-teacher" style="text-align: center; font-size: 75px;"></i>
        <div class="card-body">
            <h1><?php echo $lecturers; ?></h1>
            <h3 class="card-text">Lecturers</h3>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>