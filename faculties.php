<?php
session_start();
include("includes/header.php");

if($_SESSION["role"] != "staff"){
    header("Location: index.php");
} else {
    include("controllers/db.php");

    $sql = "SELECT * FROM faculties";
    $result = $conn->query($sql);
}

?>
<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Faculties";
</script>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('addFaculty'); log('action', 'Open add faculty modal', window.location.href);">
        <i class="fas fa-plus"> Add faculty</i>
    </button>
</div>

<!-- Start of Add Faculty Modal -->
<div class="modal-bg" id="addFaculty">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Add faculty</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('addFaculty'); log('action', 'Close add faculty modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-faculty.php" method="POST" id="addFacultyForm">
                <div class="form-group">
                    <div class="row">
                        <label for="fname">Faculty name</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter faculty name" required>
                    </div>
                    <br>
                    <button type="button" class="btn btn-secondary" onclick="toggleModal('addFaculty'); log('action', 'Close add faculty modal', window.location.href);">Close</button>
                    <button type="button" class="btn btn-primary" onclick="log('action', 'Submit add faculty', window.location.href); onSubmit('addFacultyForm', 'controllers/create-faculty.php', window.location.href, 'addFaculty');">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Add Faculty Modal -->

<!-- Start of Edit Faculty Modal -->
<div class="modal-bg" id="editFaculty">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit faculty</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editFaculty'); log('action', 'Close edit faculty modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/edit-faculty.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                    <div class="row">
                        <label for="fid">Faculty ID</label>
                        <input type="text" class="form-control disabled" id="efid" name="fid" placeholder="Faculty ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="fname">Faculty name</label>
                        <input type="text" class="form-control" id="efname" name="fname" placeholder="Faculty name" required>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('editFaculty'); log('action', 'Close edit faculty modal', window.location.href);">Cancel</button>
                <button type="submit" class="btn btn-primary btn-block" onclick="log('action', 'Submit edit faculty', window.location.href);">Save</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Faculty Modal -->


<!-- Start of Delete Faculty Modal -->
<div class="modal-bg" id="deleteFaculty">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit course</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('deleteFaculty'); log('action', 'Close delete faculty modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/delete-faculty.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                    <div class="row">
                        <label for="fid">Faculty ID</label>
                        <input type="text" class="form-control disabled" id="dfid" name="fid" placeholder="Faculty ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="fname">Faculty name</label>
                        <input type="text" class="form-control" id="dfname" name="fname" placeholder="Faculty name" readonly required>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('deleteFaculty'); log('action', 'Close delete faculty modal', window.location.href);">Cancel</button>
                <button type="submit" class="btn btn-danger btn-block" onclick="log('action', 'Submit delete faculty', window.location.href);">Delete</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Delete Faculty Modal -->

<!-- Start of Faculty Table -->
<div id="ftable" class="container">
    <table class="table">
        <thead> 
            <tr>
                <th>Actions</th>
                <th>Faculty</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>
                                <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"editFaculty('".$row["id"]."', '".$row["faculty_name"]."'); toggleModal('editFaculty'); log('action', 'Open edit faculty modal', window.location.href);\">
                                    <i class=\"fas fa-pen\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-danger\"  onclick=\"deleteFaculty('".$row["id"]."', '".$row["faculty_name"]."'); toggleModal('deleteFaculty'); log('action', 'Open delete faculty modal', window.location.href);\">
                                    <i class=\"fas fa-trash\"></i>
                                </button>
                            </td>
                            <td>
                                ".$row["faculty_name"]."
                            </td>
                        </tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</div>
<!-- End of Faculty Table -->

<?php
$conn->close();
include("includes/footer.php");
?>