<?php
session_start();
include("includes/header.php");
if($_SESSION["role"] != "staff"){
    header("Location: index.php");
} else {
    include("controllers/db.php");
    if(isset($_GET["cid"])){
        $sql = "SELECT * FROM units WHERE course_id = ".$_GET["cid"];
        $result = $conn->query($sql);
        $units = array();
        $course = "";
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql2 = "SELECT * FROM courses WHERE id = ".$row["course_id"];
                $result2 = $conn->query($sql2);
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        $course = $row2["course_name"];
                        $u = array(
                            'id' => $row["id"],
                            'name' => $row["unit_name"],
                            'code' => $row["unit_code"],
                            'course_id' => $row["course_id"],
                            'course_name' => $row2["course_name"],
                            'unit_branch' => $row["unit_branch"],
                            'unit_year' => $row["unit_year"],
                            'unit_semester' => $row["unit_semester"],
                            'preferred_venue' => $row["preferred_venue"]
                        );
                        array_push($units, $u);
                    }
                } else {
                    $resp = array(
                        'status' => 'Error',
                        'message' => 'Error retrieving course details.'
                    );
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'Error',
                'message' => 'Error retrieving units.'
            );
            echo json_encode($resp);
        }
    } else {
        $sql = "SELECT * FROM units";
        $result = $conn->query($sql);
        $units = array();
        $course = "All";
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql2 = "SELECT * FROM courses WHERE id = ".$row["course_id"];
                $result2 = $conn->query($sql2);
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        $u = array(
                            'id' => $row["id"],
                            'name' => $row["unit_name"],
                            'code' => $row["unit_code"],
                            'course_id' => $row["course_id"],
                            'course_name' => $row2["course_name"],
                            'unit_branch' => $row["unit_branch"],
                            'unit_year' => $row["unit_year"],
                            'unit_semester' => $row["unit_semester"],
                            'preferred_venue' => $row["preferred_venue"]
                        );
                        array_push($units, $u);
                    }
                } else {
                    $resp = array(
                        'status' => 'Error',
                        'message' => 'Error retrieving course details.'
                    );
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'Error',
                'message' => 'Error retrieving units.'
            );
            echo json_encode($resp);
        }
    }
    $sql3 = "SELECT * FROM courses";
    $result3 = $conn->query($sql3);
    $courses = array();
    if($result3->num_rows > 0){
        while($row3 = $result->fetch_assoc()){
            $c = array(
                'id' => $row3["id"],
                'name' => $row3["course_name"]
            );
            array_push($courses, $c);
        }
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "<?php echo "".$course ?> Units";
</script>

<!-- Start of Edit Unit Modal -->
<div class="modal-bg" id="editUnit">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit unit</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editUnit'); log('action', 'Close edit unit modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/edit-Unit.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="euid">Unit ID</label>
                        <input type="text" class="form-control" id="euid" name="uid" placeholder="Enter unit ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="euname">Unit name</label>
                        <input type="text" class="form-control" id="euname" name="uname" placeholder="Enter unit name" required>
                    </div>
                    <div class="row">
                        <label for="eucode">Unit code</label>
                        <input type="text" class="form-control" id="eucode" name="ucode" placeholder="Enter unit code" required>
                    </div>
                    <div class="row">
                        <label for="eucid">Course ID</label>
                        <input type="text" class="form-control" id="eucid" name="ucid" placeholder="Course ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="eucname">Course name</label>
                        <input type="text" class="form-control" id="eucname" name="ucname" placeholder="Course name" readonly required>
                    </div>
                    <div class="row">
                        <label for="eubranch">Unit branch</label>
                        <input type="text" class="form-control" id="eubranch" name="ubranch" placeholder="Unit branch" required>
                    </div>
                    <div class="row">
                        <label for="euyear">Unit year</label>
                        <select name="uyear" id="euyear" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="eusem">Unit semester</label>
                        <select name="usem" id="eusem" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="eupvenue">Preferred venue</label>
                        <select name="upvenue" id="eupvenue" class="form-control" required>
                            <option value="hall">hall</option>
                            <option value="room">room</option>
                            <option value="lab">lab</option>
                            <option value="open">open</option>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('editUnit'); log('action', 'Close edit unit modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-primary" onclick="log('action', 'Submit edit unit', window.location.href);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Unit Modal -->

<!-- Start of Delete Unit Modal -->
<div class="modal-bg" id="deleteUnit">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Delete unit</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('deleteUnit'); log('action', 'Close delete unit modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/delete-Unit.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="duid">Unit ID</label>
                        <input type="text" class="form-control" id="duid" name="uid" placeholder="Enter unit ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="duname">Unit name</label>
                        <input type="text" class="form-control" id="duname" name="uname" placeholder="Enter unit name" readonly required>
                    </div>
                    <div class="row">
                        <label for="ducode">Unit code</label>
                        <input type="text" class="form-control" id="ducode" name="ucode" placeholder="Enter unit code" readonly required>
                    </div>
                    <div class="row">
                        <label for="ducname">Course name</label>
                        <input type="text" class="form-control" id="ducname" name="ucname" placeholder="Course name" readonly required>
                    </div>

                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('deleteUnit'); log('action', 'Close delete unit modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-danger" onclick="log('action', 'Submit delete unit', window.location.href);">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Delete Unit Modal -->

<!-- Start of Course Table -->
<div class="container">
    <table class="table">
        <thead> 
            <tr>
                <th>Actions</th>
                <th>Unit name</th>
                <th>Unit code</th>
                <th>Course</th>
                <th>Unit branch</th>
                <th>Unit year</th>
                <th>Unit semester</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($units as $x => $x_value){
                    echo "<tr>
                        <td>
                            <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"editUnit('".$x_value["id"]."', '".$x_value["name"]."', '".$x_value["code"]."', '".$x_value["course_id"]."', '".$x_value["course_name"]."', '".$x_value["unit_branch"]."', '".$x_value["unit_year"]."', '".$x_value["unit_semester"]."', '".$x_value["preferred_venue"]."'); toggleModal('editUnit'); log('action', 'Open edit ".$x_value["name"]." modal', window.location.href);\">
                                <i class=\"fas fa-pen\"></i>
                            </button>
                            <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"deleteUnit('".$x_value["id"]."', '".$x_value["name"]."', '".$x_value["code"]."', '".$x_value["course_name"]."'); toggleModal('deleteUnit'); log('action', 'Open delete ".$x_value["name"]." modal', window.location.href);\">
                                <i class=\"fas fa-trash\"></i>
                            </button>
                        </td>
                        <td>".$x_value["name"]."</td>
                        <td>".$x_value["code"]."</td>
                        <td>".$x_value["course_name"]."</td>
                        <td>".$x_value["unit_branch"]."</td>
                        <td>".$x_value["unit_year"]."</td>
                        <td>".$x_value["unit_semester"]."</td>
                    </tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<!-- End of Course Table -->

<?php
$conn->close();
include("includes/footer.php");
?>