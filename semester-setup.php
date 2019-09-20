<?php
session_start();
include("includes/header.php");
if($_SESSION["role"] == "staff"){
    include("controllers/db.php");
    $sql = "SELECT * FROM academic_years";
    $result = $conn->query($sql);
    $ayears = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $y = array(
                'id' => $row["id"],
                'years' => $row["year_span"]
            );
            array_push($ayears, $y);
        }       
    }
}

$sql2 = "SELECT * FROM semesters WHERE active = 'yes'";
$result2 = $conn->query($sql2);
$as = array();
if($result2->num_rows > 0){
    while($row2 = $result2->fetch_assoc()){
        $a = array(
            'id' => $row2["id"],
            'semester' => $row2["semester"],
            'start' => $row2["sem_start"],
            'end' => $row2["sem_end"],
            'active' => $row2["active"],
            'registration' => $row2["registration"]
        );
        array_push($as, $a);
    }
}

$sql3 = "SELECT * FROM courses";
$result3 = $conn->query($sql3);
$courses = array();
if($result3->num_rows > 0){
    while($row3 = $result3->fetch_assoc()){
        $c = array(
            'id' => $row3["id"],
            'name' => $row3["course_name"]
        );
        array_push($courses, $c);
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Semester Setup";
</script>

<div class="container">
    <h3>Current Semester</h3>
</div>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Semester</th>
                <th>Start</th>
                <th>End</th>
                <th>Active</th>
                <th>Registration</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($as as $sem => $sem_value){
                    echo "<tr>
                        <td>".$sem_value["semester"]."</td>
                        <td>".$sem_value["start"]."</td>
                        <td>".$sem_value["end"]."</td>
                        <td>".$sem_value["active"]."</td>
                        <td>".$sem_value["registration"]."</td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('setSem'); log('action', 'Open set semester modal', window.location.href);">
        <i class="fas fa-edit"> Set semester</i>
    </button>
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('incrementSemester'); log('action', 'Open increment semester modal', window.location.href);">
        <i class="fas fa-edit"> Move students to the next semester</i>
    </button>
</div>

<!-- Start of Set Semester Modal -->
<div class="modal-bg" id="setSem">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Set semester</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('setSem'); log('action', 'Close set semester modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/set-semester.php" method="POST" class="mx-auto p-3">
                <div class="row">
                    <label for="eayear">Academic Year</label>
                    <select name="ayear" id="eayear" class="form-control" onchange="getSems()">
                        <option value="">--select--</option>
                        <?php
                            foreach($ayears as $x => $x_value){
                                echo "<option value=\"".$x_value["id"]."\">".$x_value["years"]."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <label for="esem">Semester</label>
                    <select name="sem" id="esem" class="form-control">
                        <option value="">--select academic year to populate this--</option>
                    </select>
                </div>
                <div class="row">
                    <label for="act">Active</label>
                    <select name="act" id="act" class="form-control">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="row">
                    <label for="reg">Registration</label>
                    <select name="reg" id="reg" class="form-control">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <br>
                <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('setSem'); log('action', 'Close set semester modal', window.location.href);">Cancel</button>
                <button type="submit" class="btn btn-block btn-primary" onclick="log('action', 'Submit set semester', window.location.href);">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Set Semester Modal -->

<!-- Start of Increment Student Semester Modal -->
<div class="modal-bg" id="incrementSemester">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Increment student semesters</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('incrementSemester'); log('action', 'Close increment semester modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/increment-semesters.php" method="POST">
                <div class="form-group">
                    <div class="row">
                        <label for="sem">This will move all the students to the next semester</label>
                    </div>
                    <br>
                    <button type="button" class="btn btn-secondary" onclick="toggleModal('incrementSemester'); log('action', 'Close increment semester modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-primary" onclick="log('action', 'Submit increment semester', window.location.href);">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Increment Student Semester Modal -->

<?php
include("includes/footer.php");
?>