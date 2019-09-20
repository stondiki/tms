<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $sem = "";
    $sql4 = "SELECT * FROM semesters WHERE active = 'yes'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows == 1){
        while($row4 = $result4->fetch_assoc()){
            $sem = $row4["id"];
        }
    }


    $_POST = json_decode(file_get_contents('php://input'), true);
    if(isset($_POST["filter"]) && isset($_POST["criteria"])){
        if($_POST["filter"] == "lecturer" && is_numeric($_POST["criteria"])){
            $tts = array();
            $sql = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
            FROM timetables, units, venues, timeslots, user_details, courses
            WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id AND timetables.lecturer_id = ".$_POST["criteria"];
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $t = array(
                        'id' => $row["id"],
                        'code' => $row["unit_code"],
                        'unit' => $row["unit_name"],
                        'venue' => $row["venue_name"],
                        'day' => $row["slot_day"],
                        'start' => $row["slot_start_time"],
                        'end' => $row["slot_end_time"],
                        'duration' => $row["slot_duration"],
                        'lecturer' => $row["first_name"]." ".$row["last_name"]
                    );
                    array_push($tts, $t);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $tts
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results for lecturer.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if ($_POST["filter"] == "venue" && is_numeric($_POST["criteria"])){
            $tts = array();
            $sql = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
            FROM timetables, units, venues, timeslots, user_details, courses
            WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id AND timetables.venue_id = ".$_POST["criteria"];
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $t = array(
                        'id' => $row["id"],
                        'code' => $row["unit_code"],
                        'unit' => $row["unit_name"],
                        'venue' => $row["venue_name"],
                        'day' => $row["slot_day"],
                        'start' => $row["slot_start_time"],
                        'end' => $row["slot_end_time"],
                        'duration' => $row["slot_duration"],
                        'lecturer' => $row["first_name"]." ".$row["last_name"]
                    );
                    array_push($tts, $t);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $tts
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results for venue.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if($_POST["filter"] == "course" && is_numeric($_POST["criteria"])){
            $tts = array();
            $sql = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
            FROM timetables, units, venues, timeslots, user_details, courses
            WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id AND timetables.course_id = ".$_POST["criteria"];
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $t = array(
                        'id' => $row["id"],
                        'code' => $row["unit_code"],
                        'unit' => $row["unit_name"],
                        'venue' => $row["venue_name"],
                        'day' => $row["slot_day"],
                        'start' => $row["slot_start_time"],
                        'end' => $row["slot_end_time"],
                        'duration' => $row["slot_duration"],
                        'lecturer' => $row["first_name"]." ".$row["last_name"]
                    );
                    array_push($tts, $t);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $tts
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results for course.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else {
            $tts = array();
            $sql = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
            FROM timetables, units, venues, timeslots, user_details, courses
            WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $t = array(
                        'id' => $row["id"],
                        'code' => $row["unit_code"],
                        'unit' => $row["unit_name"],
                        'venue' => $row["venue_name"],
                        'day' => $row["slot_day"],
                        'start' => $row["slot_start_time"],
                        'end' => $row["slot_end_time"],
                        'duration' => $row["slot_duration"],
                        'lecturer' => $row["first_name"]." ".$row["last_name"]
                    );
                    array_push($tts, $t);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $tts
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results for venue.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $tts = array();
        $sql = "SELECT timetables.id, units.unit_name, units.unit_code, venues.venue_name, timeslots.slot_day, timeslots.slot_start_time, timeslots.slot_end_time, timeslots.slot_duration, user_details.first_name, user_details.last_name, courses.course_name
        FROM timetables, units, venues, timeslots, user_details, courses
        WHERE timetables.semester_id = '".$sem."' AND units.id = timetables.unit_id AND venues.id = timetables.venue_id AND timeslots.id = timetables.timeslot_id AND user_details.id = lecturer_id AND courses.id = timetables.course_id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $t = array(
                    'id' => $row["id"],
                    'code' => $row["unit_code"],
                    'unit' => $row["unit_name"],
                    'venue' => $row["venue_name"],
                    'day' => $row["slot_day"],
                    'start' => $row["slot_start_time"],
                    'end' => $row["slot_end_time"],
                    'duration' => $row["slot_duration"],
                    'lecturer' => $row["first_name"]." ".$row["last_name"]
                );
                array_push($tts, $t);
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Here are the results.',
                'data' => $tts
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'No results for venue.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    }
}
?>