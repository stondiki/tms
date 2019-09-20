<?php
session_start();
include("includes/header.php");
include("controllers/db.php");
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
$courses = array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $course = array(
            'id' => $row["id"],
            'name' => $row["course_name"],
            'department' => $row["department_id"],
        );
        array_push($courses, $course);
    }
}

$sql2 = "SELECT * FROM venues";
$result2 = $conn->query($sql2);
$venues = array();
if($result2->num_rows > 0){
    while($row2 = $result2->fetch_assoc()){
        $venue = array(
            'id' => $row2["id"],
            'name' => $row2["venue_name"],
            'type' => $row2["venue_type"]
        );
        array_push($venues, $venue);
    }
}

$sql3 = "SELECT * FROM timeslots";
$result3 = $conn->query($sql3);
$timeslots = array();
if($result3->num_rows > 0){
    while($row3 = $result3->fetch_assoc()){
        $timeslot = array(
            'id' => $row3["id"],
            'day' => $row3["slot_day"],
            'start' => $row3["slot_start_time"],
            'end' => $row3["slot_end_time"],
            'duration' => $row3["slot_duration"]
        );
        array_push($timeslots, $timeslot);
    }
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
$sql5 = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
FROM timetables, units, venues, timeslots, user_details, courses
WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id";
$result5 = $conn->query($sql5);
if($result5->num_rows > 0){
    while($row5 = $result5->fetch_assoc()){
        $t = array(
            'id' => $row5["id"],
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

$lecturers = array();
$sql6 = "SELECT DISTINCT(lecturer_id) FROM timetables";
$result6 = $conn->query($sql6);
if($result6->num_rows > 0){
    while($row6 = $result6->fetch_assoc()){
        $sql7 = "SELECT COUNT(*) AS co FROM timetables WHERE lecturer_id = ".$row6["lecturer_id"];
        $result7 = $conn->query($sql7);
        if($result7->num_rows == 1){
            while($row7 = $result7->fetch_assoc()){
                if($row7["co"] < 6){
                    $sql8 = "SELECT user_details.id, user_details.first_name, user_details.last_name
                    FROM user_details, logins
                    WHERE logins.user_role = 'lecturer' AND logins.id = user_details.login_id AND user_details.id = ".$row6["lecturer_id"];
                    $result8 = $conn->query($sql8);
                    if($result8->num_rows == 1){
                        while($row8 = $result8->fetch_assoc()){
                            $lec = array(
                                'id' => $row8["id"],
                                'name' => $row8["first_name"]." ".$row8["last_name"]
                            );
                            array_push($lecturers, $lec);
                        }
                    }
                }
            }
        }
    }
}

$sql9 = "SELECT user_details.id, user_details.first_name, user_details.last_name
FROM user_details, logins
WHERE logins.user_role = 'lecturer' AND logins.id = user_details.login_id AND user_details.id NOT IN (SELECT DISTINCT(lecturer_id) FROM timetables)";
$result9 = $conn->query($sql9);
if($result9->num_rows > 0){
    while($row9 = $result9->fetch_assoc()){
        $lec = array(
            'id' => $row9["id"],
            'name' => $row9["first_name"]." ".$row9["last_name"]
        );
        array_push($lecturers, $lec);
    }
}

/*$lecturers = array();
$sql6 = "SELECT user_details.id, user_details.first_name, user_details.last_name
FROM user_details, logins
WHERE logins.user_role = 'lecturer' AND logins.id = user_details.login_id";
$result6 = $conn->query($sql6);
if($result6->num_rows > 0){
    while($row6 = $result6->fetch_assoc()){
        $lec = array(
            'id' => $row6["id"],
            'name' => $row6["first_name"]." ".$row6["last_name"]
        );
        array_push($lecturers, $lec);
    }
}*/
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Timetable";
    let venues = <?php echo json_encode($venues); ?>;
    let timeslots = <?php echo json_encode($timeslots); ?>;
    let timet = <?php echo json_encode($tts); ?>
</script>

<div class="tab">
    <button id="defaultOpen" class="tablinks" onclick="openTab(event, 'view'); log('action', 'Open view timetable tab', window.location.href);">View timetable</button>
    <button class="tablinks" onclick="openTab(event, 'generate'); log('action', 'Open generate timetable tab', window.location.href);">Generate timetable</button>
</div>

<div id="view" class="tabcontent">
    <div class="container">
        <div class="" style="width: 500px;">
            <label for="">Filter by</label>
            <select name="filOp" id="ttFilterBy" class="form-control" onchange="updateFilter(this.value)">
                <option value="none">None</option>
                <option value="lecturer">Lecturer</option>
                <option value="venue">Venue</option>
                <option value="course">Course</option>
            </select>
            <select name="filVal" id="ttFilterSel" class="form-control" onchange="updateTT(this.value, document.getElementById('ttFilterBy').value)">
                
            </select>
        </div>
    </div>
    <div class="container">
          <ul id="ttList">
              
          </ul>
      </div>
</div>

<div id="generate" class="tabcontent">
    <div class="container">
        <button type="button" class="btn btn-danger" onclick="toggleModal('clearTT'); log('action', 'Open clear timetable modal', window.location.href);">Clear Timetable</button>
        <button type="button" class="btn btn-primary" onclick="toggleModal('customTT'); log('action', 'Open custom timetable modal', window.location.href);">Custom Timetable Placement</button>
    </div>
    <div class="container" style="width: 400px;">
        <label for="course">Select course to start timetable generation</label>
        <select name="course" id="course" class="form-control" style="width: 100px;" onchange="ttSetCourse(this.value)">
            <option value="">--Select--</option>
            <?php
                foreach($courses as $x => $x_value){
                    echo "<option value=\"".$x_value["id"]."\">".$x_value["name"]."</option>";
                }
            ?>
        </select>
    </div>
    <br>
    <div class="container">
        <button type="button" class="btn btn-primary" onclick="genTT(); log('action', 'Generate timetable', window.location.href);">Generate Timetable</button>
    </div>
    <div class="info" style="max-width: 1000px; min-height: 35px; height: auto;">
        <div style="width: 20px; float: left;"><i class="fas fa-info-circle"></i></div>
        <div style="width: calc(100% - 50px); float: left; padding: 0;">
            <p style="padding: 0; margin: 0;">The lecturer has to be selected before clicking add else the lecturer who was selected before clicking add will be assigned to the unit.</p>
        </div>
        <div style="width: 30px; float: right;"><button class="btn-outline-secondary" onclick="this.parentElement.parentElement.classList.add('hide')"><i class="fas fa-times"></i></button></div>
    </div>
    <div class="info" style="max-width: 1000px; min-height: 35px; height: auto; margin-top: 10px;">
        <div style="width: 20px; float: left;"><i class="fas fa-info-circle"></i></div>
        <div style="width: calc(100% - 50px); float: left; padding: 0;">
            <p style="padding: 0; margin: 0;">A lecturer can only be assigned a maximum of 6 units. Any more above that will not be inserted into the timetable.</p>
        </div>
        <div style="width: 30px; float: right;"><button class="btn-outline-secondary" onclick="this.parentElement.parentElement.classList.add('hide')"><i class="fas fa-times"></i></button></div>
    </div>
      <div class="container">
          <table class="table shadow">
              <thead>
                  <tr>
                      <th>Actions</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Lecturer</th>
                  </tr>
              </thead>
              <tbody id="ttSelect">

              </tbody>
          </table>
      </div>
      <div class="container">
        <button type="button" class="btn btn-primary" onclick="genTT(); log('action', 'Generate timetable', window.location.href);">Generate Timetable</button>
    </div>
</div>

<!-- Start of Clear Timetable Modal -->
<div class="modal-bg" id="clearTT">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Clear Course Timetable</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('clearTT'); log('action', 'Close clear timetable modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
                <form action="controllers/clear-timetable.php" method="POST">
                    <div class="row">
                        <label for="cname">Course</label>
                        <select class="form-control" name="cname" id="cname">
                            <option>--Select--</option>
                        <?php
                            foreach($courses as $x => $x_value){
                                echo "<option value=\"".$x_value["id"]."\">".$x_value["name"]."</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-secondary" onclick="toggleModal('clearTT'); log('action', 'Close clear timetable modal', window.location.href);">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="log('action', 'Submit clear timetable', window.location.href);">Submit</button>
                </form>
        </div>
    </div>
</div>
<!-- End of Clear Timetable Modal -->

<!-- Start of Custom Timetable Entry Modal -->
<div class="modal-bg" id="customTT">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Custom Timetable Entry</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('customTT'); log('action', 'Close custom timetable modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <div style="background-color: orange; color: white; padding: 5px; border-radius: 5px; margin-bottom: 10px;">
                <div style="width: 100%; float:left;">
                    <div style="width: 80%; float:left;">
                        <h3><i class="fas fa-info-circle"></i> Info</h3>
                    </div>
                    <div style="width: 10%; float:right;">
                        <button class="btn btn-outline-secondary" onclick="this.parentElement.parentElement.parentElement.classList.add('hide')"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div style="width: 100%; height: auto;">
                    <p>This facility is designed to be used before generating a timetable. If you use it after generating a timetable fro a given course, you should ensure the following:</p>
                    <p>1. The unit you want to add is not already on the timetable.</p>
                    <p>2. The chosen venue is not in use during the time you have chosen.</p>
                    <p>3. The lecturer you have chosen is not engaged during the time you have chosen and is taking less than 6 units this semester.</p>
                    <p>Failure to abide by the above rules will result in your attempts being rejected.</p>
                </div>
                
            </div>
            <form action="controllers/custom-timetable-entry.php" method="POST" id="customTTForm">
                <label for="cname">Course</label>
                <select class="form-control" name="cname" onchange="popUnits(this.value)">
                    <option>--Select--</option>
                    <?php
                        foreach($courses as $x => $x_value){
                            echo "<option value=\"".$x_value["id"]."\">".$x_value["name"]."</option>";
                        }
                    ?>
                </select>
                <label for="cname">Unit</label>
                <select class="form-control" name="unit" id="cTTe"></select>
                <label for="cname">Venue</label>
                <select class="form-control" name="venue" id="cTTv">
                    <?php
                        foreach($venues as $v => $v_value){
                            echo "<option value=\"".$v_value["id"]."\">".$v_value["name"]."</option>";
                        }
                    ?>
                </select>
                <label for="cname">Timeslot</label>
                <select name="time" class="form-control">
                    <?php
                        foreach($timeslots as $t => $t_value){
                            echo "<option value=\"".$t_value["id"]."\">".$t_value["day"]." : ".$t_value["start"]." - ".$t_value["end"]."</option>";
                        }
                    ?>
                </select>
                <label for="cname">Lecturer</label>
                <select name="lecturer" class="form-control">
                    <?php
                        foreach($lecturers as $l => $l_value){
                            echo "<option value=\"".$l_value["id"]."\">".$l_value["name"]."</option>";
                        }
                    ?>
                </select>
                <button class="btn btn-secondary" onclick="toggleModal('customTT'); log('action', 'Close custom timetable modal', window.location.href);">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="log('action', 'Submit custom timetable', window.location.href); onSubmit('customTTForm', 'controllers/custom-timetable-entry.php', window.location.href, 'customTT');">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Custom Timetable Modal -->

<script>
    document.getElementById('ttList').innerHTML = ttBody;
    giveTThead()
    setTT(timet);

    

    document.getElementById("defaultOpen").click();
</script>

<?php
include("includes/footer.php");
?>