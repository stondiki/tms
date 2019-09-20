<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if(isset($_POST["filter"])){
        if($_POST["filter"] == "lecturer"){
            $sql = "SELECT * FROM user_details WHERE id IN (SELECT DISTINCT(lecturer_id) FROM timetables)";
            $lecs = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $l = array(
                        'id' => $row["id"],
                        'fname' => $row["first_name"],
                        'lname' => $row["last_name"],
                    );
                    array_push($lecs, $l);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Results found.',
                    'data' => $lecs
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results from lecturers.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if($_POST["filter"] == "venue"){
            $sql = "SELECT * FROM venues WHERE id IN (SELECT DISTINCT(venue_id) FROM timetables)";
            $vens = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $v = array(
                        'id' => $row["id"],
                        'name' => $row["venue_name"]
                    );
                    array_push($vens, $v);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Results found.',
                    'data' => $vens
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results from venues.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if($_POST["filter"] == "course"){
            $sql = "SELECT * FROM courses WHERE id IN (SELECT DISTINCT(course_id) FROM timetables)";
            $courses = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $c = array(
                        'id' => $row["id"],
                        'name' => $row["course_name"]
                    );
                    array_push($courses, $c);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Results found.',
                    'data' => $courses
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results from courses.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error in filter parameters.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Expected values not received.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>