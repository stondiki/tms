<?php
    session_start();
    if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
        header("Location: ../index.php");
    } else {
        if($_GET["uid"] != "" && $_GET["cid"] != "" && $_GET["lec"] != "" && $_GET["ven"] != "" && $_GET["tim"] != ""){
            include("db.php");
            $getSem = "SELECT * FROM semesters WHERE active= 'yes'";
            $getSemResult = $conn->query($getSem);
            $sem = "";
            if($getSemResult->num_rows == 1){
                while($se = $getSemResult->fetch_assoc()){
                    $sem = $se["id"];
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error retrieving semester.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }

            $found = 0;
            $sql = "SELECT * FROM timetables WHERE unit_id = ".$_GET["uid"]." AND semester_id = ".$sem;
            $result = $conn->query($sql);
            if($result->num_rows == 0){
                $sql2 = "SELECT * FROM timetables WHERE (venue_id = '".$_GET["ven"]."' AND timeslot_id = '".$_GET["tim"]."' AND semester_id = '".$sem."') OR (lecturer_id = '".$_GET["lec"]."' AND timeslot_id = '".$_GET["tim"]."' AND semester_id = '".$sem."')";
                $result2 = $conn->query($sql2);
                if($result2->num_rows == 0){
                    $sql3 = "SELECT * FROM timetables WHERE unit_id != '".$_GET["uid"]."' AND timeslot_id = ".$_GET["tim"];
                    $result3 = $conn->query($sql3);
                    if($result3->num_rows > 0){
                        while($row3 = $result3->fetch_assoc()){
                            $sql4 = "SELECT DISTINCT student_id FROM registrations";
                            $result4 = $conn->query($sql4);
                            if($result4->num_rows > 0){
                                while($row4 = $result4->fetch_assoc()){
                                    $sql5 = "SELECT * FROM registrations WHERE student_id = '".$row4["student_id"]."' AND (unit_id = '".$_GET["uid"]."' OR unit_id = '".$row3["unit_id"]."'";
                                    $result5 = $conn->query($sql5);
                                    if($sql5->num_rows > 0){
                                        $found += 1;
                                    } else {
                                        $found += 0;
                                    }
                                }
                            } else {
                                $found += 0;
                            }
                        }
                    } else{
                        $found += 0;
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Venue, Timeslot or Lecturer is not available.',
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'The unit has already been assigned.',
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }


            if($found == 0){
                 $resp = array(
                    'status' => 'success',
                    'message' => 'The slot is available.',
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Student conflict found.',
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
        $conn->close();
    }
?>