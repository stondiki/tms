<?php
session_start();

if($_SESSION["role"] != "staff"){
    header("Location: index.php");
} else {
    include("controllers/db.php");

    $sql = "SELECT logins.id AS lid, logins.user_email AS email, logins.user_role AS user_role,
    user_details.id AS usid, user_details.first_name AS fname, user_details.last_name AS lname, user_details.other_names AS oname, user_details.user_img AS uimg, user_details.phone_number AS phone
    FROM logins, user_details
    WHERE logins.id = user_details.login_id
    ORDER BY user_details.id";
    $list = $conn->query($sql);
    $users = array();
    if($list->num_rows > 0){
        while($row = $list->fetch_assoc()){
            $u = array(
                'login_id' => $row["lid"],
                'email' => $row["email"],
                'role' => $row["user_role"],
                'user_id' => $row["usid"],
                'first_name' => $row["fname"],
                'last_name' => $row["lname"],
                'other_names' => $row["oname"],
                'img' => $row["uimg"],
                'phone' => $row["phone"],
            );
            array_push($users, $u);
        }
    }

    $sql2 = "SELECT * FROM courses";
    $result2 = $conn->query($sql2);
    $courses = array();
    if($result2->num_rows > 0){
        while($row2 = $result2->fetch_assoc()){
            $c = array(
                'id' => $row2["id"],
                'course' => $row2["course_name"]
            );
            array_push($courses, $c);
        }
    }
}

include("includes/header.php");
?>
<script>
    let ttl = document.getElementById("page-title");
    ttl.innerHTML = "Users";
</script>

<div class="container">
    <button type="button" class="btn btn-outline-primary" onclick="toggleModal('createUser'); log('action', 'Open create user modal', window.location.href);">
        <i class="fas fa-user-plus"> Create new user</i>
    </button>
</div>

