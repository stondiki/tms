<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    if($_GET["uid"] != "" && $_GET["cid"] != "" && $_GET["lec"] != "" && $_GET["ven"] != "" && $_GET["tim"] != "" && $_GET["ye"] != "" && $_GET["sem"] != ""){
        include("db.php");
        $sem = "";
        $sql = "SELECT * FROM semesters WHERE active = 'yes'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sem = $row["id"];
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error selecting semester.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }

        $unitYear = "";
        $unitSem = "";

        $sql2 = "SELECT * FROM units WHERE id = ".$_GET["uid"];
        $result2 = $conn->query($sql2);
        if($result2->num_rows == 1){
            while($row2 = $result2->fetch_assoc()){
                $unitYear = $row["unit_year"];
                $unitSem = $row["unit_semester"];
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error querying the unit.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }

        $sql3 = "SELECT * FROM timetables WHERE 
        (unit_id = '".$_GET["uid"]."' AND semester_id = '".$sem."')";
        $result3 = $conn->query($sql3);
        if($result3->num_rows == 0){
            $sql4 = "SELECT * FROM timetables WHERE venue_id = ".$_GET["ven"]." AND timeslot_id = ".$_GET["tim"]." AND semester_id = ".$sem;
            $result4 = $conn->query($sql4);
            if($result4->num_rows == 0){
                $sql5 = "SELECT * FROM timetables WHERE 
                unit_year = ".$_GET["ye"]." AND unit_semester = ".$_GET["sem"]." AND timeslot_id = ".$_GET["tim"]." AND semester_id = ".$sem." AND course_id = ".$_GET["cid"];
                $result5 = $conn->query($sql5);
                if($result5->num_rows == 0){
                    $sql6 = "SELECT * FROM timetables WHERE (lecturer_id = '".$_GET["lec"]."' AND timeslot_id = '".$_GET["tim"]."' AND semester_id = '".$sem."') OR ((SELECT COUNT(*) FROM timetables WHERE lecturer_id = '".$_GET["lec"]."') >= 6)";
                    $result6 = $conn->query($sql6);
                    if($result6->num_rows == 0){
                         $resp = array(
                            'status' => 'success',
                            'message' => 'Slot is available.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    } else {
                        $resp = array(
                            'status' => 'error',
                            'message' => 'Slot is unavailable.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Slot is unavailable.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Slot is unavailable.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Unit already registered.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }


        $conn->close();
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'One of the required parameters is missing.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}

// Check that the unit has not been assigned
// Check that the venue assigned to the unit is not occupied during the given timeslot
// Check that there are no units of the same year and semester at the same timeslot
// Check that the assigned lecturer is free during that time
// If all the above checkout, assgn the unit to the timetable
?>