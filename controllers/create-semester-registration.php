<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "student"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    include("db.php");
    $sem = "";
    $getSem = "SELECT * FROM semesters WHERE active = 'yes'";
    $getSemRes = $conn->query($getSem);
    if($getSemRes->num_rows == 1){
        while($semRow = $getSemRes->fetch_assoc()){
            $sem = $semRow["id"];
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Error retrieving semester information.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }

    $sql = "SELECT * FROM registrations WHERE student_id = ".$_SESSION["usr_id"]." AND semester_id = ".$sem;
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        $sql = "INSERT INTO registrations (student_id, semester_id)
        VALUES (".$_SESSION["usr_id"].", ".$sem.")";
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Registration successful.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error registering for semester.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Already registered.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>