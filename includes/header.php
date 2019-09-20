<?php
    $anon = array(
        'nav' => array(
           'Home' => 'index.php',
           'Academic Calendar' => 'academic-calendar.php',
           'FAQs' => 'faqs.php'
        )
    );
    $student = array(
        'nav' => array(
            'Home' => 'index.php',
            'Academic Calendar' => 'academic-calendar.php',
            'Timetable' => 'class-timetable.php',
            'Registration' => 'registration.php',
            'FAQs' => 'faqs.php'
        )
    );
    $lecturer = array(
        'nav' => array(
            'Home' => 'index.php',
            'Academic Calendar' => 'academic-calendar.php',
            'Timetable' => 'class-timetable.php',
            'FAQs' => 'faqs.php'
        )
    );
    $staff = array(
        'nav' => array(
            'Home' => 'index.php',
            'Faculties' => 'faculties.php',
            'Departments' => 'departments.php',
            'Courses' => 'courses.php',
            'Units' => 'units.php',
            'Academic Calendar' => 'academic-calendar.php',
            'Semester Setup' => 'semester-setup.php',
            'Timetable' => 'course-timetable.php',
            'Users' => 'users.php',
            'Reports <i class="fas fa-caret-down"></i>' => array(
                'Venues' => 'venue-reports.php',
                'Lecturers' => 'lecturer-reports.php',
                'Students' => 'student-reports.php'
            ),
            'FAQs' => 'faqs.php',
            'System Logs' => 'logs.php'
        )
    );

    if(isset($_SESSION["uid"])){
        if ($_SESSION["role"] == "student"){
            $usr = "<img src=\"".$_SESSION["usr_img"]."\" alt=\"'User Image'\" style=\"width: 100px; height: 100px; border: solid #ffc107 5px; border-radius: 50%;\"><h2>".$_SESSION["fname"]." <b>".$_SESSION["lname"]. "</b></h2><h6 onclick =\"toggleModal('changePwd'); log('action', 'Change password', window.location.href)\"><a href=\"#\"><i class=\"fas fa-key text-light\"></i> Change password</a></h6><a href=\"controllers/logout.php\" onclick=\"log('logout', 'logout', window.location.href)\"><i class=\"fas fa-sign-out-alt text-light\"></i> <b>Logout</b></a>";
            $nav = "";
            foreach($student['nav'] as $x => $x_value){
                if(is_array($x_value)){
                    $b = "<div class=\"dropdown-menu\">";
                    foreach($x_value as $y => $y_value){
                        $b = $b."<a class=\"dropdown-item\" href=\"".$y_value."\" onclick=\"log('navigation', '".$y."', window.location.href)\">".$y."</a>";
                    }
                    $b = $b."</div>";
                    $a = "<li class=\"nav-item\">
                    <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\" href=\"#\">".$x."</a>".$b."
                    </li>";
                    $nav = $nav.$a;
                } else {
                    $a = "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"".$x_value."\" onclick=\"log('navigation', '".$x."', window.location.href)\">".$x."</a>
                    </li>";
                    $nav = $nav.$a;
                }
            }
        } else if ($_SESSION["role"] == "lecturer"){
            $usr = "<img src=\"".$_SESSION["usr_img"]."\" alt=\"'User Image'\" style=\"width: 100px; height: 100px; border: solid #dc3545 5px; border-radius: 50%;\"><h2>".$_SESSION["fname"]." <b>".$_SESSION["lname"]. "</b></h2><h6 data-toggle=\"modal\" onclick =\"toggleModal('changePwd'); log('action', 'Change password', window.location.href)\"><a href=\"#\"><i class=\"fas fa-key text-light\"></i> Change password</a></h6><a href=\"controllers/logout.php\" onclick=\"log('logout', 'logout', window.location.href)\"><i class=\"fas fa-sign-out-alt text-light\"></i> <b>Logout</b></a>";
            $nav = "";
            foreach($lecturer['nav'] as $x => $x_value){
                if(is_array($x_value)){
                    $b = "<div class=\"dropdown-menu\">";
                    foreach($x_value as $y => $y_value){
                        $b = $b."<a class=\"dropdown-item\" href=\"".$y_value."\" onclick=\"log('navigation', '".$y."', window.location.href)\">".$y."</a>";
                    }
                    $b = $b."</div>";
                    $a = "<li class=\"nav-item\">
                    <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\" href=\"#\">".$x."</a>".$b."
                    </li>";
                    $nav = $nav.$a;
                } else {
                    $a = "<li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"".$x_value."\" onclick=\"log('navigation', '".$x."', window.location.href)\">".$x."</a>
                    </li>";
                    $nav = $nav.$a;
                }
            }
        } else if ($_SESSION["role"] == "staff"){
            $usr = "<img src=\"".$_SESSION["usr_img"]."\" alt=\"'User Image'\" style=\"width: 100px; height: 100px; border: solid #007bff 5px; border-radius: 50%;\"><h2>".$_SESSION["fname"]." <b>".$_SESSION["lname"]. "</b></h2><h6 data-toggle=\"modal\" onclick =\"toggleModal('changePwd'); log('action', 'Change password', window.location.href)\"><a href=\"#\"><i class=\"fas fa-key text-light\"></i> Change password</a></h6><a href=\"controllers/logout.php\" onclick=\"log('logout', 'logout', window.location.href)\"><i class=\"fas fa-sign-out-alt text-light\"></i> <b>Logout</b></a>";
            $nav = "";
            foreach($staff['nav'] as $x => $x_value){
                if(is_array($x_value)){
                    $b = "<div id=\"collapse\" class=\"hide\" style=\"padding: 5px;\"><ul>";
                    foreach($x_value as $y => $y_value){
                        $b = $b."<li><a href=\"".$y_value."\" onclick=\"log('navigation', '".$y."', window.location.href)\">".$y."</a></li>";
                    }
                    $b = $b."</ul></div>";
                    $a = "<li>
                    <a href=\"#\" onclick=\"showNav('collapse')\">".$x."</a>".$b."
                    </li>";
                    $nav = $nav.$a;
                } else {
                    $a = "<li>
                    <a class=\"nav-link\" href=\"".$x_value."\" onclick=\"log('navigation', '".$x."', window.location.href)\">".$x."</a>
                    </li>";
                    $nav = $nav.$a;
                }
            }
        }

        include("./controllers/db.php");
        if(isset($_SESSION["uid"])){
            $cpwd = "";
            $sql = "SELECT * FROM logins, user_details WHERE user_details.id = ".$_SESSION["usr_id"]." AND user_details.login_id = logins.id";
            $result = $conn->query($sql);
            if($result->num_rows == 1){
                while($row = $result->fetch_assoc()){
                    $cpwd = $row["first_password"];
                }
            }
        }
    } else {
        $nav = "";
        foreach($anon['nav'] as $x => $x_value){
            $a = "<li class=\"nav-item\">
            <a class=\"nav-link\" href=\"".$x_value."\" onclick=\"log('navigation', '".$x."', window.location.href)\">".$x."</a>
            </li>";
            $nav = $nav.$a;
        }
        $usr = "<a href=\"login.php\" onclick=\"log('navigation', 'login', window.location.href)\"><b>Login</b></a>";
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/fontawesome-free-5.10.1-web/css/all.css">
    <link rel="stylesheet" href="css/main.css">
    
    <script src="js/Chart.bundle.js"></script>
    <script src="js/main.js"></script>

    <title>Timetable Management System</title>
</head>
<body>
    <div class="wrapper">
        <div id="side-bar" class="shadow mb-5 bg-light rounded active">
            <div id="cls">
                <button class="btn btn-outline-primary" onclick="toggleSideBar()"><i class="fas fa-arrow-left"></i></button>
            </div>
            <div id="logo">
                <a href="index.php"><img src="images/tms-logo.png" alt="TMS logo"></a>
            </div>
            <div id="user-info" class="bg-dark text-light">
                <?php
                    echo $usr;
                ?>
            </div>
            <div id="nav">
                <ul class="nav flex-column nav-pills">
                    <?php echo $nav; ?>
                </ul>
            </div>
        </div>
        <div id="container" class="container-fluid">
    <div id="cont-head" class="shadow-none p-3 mb-5 bg-light rounded">
        <div id="bars">
            <button id="side-trigger" class="btn btn-outline-primary" onclick="toggleSideBar()"><i class="fas fa-bars"></i></button>
        </div>
        <div id="ttl"><h2 id="page-title">Timetable Management System</h2></div>
    </div>
    <div id="notify" class="hide">
        <strong>Alert!</strong> Check below.
    </div>

    
    <!-- Start of Change Password Modal -->
    <div class="modal-bg" id="changePwd">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title"><h2>Change password</h2></div>
                <div class="modal-close"><button class="btn btn-outline-secondary" onclick="toggleModal('changePwd')"><i class="fas fa-times"></i></button></div>
            </div><hr>
            <div class="modal-body">
                <form action="controllers/change-password.php" method="POST" class="mx-auto p-3">
                    <div class="form-group">
                        <div class="row">
                            <label for="cpwd">Enter current password</label>
                            <input type="password" class="form-control" id="cpwd" name="cpwd" placeholder="Enter current password" required>
                        </div>
                        <div class="row">
                            <label for="pwd">Enter new password</label>
                            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter new password" required>
                        </div>
                        <div class="row">
                            <label for="pwd2">Confirm new password</label>
                            <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Confirm new password" required>
                        </div>
                        <br>
                        <button type="button" class="btn btn-block btn-secondary" onclick="toggleModal('changePwd')">Close</button>
                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- End of Change Password Modal -->

<script>
    let passCheck = (<?php echo json_encode($cpwd); ?>);
    if(passCheck == "yes"){
        toggleModal('changePwd');
    }
</script>
    
