<?php
session_start();
include("includes/header.php");
include("controllers/db.php");

$ac = "";
$course = "";
if($_SESSION["role"] == "student"){
    $acLevel = "SELECT * FROM students WHERE user_details_id = ".$_SESSION["usr_id"];
    $acres = $conn->query($acLevel);
    if($acres->num_rows == 1){
        while($acl = $acres->fetch_assoc()){
            $ac = $acl["ac_level"];
            $course = $acl["course"];
        }
    }

    $year = ceil($ac/2);
    if($ac % 2 == 0){
        $semester = 2;
    } else {
        $semester = 1;
    }

    $sem = "";
    $sql4 = "SELECT * FROM semesters WHERE active = 'yes'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows == 1){
        while($row4 = $result4->fetch_assoc()){
            $sem = $row4["id"];
        }
    }

    $tts = array();
    $sql5 = "SELECT units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
    FROM timetables, units, venues, timeslots, user_details, courses
    WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id AND timetables.course_id = ".$course." AND timetables.unit_year = ".$year." AND timetables.unit_semester = ".$semester."
    ORDER BY timeslots.id";
    $result5 = $conn->query($sql5);
    if($result5->num_rows > 0){
        while($row5 = $result5->fetch_assoc()){
            $t = array(
                'code' => $row5["unit_code"],
                'unit' => $row5["unit_name"],
                'venue' => $row5["venue_name"],
                'day' => $row5["slot_day"],
                'start' => $row5["slot_start_time"],
                'end' => $row5["slot_end_time"],
                'duration' => $row5["slot_duration"],
                'lecturer' => $row5["first_name"]." ".$row5["last_name"]
            );
            array_push($tts, $t);
        }
    }
} else if($_SESSION["role"] == "lecturer"){
    $sem = "";
    $sql4 = "SELECT * FROM semesters WHERE active = 'yes'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows == 1){
        while($row4 = $result4->fetch_assoc()){
            $sem = $row4["id"];
        }
    }

    $tts = array();
    $sql5 = "SELECT units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
    FROM timetables, units, venues, timeslots, user_details, courses
    WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id AND timetables.lecturer_id = ".$_SESSION["usr_id"]."
    ORDER BY timeslots.id";
    $result5 = $conn->query($sql5);
    if($result5->num_rows > 0){
        while($row5 = $result5->fetch_assoc()){
            $t = array(
                'code' => $row5["unit_code"],
                'unit' => $row5["unit_name"],
                'venue' => $row5["venue_name"],
                'day' => $row5["slot_day"],
                'start' => $row5["slot_start_time"],
                'end' => $row5["slot_end_time"],
                'duration' => $row5["slot_duration"],
                'lecturer' => $row5["first_name"]." ".$row5["last_name"]
            );
            array_push($tts, $t);
        }
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Timetable";
    let timet = <?php echo json_encode($tts); ?>
</script>

<div class="container2">
<?php
foreach($tts as $ttse => $ttse_value){
    if($_SESSION["role"] == "student"){
        echo "
        <div class=\"ttCard shadow\">
            <div class=\"ttCardHead\">
                <div class=\"ttCode\"><h3>".$ttse_value["code"]."</h3></div>
                <div class=\"ttTitle\"><h3>".$ttse_value["unit"]."</h3></div>
            </div>
            <div class=\"ttDt\">
                <div class=\"ttDay\">".strtoupper($ttse_value["day"])."</div>
                <div class=\"ttTime\">".$ttse_value["start"]." - ".$ttse_value["end"]."</div>
            </div>
            <div class=\"ttVenue\">Venue: ".$ttse_value["venue"]."</div>
            <div class=\"ttLec\">Lecturer: ".$ttse_value["lecturer"]."</div>
        </div>
    ";
    } else {
        echo "
        <div class=\"ttCard shadow\">
            <div class=\"ttCardHead\">
                <div class=\"ttCode\"><h3>".$ttse_value["code"]."</h3></div>
                <div class=\"ttTitle\"><h3>".$ttse_value["unit"]."</h3></div>
            </div>
            <div class=\"ttDt\">
                <div class=\"ttDay\">".strtoupper($ttse_value["day"])."</div>
                <div class=\"ttTime\">".$ttse_value["start"]." - ".$ttse_value["end"]."</div>
            </div>
            <div class=\"ttVenue\">Venue: ".$ttse_value["venue"]."</div>
        </div>
    ";
    }
}
?>
</div>

<?php
include("includes/footer.php");
?>