<!-- Start of Create User Modal -->
<div class="modal-bg" id="createUser">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Create user</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('createUser'); log('action', 'Close create user modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/create-user.php" method="POST" id="createUserForm">
                <div class="form-group">
                    <div class="row">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" name="fname" placeholder="Enter first name" required>
                    </div>
                    <div class="row">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" name="lname" placeholder="Enter last name" required>
                    </div>
                    <div class="row">
                        <label for="oname">Other names</label>
                        <input type="text" class="form-control" name="oname" placeholder="Enter other names">
                    </div>
                    <div class="row">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="row">
                        <label for="phone">Phone number</label>
                        <input type="number" class="form-control" name="phone" placeholder="Enter phone number" required>
                    </div>
                    <div class="row">
                        <label for="role">Role</label>
                        <select name="role" class="form-control">
                            <option value="student">Student</option>
                            <option value="lecturer">Lecturer</option>
                            <option value="staff">Admin</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('createUser'); log('action', 'Close create user modal', window.location.href);">Cancel</button>
                <button type="button" class="btn btn-primary btn-block" onclick="log('action', 'Submit create user', window.location.href); onSubmit('createUserForm', 'controllers/create-user.php', window.location.href, 'createUser');">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Create User Modal -->

<!-- Start of Edit User Modal -->
<div class="modal-bg" id="editUser">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit user</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editUser'); log('action', 'Close edit user modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
        <form action="controllers/edit-user.php" method="POST" class="mx-auto p-3">
            <div class="form-group">
            <div class="row">
                    <input type="text" class="form-control disabled" id="uid" name="uid" placeholder="User ID" hidden readonly required>
                </div>
                <div class="row">
                    <label for="fname">First name</label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter first name" required>
                </div>
                <div class="row">
                    <label for="lname">Last name</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" required>
                </div>
                <div class="row">
                    <label for="oname">Other names</label>
                    <input type="text" class="form-control" id="oname" name="oname" placeholder="Enter other names">
                </div>
                <div class="row">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="row">
                    <label for="phone">Phone number</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                </div>
                <div class="row">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="student">Student</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="staff">Admin</option>
                    </select>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('editUser'); log('action', 'Close edit user modal', window.location.href);">Cancel</button>
            <button type="submit" class="btn btn-primary btn-block" onclick="log('action', 'Submit edit user', window.location.href);">Save</button>
        </form>
        </div>
    </div>
</div>
<!-- End of Edit User Modal -->

<!-- Start of Delete User Modal -->
<div id="delUser" class="modal-bg">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Delete user</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('delUser'); log('action', 'Close delete user modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
            <form action="controllers/delete-user.php" method="POST" class="mx-auto p-3">
                <div class="form-group">
                    <div class="row">
                        <input type="hidden" class="form-control disabled" id="duid" name="uid" placeholder="User ID" readonly required>
                    </div>
                    <div class="row">
                        <label for="fname">First name</label>
                        <input type="text" class="form-control" id="dfname" name="fname" placeholder="First name" readonly required>
                    </div>
                    <div class="row">
                        <label for="lname">Last name</label>
                        <input type="text" class="form-control" id="dlname" name="lname" placeholder="Last name" readonly required>
                    </div>
                    <div class="row">
                        <label for="drole">Role</label>
                        <input type="text" class="form-control" id="drole" name="role" placeholder="Role" readonly required>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('delUser'); log('action', 'Close delete user modal', window.location.href);">Cancel</button>
                <button type="submit" class="btn btn-danger btn-block" onclick="log('action', 'Submit delete user', window.location.href);">Delete</button>
            </form>
        </div>
    </div>
</div>
<!-- End of Delete User Modal -->

<!-- Start of Edit User Course Modal -->
<div class="modal-bg" id="editCourse">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><h2>Edit course</h2></div>
            <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('editCourse'); log('action', 'Close edit user course modal', window.location.href);"><i class="fas fa-times"></i></button></div>
        </div><hr>
        <div class="modal-body">
        <form action="controllers/set-student-course.php" method="POST" class="mx-auto p-3">
            <div class="form-group">
            <div class="row">
                    <input type="text" class="form-control" id="suid" name="suid" placeholder="Student ID" hidden readonly required>
                </div>
                <div class="row">
                    <label for="sname">Student name</label>
                    <input type="text" class="form-control" id="sname" name="sname" placeholder="First name" readonly required>
                </div>
                <div class="row">
                    <label for="scourse">Course</label>
                    <select name="scourse" id="scourse" class="form-control">
                        <?php
                            foreach($courses as $course => $course_value){
                                echo "<option value = ".$course_value["id"].">".$course_value["course"]."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <button type="button" class="btn btn-secondary btn-block" onclick="toggleModal('editCourse'); log('action', 'Close edit user course modal', window.location.href);">Cancel</button>
            <button type="submit" class="btn btn-primary btn-block" onclick="log('action', 'Submit edit user course', window.location.href);">Save</button>
        </form>
      </div>
    </div>
</div>
<!-- End of Edit User Course Modal -->

<!-- Start of User Table -->
<div id="table" class="container mt-3">
    <table class="table table-striped table-hover shadow p-3 mb-5 table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Actions</th>
                <th scope="col">Img</th>
                <th scope="col">First Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Other Names</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($users as $x => $x_value){
                if($x_value["role"] == "student"){
                    echo "<tr>
                            <td>
                                <button type=\"button\" class=\"btn btn-outline-primary\" onclick=\"editUser('" . $x_value["login_id"] . "', '" . $x_value["first_name"] . "', '" . $x_value["last_name"] . "', '" . $x_value["other_names"] . "', '" . $x_value["email"] . "', '" . $x_value["phone"] . "', '" . $x_value["role"] . "'); toggleModal('editUser'); log('action', 'Open edit user ".$x_value["first_name"]." ".$x_value["last_name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-pen\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-danger\"  onclick=\"deleteUser('" . $x_value["login_id"] . "', '" . $x_value["first_name"] . "', '" . $x_value["last_name"] . "', '" . $x_value["role"] . "'); toggleModal('delUser'); log('action', 'Open delete user ".$x_value["first_name"]." ".$x_value["last_name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-trash\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-info\" onclick=\"editStudentCourse('" . $x_value["user_id"] . "', '" . $x_value["first_name"] . "', '" . $x_value["last_name"] . "'); toggleModal('editCourse'); log('action', 'Open edit user course ".$x_value["first_name"]." ".$x_value["last_name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-book\"></i>
                                </button>
                            </td>
                            <td><img src=\"" . $x_value["img"] . "\" alt=\"User Img\" style=\"width: 30px;\"></td>
                            <td>" . $x_value["first_name"] . "</td>
                            <td>" . $x_value["last_name"] . "</td>
                            <td>" . $x_value["other_names"] . "</td>
                            <td>" . $x_value["email"] . "</td>
                            <td>" . $x_value["phone"] . "</td>
                            <td>" . $x_value["role"] . "</td>
                        </tr>";
                } else {
                    echo "<tr>
                            <td>
                                <button type=\"button\" class=\"btn btn-outline-primary\"  onclick=\"editUser('" . $x_value["login_id"] . "', '" . $x_value["first_name"] . "', '" . $x_value["last_name"] . "', '" . $x_value["other_names"] . "', '" . $x_value["email"] . "', '" . $x_value["phone"] . "', '" . $x_value["role"] . "'); toggleModal('editUser'); log('action', 'Open edit user ".$x_value["first_name"]." ".$x_value["last_name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-pen\"></i>
                                </button>
                                <button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"deleteUser('" . $x_value["login_id"] . "', '" . $x_value["first_name"] . "', '" . $x_value["last_name"] . "', '" . $x_value["role"] . "'); toggleModal('delUser'); log('action', 'Open delete user ".$x_value["first_name"]." ".$x_value["last_name"]." modal', window.location.href);\">
                                    <i class=\"fas fa-trash\"></i>
                                </button>
                            </td>
                            <td><img src=\"" . $x_value["img"] . "\" alt=\"User Img\" style=\"width: 30px;\"></td>
                            <td>" . $x_value["first_name"] . "</td>
                            <td>" . $x_value["last_name"] . "</td>
                            <td>" . $x_value["other_names"] . "</td>
                            <td>" . $x_value["email"] . "</td>
                            <td>" . $x_value["phone"] . "</td>
                            <td>" . $x_value["role"] . "</td>
                        </tr>";
                }
            }
        ?>
        </tbody>
    </table>
</div>
<!-- End of User Table -->

<?php
$conn->close();
include("includes/footer.php");
?>