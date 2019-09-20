<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
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

    if($_GET["uid"] != "" && $_GET["cid"] != "" && $_GET["lec"] != "" && $_GET["ven"] != "" && $_GET["tim"] != "" && $_GET["year"] != "" && $_GET["sem"] != ""){
        $in = array(
            'unit' => $_GET["uid"],
            'course' => $_GET["cid"],
            'lecturer' => $_GET["lec"],
            'venue' => $_GET["ven"],
            'time' => $_GET["tim"],
            'year' => $_GET["year"],
            'semester' => $_GET["sem"]

        );
        $sql = "INSERT INTO timetables (course_id, unit_id, semester_id, venue_id, timeslot_id, lecturer_id, unit_year, unit_semester)
        VALUES(".$_GET["cid"].", ".$_GET["uid"].", ".$sem.", ".$_GET["ven"].", ".$_GET["tim"].", ".$_GET["lec"].", ".$_GET["year"].", ".$_GET["sem"].")";
        if($conn->query($sql) == TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Timetable entry made successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => $conn->error,
                'inputs' => $in
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'One or more of the required parameters is missing.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>