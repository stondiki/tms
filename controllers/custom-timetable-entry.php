<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["cname"] != "" && $_POST["unit"] != "" && $_POST["venue"] != "" && $_POST["time"] != "" && $_POST["lecturer"] != ""){
        include("db.php");
        $sql = "SELECT * FROM semesters WHERE active = 'yes'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $sql2 = "SELECT * FROM timetables WHERE unit_id = ".$_POST["unit"]." AND semester_id = ".$row["id"];
                $result2 = $conn->query($sql2);
                if($result2->num_rows == 0){
                    $sql3 = "SELECT * FROM timetables WHERE venue_id = ".$_POST["venue"]." AND timeslot_id = ".$_POST["time"];
                    $result3 = $conn->query($sql3);
                    if($result3->num_rows == 0){
                        $sql4 = "SELECT * FROM timetables WHERE (lecturer_id = '".$_POST["lecturer"]."' AND timeslot_id = '".$_POST["time"]."') OR ((SELECT COUNT(*) FROM timetables WHERE lecturer_id = '".$_POST["lecturer"]."') >= 6)";
                        $result4 = $conn->query($sql4);
                        if($result4->num_rows == 0){
                            $sql5 = "SELECT * FROM units WHERE id = ".$_POST["unit"];
                            $result5 = $conn->query($sql5);
                            if($result5->num_rows == 1){
                                while($row5 = $result5->fetch_assoc()){
                                    $sql6 = "INSERT INTO timetables (course_id, unit_id, unit_year, unit_semester, semester_id, venue_id, timeslot_id, lecturer_id)
                                    VALUES(".$_POST["cname"].", ".$_POST["unit"].", ".$row5["unit_year"].", ".$row5["unit_semester"].", ".$row["id"].", ".$_POST["venue"].", ".$_POST["time"].", ".$_POST["lecturer"].")";
                                    if($conn->query($sql6) === TRUE){
                                        $resp = array(
                                            'status' => 'success',
                                            'message' => 'Unit inserted into timetable successfully.'
                                        );
                                        header('Content-Type: application/json');
                                        echo json_encode($resp);
                                        //header("Location: ../course-timetable.php");
                                    } else {
                                        $resp = array(
                                            'status' => 'error',
                                            'message' => 'Error inserting unit to timetable.'.$conn->error
                                        );
                                        header('Content-Type: application/json');
                                        echo json_encode($resp);
                                    }
                                }
                            } else {
                                $resp = array(
                                    'status' => 'error',
                                    'message' => 'Error querying unit details.'
                                );
                                header('Content-Type: application/json');
                                echo json_encode($resp);
                            }
                        } else {
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Lecturer is occupied during specified timeslot or has 6 or more units already.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    } else {
                        $resp = array(
                            'status' => 'error',
                            'message' => 'The venue is occupied during specified timeslot.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                } else{
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Unit already in timetable.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp); 
                }
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error retrieving semester information.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'One of the required parameters is missing.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>