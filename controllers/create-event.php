<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["sem"] != "" && $_POST["estart"] != "" && $_POST["eend"] != "" && $_POST["edescription"] != ""){
        $sql = "INSERT INTO semester_events (semester, event_description, s_date, e_date)
        VALUES ('".$_POST["sem"]."', '".$_POST["edescription"]."', '".$_POST["estart"]."', '".$_POST["eend"]."')";
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Event inserted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../academic-calendar.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error creating event.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'The form has to be filled correctly.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>