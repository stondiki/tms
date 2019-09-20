<?php
session_start();
include("includes/header.php");

if($_SESSION["role"] != "staff"){
    header("Location: index.php");
} else {
    include("controllers/db.php");
    $sql = "SELECT * FROM departments";
    $result = $conn->query($sql);
    $departments = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $departments[$row["id"]] = $row["department_name"];
        }
    }
    
    $sql3 = "SELECT * FROM courses";
    $result3 = $conn->query($sql3);
    $courses = array();
    if($result3->num_rows > 0){
        while($row3 = $result3->fetch_assoc()){
            $sql4 = "SELECT * FROM departments WHERE id = ".$row3["department_id"];
            $result4 = $conn->query($sql4);
            if($result4->num_rows > 0){
                while($row4 = $result4->fetch_assoc()){
                    $c = array(
                        'id' => $row3["id"],
                        'name' => $row3['course_name'],
                        'department_id' => $row3["department_id"],
                        'department_name' => $row4["department_name"]
                    );
                    array_push($courses, $c);
                }
            }
        }
    }
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Courses";
</script>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('addCourse'); log('action', 'Open add course modal', window.location.href);">
        <i class="fas fa-plus"> Add course</i>
    </button>
</div>

<!-- Start of Add Course Modal -->
<div class="modal-bg" id="addCourse">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add course</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addCourse'); log('action', 'Close add course modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-course.php" method="POST" id="addCourseForm">
                <div class="form-group">
                    <div class="row">
                        <label for="cname">Course name</label>
                        <input type="text" class="form-control" id="cname" name="cname" placeholder="Enter course name" required>
                    </div>
                    <div class="row">
                        <label for="cdid">Course department</label>
                        <select name="cdid" id="cdid" class="form-control">
                            <?php
                                foreach($departments as $department_id => $department_name){
                                    echo "<option value=\"".$department_id."\">".$department_name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('addCourse'); log('action', 'Close add course modal', window.location.href);">Cancel</button>
                    <button type="button" class="btn btn-block btn-primary" onclick="log('action', 'Submit add course', window.location.href); onSubmit('addCourseForm', 'controllers/create-course.php', window.location.href, 'addCourse');">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Course Modal -->

<!-- Start of Edit Course Modal -->
<div class="modal-bg" id="editCourse">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit course</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editCourse'); log('action', 'close edit course modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/edit-course.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="cid">Course ID</label>
                        <input type="text" class="form-control" id="ecid" name="cid" placeholder="Course ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="cname">Course name</label>
                        <input type="text" class="form-control" id="ecname" name="cname" placeholder="Enter course name" required>
                    </div>
                    <div class="row">
                        <label for="dname">Department name</label>
                        <select name="dname" id="edname" class="form-control" required>
                        <?php
                                foreach($departments as $department_id => $department_name){
                                    echo "<option value=\"".$department_id."\">".$department_name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('editCourse'); log('action', 'Close edit course modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-primary" onclick="log('action', 'Submit edit course modal', window.location.href);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Course Modal -->

<!-- Start of Delete Course Modal -->
<div class="modal-bg" id="deleteCourse">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Delete course</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('deleteCourse'); log('action', 'Close delete course modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/delete-course.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="dcid">Course ID</label>
                        <input type="text" class="form-control" id="dcid" name="cid" placeholder="Course ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="dcname">Course name</label>
                        <input type="text" class="form-control" id="dcname" name="cname" placeholder="Enter course name" readonly required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('deleteCourse'); log('action', 'Close delete course modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-danger" onclick="log('action', 'Submit delete course', window.location.href);">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Delete Course Modal -->

<!-- Start of Add Unit Modal -->
<div class="modal-bg" id="addUnit">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add unit</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addUnit'); log('action', 'Close add unit modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-unit.php" method="POST" id="addUnitForm">
                <div class="form-group">
                    <div class="row">
                        <label for="uname">Unit name</label>
                        <input type="text" class="form-control" id="uname" name="uname" placeholder="Enter unit name" required>
                    </div>
                    <div class="row">
                        <label for="ucode">Unit code</label>
                        <input type="text" class="form-control" id="ucode" name="ucode" placeholder="Enter unit code" required>
                    </div>
                    <div class="row">
                        <label for="ucid">Course ID</label>
                        <input type="text" class="form-control" id="ucid" name="ucid" placeholder="Course ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="ucname">Course name</label>
                        <input type="text" class="form-control" id="ucname" name="ucname" placeholder="Course name" readonly required>
                    </div>
                    <div class="row">
                        <label for="ubranch">Unit branch</label>
                        <input type="text" class="form-control" id="ubranch" name="ubranch" placeholder="Unit branch" required>
                    </div>
                    <div class="row">
                        <label for="uyear">Unit year</label>
                        <select name="uyear" id="uyear" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="usem">Unit semester</label>
                        <select name="usem" id="usem" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('addUnit'); log('action', 'Close add unit modal', window.location.href);">Cancel</button>
                    <button type="button" class="btn btn-block btn-primary" onclick="log('action', 'Submit add unit', window.location.href); onSubmit('addUnitForm', 'controllers/create-unit.php', window.location.href, 'addUnit');">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Unit Modal -->

<!-- Start of Course Table -->
<div class="container">
    <table class="table">
        <thead> 
            <tr>
                <th>Actions</th>
                <th>Course</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($courses as $x => $x_value){
                    echo "<tr>
                            <td>
                                <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"editCourse('".$x_value["id"]."', '".$x_value["name"]."', '".$x_value["department_id"]."'); toggleModal('editCourse'); log('action', 'Open edit ".$x_value["name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-pen\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"deleteCourse('".$x_value["id"]."', '".$x_value["name"]."'); toggleModal('deleteCourse'); log('action', 'Open delete ".$x_value["name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-trash\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-info\">
                                    <a href=\"units.php?cid=".$x_value["id"]."\"><i class=\"fas fa-eye\" onclick=\"log('navigation', 'View ".$x_value["name"]." units', window.location.href);\"> Units</i></a>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-secondary\" onclick=\"addUnit('".$x_value["id"]."', '".$x_value["name"]."'); toggleModal('addUnit'); log('action', 'Open add unit modal for ".$x_value["name"]."', window.location.href);\">
                                    <i class=\"fas fa-plus\"> Unit</i>
                                </button>
                            </td>
                            <td>".$x_value["name"]."</td>
                            <td>".$x_value["department_name"]."</td>
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