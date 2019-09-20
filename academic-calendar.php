<?php
session_start();
include("includes/header.php");

include("controllers/db.php");
$sql = "SELECT * FROM academic_years";
$result = $conn->query($sql);
$re = array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $r = array(
            'id' => $row["id"],
            'years' => $row["year_span"]
        );
        array_push($re, $r);
    }
}

$sql2 = "SELECT * FROM semester_events ORDER BY s_date";
$result2 = $conn->query($sql2);
$ev = array();
if($result2->num_rows > 0){
    while($row2 = $result2->fetch_assoc()){
        $e = array(
            'id' => $row2["id"],
            'event_description' => $row2["event_description"],
            'start' => $row2["s_date"],
            'end' => $row2["e_date"]
        );
        array_push($ev, $e);
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Academic Calendar";
</script>

<?php
    if(isset($_SESSION["role"])):
        if($_SESSION["role"] == "staff"):
?>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('addAcademicYear'); log('action', 'Open add academic year modal button', window.location.href);">
        <i class="fas fa-plus"> Academic year</i>
    </button>
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('addEvent'); log('action', 'Open add event modal button', window.location.href);">
        <i class="fas fa-plus"> Event</i>
    </button>
</div>

<!-- Start of Add Academic Year Modal -->
<div class="modal-bg" id="addAcademicYear">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add academic year</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addAcademicYear'); log('action', 'Close add academic year modal button', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-academic-year.php" method="POST" id="addAcademicYearForm">
                <div class="form-group">
                    <div class="row">
                        <label for="fname">Academic Year</label>
                        <input type="text" class="form-control" id="ayear" name="ayear" placeholder="eg. 2019-2020" required>
                    </div>
                    <div class="row">
                        <label for="fname">September-December semester start</label>
                        <input type="date" class="form-control" name="sepdecstart" id="sepdecstart" placeholder="Sep-Dec semester start" required>
                    </div>
                    <div class="row">
                        <label for="fname">September-December semester end</label>
                        <input type="date" class="form-control" name="sepdecend" id="sepdecend" placeholder="Sep-Dec semester end" required>
                    </div>
                    <div class="row">
                        <label for="fname">January-April semester start</label>
                        <input type="date" class="form-control" name="janaprstart" id="janaprstart" placeholder="Jan-Apr semester start" required>
                    </div>
                    <div class="row">
                        <label for="fname">January-April semester end</label>
                        <input type="date" class="form-control" name="janaprend" id="janaprend" placeholder="Jan-Apr semester end" required>
                    </div>
                    <div class="row">
                        <label for="fname">May-August semester start</label>
                        <input type="date" class="form-control" name="mayaugstart" id="mayaugstart" placeholder="May-Aug semester start" required>
                    </div>
                    <div class="row">
                        <label for="fname">May-August semester end</label>
                        <input type="date" class="form-control" name="mayaugend" id="mayaugend" placeholder="May-Aug semester end" required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('addAcademicYear'); log('action', 'Cancel add academic year modal button', window.location.href);">Cancel</button>
                    <button type="button" class="btn btn-block btn-primary" onclick="log('action', 'Submit add academic year modal button', window.location.href); onSubmit('addAcademicYearForm', 'controllers/create-academic-year.php', window.location.href, 'addAcademicYear');">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Academic Year Modal -->

<!-- Start of Add Event Modal -->
<div class="modal-bg" id="addEvent">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add event</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addEvent'); log('action', 'close add event modal button', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-event.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                    <div class="row">
                        <label for="eayear">Academic Year</label>
                        <select class="form-control" name="eayear" id="eayear" onchange="getSems()">
                            <option value="">Select</option>
                            <?php
                                foreach($re as $x => $x_value){
                                    echo "<option value=\"".$x_value["id"]."\">".$x_value["years"]."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <label for="sem">Semester</label>
                        <select class="form-control" name="sem" id="esem">

                        </select>
                    </div>
                    <div class="row">
                        <label for="estart">Event start</label>
                        <input type="date" class="form-control" name="estart" id="estart" placeholder="Event start" required>
                    </div>
                    <div class="row">
                        <label for="eend">Event end</label>
                        <input type="date" class="form-control" name="eend" id="eend" placeholder="Event end" required>
                    </div>
                    <div class="row">
                        <label for="edescription">Event description</label>
                        <input type="text" class="form-control" name="edescription" id="edescription" placeholder="Event description">
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('addEvent'); log('action', 'Cancel add event modal button', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-primary" onclick="log('action', 'Submit add event modal button', window.location.href);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Event Modal -->

<?php
        endif;
    endif;
?>

<!-- Start of Academic Calendar Table -->
<div class="container">
    <table class="table">
        <thead class="thead-dark"> 
            <tr>
                <th>Start date</th>
                <th>End date</th>
                <th>Event description</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($ev as $event => $event_value){
                    echo "<tr>
                        <td>".$event_value["start"]."</td>
                        <td>".$event_value["end"]."</td>
                        <td>".$event_value["event_description"]."</td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<!-- End of Academic Calendar Table -->

<?php
include("includes/footer.php");
?>