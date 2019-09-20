<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sql = "SELECT COUNT(*) AS l FROM user_details WHERE login_id IN (SELECT id FROM logins WHERE user_role = 'lecturer')";
$result = $conn->query($sql);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        $totalLecturers = $row["l"];
    }
}

$sql2 = "SELECT COUNT(*) AS l FROM user_details WHERE id IN (SELECT lecturer_id FROM timetables)";
$result2 = $conn->query($sql2);
if($result2->num_rows == 1){
    while($row2 = $result2->fetch_assoc()){
        $assignedLecturers = $row2["l"];
    }
}
$unAssignedLecturers = $totalLecturers - $assignedLecturers;

$lecturerNames = array();
$unitCounts = array();
$sql3 = "SELECT * FROM user_details WHERE login_id IN (SELECT id FROM logins WHERE user_role = 'lecturer')";
$result3 = $conn->query($sql3);
if($result3->num_rows > 0){
    while($row3 = $result3->fetch_assoc()){
        $sql4 = "SELECT COUNT(*) AS c FROM timetables WHERE lecturer_id = ".$row3["id"];
        $result4 = $conn->query($sql4);
        if($result4->num_rows == 1){
            while($row4 = $result4->fetch_assoc()){
                $name = $row3["first_name"]." ".$row3["last_name"];
                array_push($lecturerNames, $name);
                array_push($unitCounts, $row4["c"]);
            }
        }
    }
}

?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Lecturer Reports";
</script>

<div class="container">
    <div class="cContainer shadow">
        <div class="rHead">
            <h3>Lecturer Utilization</h3>
        </div>
        <div class="rBody">
            <canvas id="lecUsage" style="width: 100%; height: calc(100% - 10px);"></canvas>
            <script>
                drawChart('lecUsage', 'doughnut', ['Assigned', 'Unassigned'], '# of Venues', [<?php echo json_encode($assignedLecturers); ?>, <?php echo json_encode($unAssignedLecturers); ?>], false, false);
            </script>
        </div>
    </div>
</div>


<div class="container">
    <div class="shadow" style="width: 100%; padding: 10px; border-radius: 10px;">
        <div class="rHead">
            <h3>Unit Distribution</h3>
        </div>
        <div class="rBody">
            <canvas id="uDis" style="width: 100%; height: calc(100% - 10px);"></canvas>
            <script>
                drawChart('uDis', 'bar', <?php echo json_encode($lecturerNames); ?>, '# of Units', <?php echo json_encode($unitCounts); ?>, true, true);
            </script>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>