<?php
session_start();
include("includes/header.php");

if($_SESSION["role"] != "staff"){
    header("Location: index.php");
} else {
    include("controllers/db.php");

    $sql = "SELECT * FROM faculties";
    $result = $conn->query($sql);
    $faculties = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $faculties[$row["id"]] = $row["faculty_name"];
        }
    }

    $sql2 = "SELECT * FROM departments";
    $result2 = $conn->query($sql2);
}
?>

<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Departments";
</script>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('addDepartment'); log('action', 'Open add department modal', window.location.href);">
        <i class="fas fa-plus"> Add department</i>
    </button>
</div>

<!-- Start of Add Department Modal -->
<div class="modal-bg" id="addDepartment">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add department</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addDepartment'); log('action', 'Close add department modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-department.php" method="POST" id="addDepartmentForm">
                <div class="form-group">
                    <div class="row">
                        <label for="fname">Department name</label>
                        <input type="text" class="form-control" id="dname" name="dname" placeholder="Enter department name" required>
                    </div>
                    <div class="row">
                        <label for="fname">Faculty name</label>
                        <select name="fname" id="fname" class="form-control" required>
                            <?php
                                foreach($faculties as $faculty_id => $faculty_name){
                                    echo "<option value=\"".$faculty_id."\">".$faculty_name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('addDepartment'); log('action', 'Close add department modal', window.location.href);">Cancel</button>
                    <button type="button" class="btn btn-block btn-primary" onclick="log('action', 'Submit add department', window.location.href); onSubmit('addDepartmentForm', 'controllers/create-department.php', window.location.href, 'addDepartment');">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Department Modal -->

<!-- Start of Edit Department Modal -->
<div class="modal-bg" id="editDepartment">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit department</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editDepartment'); log('action', 'Close edit department modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/edit-department.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="fname">Department ID</label>
                        <input type="text" class="form-control" id="edid" name="did" placeholder="Department ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="fname">Department name</label>
                        <input type="text" class="form-control" id="edname" name="dname" placeholder="Enter department name" required>
                    </div>
                    <div class="row">
                        <label for="fname">Faculty name</label>
                        <select name="fname" id="efname" class="form-control" required>
                        <?php
                                foreach($faculties as $faculty_id => $faculty_name){
                                    echo "<option value=\"".$faculty_id."\">".$faculty_name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('editDepartment'); log('action', 'Close edit department modal', window.location.href);">Cancel</button>
                    <button type="submit" class="btn btn-block btn-primary" onclick="log('action', 'Submit edit department', window.location.href);">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Department Modal -->

<!-- Start of Delete Department Modal -->
<div class="modal-bg" id="deleteDepartment">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Delete department</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('deleteDepartment'); log('action', 'Close delete department modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/delete-department.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                <div class="row">
                        <label for="ddid">Department ID</label>
                        <input type="text" class="form-control" id="ddid" name="did" placeholder="Department ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="ddname">Department name</label>
                        <input type="text" class="form-control" id="ddname" name="dname" placeholder="Enter department name" readonly required>
                    </div>
                    <div class="row">
                        <label for="dfname">Faculty name</label>
                        <input type="text" name="fname" id="dfname" class="form-control" placeholder="Faculty name" readonly required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('deleteDepartment'); log('action', 'Close delete department modal', window.location.href);">Close</button>
                    <button type="submit" class="btn btn-block btn-danger" onclick="log('action', 'Submit delete department', window.location.href);">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Delete Department Modal -->

<!-- Start of Department Table -->
<div class="container">
    <table class="table">
        <thead> 
            <tr>
                <th>Actions</th>
                <th>Department</th>
                <th>Faculty</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        $sql3 = "SELECT * FROM faculties WHERE id = ".$row2["faculty_id"];
                        $result3 = $conn->query($sql3);
                        if($result3->num_rows > 0){
                            while($row3 = $result3->fetch_assoc()){
                                echo "<tr>
                                    <td>
                                        <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"editDepartment('".$row2["id"]."', '".$row2["department_name"]."', '".$row3["id"]."'); toggleModal('editDepartment'); log('action', 'Open edit ".$row2["department_name"]." modal', window.location.href);\">
                                            <i class=\"fas fa-pen\"></i>
                                        </button>
                                        <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"deleteDepartment('".$row2["id"]."', '".$row2["department_name"]."', '".$row3["id"]."', '".$row3["faculty_name"]."'); toggleModal('deleteDepartment'); log('action', 'Open delete ".$row2["department_name"]." modal', window.location.href);\">
                                            <i class=\"fas fa-trash\"></i>
                                        </button>
                                    </td>
                                    <td>".$row2["department_name"]."</td>
                                    <td>".$row3["faculty_name"]."</td>
                                </tr>";
                            }
                        }
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<!-- End of Department Table -->

<?php
$conn->close();
include("includes/footer.php");
?>