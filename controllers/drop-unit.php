<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "student"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["usr_id"] != "" && $_POST["uid"] != "" && $_POST["sem"] != ""){
        include("db.php");
        $sql = "DELETE FROM registrations WHERE student_id = ".$_POST["usr_id"]." AND unit_id = ".$_POST["uid"]." AND semester_id = ".$_POST["sem"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Unit dropped successfully.'
            );
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error dropping unit.'
            );
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Required input is missing.'
        );
        echo json_encode($resp);
    }
}
?>