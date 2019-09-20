<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    if($_POST["cname"] != "" && $_POST["cname"] != "--Select--"){
        include("db.php");
        $sql = "SELECT * FROM semesters WHERE active = 'yes'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $sql2 = "DELETE FROM timetables WHERE course_id = ".$_POST["cname"]." AND semester_id = ".$row["id"];
                if($conn->query($sql2) === TRUE) {
                    $resp = array(
                        'status' => 'success',
                        'message' => 'Course timetable cleared successfully.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                    header("Location: ../course-timetable.php");
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error clearing timetable.',
                        'error' => $conn->error
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error retrieving semester info.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Did not receive expected value.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>