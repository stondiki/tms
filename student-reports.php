<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sql = "SELECT COUNT(*) AS s FROM logins WHERE user_role = 'student'";
$result = $conn->query($sql);
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        $totalStudents = $row["s"];
    }
}

$sql2 = "SELECT COUNT(*) AS r FROM registrations WHERE semester_id = (SELECT id FROM semesters WHERE active = 'yes')";
$result2 = $conn->query($sql2);
if($result2->num_rows == 1){
    while($row2 = $result2->fetch_assoc()){
        $registeredStudents = $row2["r"];
    }
}
$unRegistered = $totalStudents - $registeredStudents;

$acLevels = array(1,2,3,4,5,6,7,8);
$acCount = array();
$acLevelNames = array();
foreach($acLevels as $x){
    $sql3 = "SELECT COUNT(*) AS t FROM students WHERE ac_level = ".$x;
    $result3 = $conn->query($sql3);
    if($result3->num_rows == 1){
        while($row3 = $result3->fetch_assoc()){
            $year = ceil($x / 2);
            if($x % 2 == 0){
                $semester = 2;
            } else {
                $semester = 1;
            }
            
            $a = "Year ".$year." Semester ".$semester;
            array_push($acLevelNames, $a);
            array_push($acCount, $row3["t"]);
        }
    }
}

?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Student Reports";
</script>

<div class="container">
    <div class="cContainer shadow">
        <div class="rHead">
            <h3>Student registration</h3>
        </div>
        <div class="rBody">
            <canvas id="studReg" style="width: 100%; height: calc(100% - 10px);"></canvas>
            <script>
                drawChart('studReg', 'doughnut', ['Registered', 'Not Registered'], '# of Students', [<?php echo json_encode($registeredStudents); ?>, <?php echo json_encode($unRegistered); ?>], false, false);
            </script>
        </div>
    </div>
</div>

<div class="container">
    <div class="shadow" style="width: 100%; padding: 10px; border-radius: 10px;">
        <div class="rHead">
            <h3>Academic level distribution</h3>
        </div>
        <div class="rBody">
            <canvas id="acLevelDis" style="width: 100%; height: calc(100% - 10px);"></canvas>
            <script>
                drawChart('acLevelDis', 'bar', <?php echo json_encode($acLevelNames); ?>, '# of Students', <?php echo json_encode($acCount); ?>, true, true);
            </script>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>