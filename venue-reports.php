<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$sql = "SELECT COUNT(*) AS vens FROM venues WHERE id IN (SELECT venue_id FROM timetables)";
$result = $conn->query($sql);
$venuesInUse = "";
if($result->num_rows == 1){
    while($row = $result->fetch_assoc()){
        $venuesInUse = $row["vens"];
    }
}

$sql2 = "SELECT COUNT(*) AS vens FROM venues";
$result2 = $conn->query($sql2);
$totalVenues = "";
if($result2->num_rows == 1){
    while($row2 = $result2->fetch_assoc()){
        $totalVenues = $row2["vens"];
    }
}

$unusedVenues = $totalVenues - $venuesInUse;

$sql3 = "SELECT * FROM venues";
$result3 = $conn->query($sql3);
$vNames = array();
$vCounts = array();
if($result3->num_rows > 0){
    while($row3 = $result3->fetch_assoc()){
        $sql4 = "SELECT COUNT(*) AS v FROM timetables WHERE venue_id = ".$row3["id"];
        $result4 = $conn->query($sql4);
        if($result4->num_rows == 1){
            while($row4 = $result4->fetch_assoc()){
                array_push($vCounts, $row4["v"]);
                array_push($vNames, $row3["venue_name"]);
            }
        }
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Venue Reports";
</script>

<div class="container">
    <div class="cContainer shadow">
        <div class="rHead">
            <h3>Venue usage</h3>
        </div>
        <div class="rBody">
            <canvas id="venueUsage" style="width: 100%; height: calc(100% - 10px);"></canvas>
            <script>
                drawChart('venueUsage', 'doughnut', ['Unused', 'Used'], '# of Venues', [<?php echo json_encode($unusedVenues); ?>, <?php echo json_encode($venuesInUse); ?>], false, false);
            </script>
        </div>
    </div>

    <div class="cContainer shadow">
        <div class="rHead">
            <h3>Classes per venue</h3>
        </div>
        <div class="rBody">
            <canvas id="venueClasses" style="width: 100%; height: 100%;"></canvas>
            <script>
                drawChart('venueClasses', 'bar', <?php echo json_encode($vNames); ?>, '# of Units', <?php echo json_encode($vCounts); ?>, true, true);
            </script>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>