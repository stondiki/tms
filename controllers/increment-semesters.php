<?php
session_start();
if(isset($_SESSION["uid"]) && $_SESSION["role"] == "staff"){
    include("db.php");
    $sql = "UPDATE students SET ac_level = ac_level + 1";
    if($conn->query($sql) === TRUE){
        $resp = array(
            'status' => 'success',
            'message' => 'Student semesters updated successfully.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Error updating student semesters.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
} else {
    $resp = array(
        'status' => 'error',
        'message' => 'You do not have the correct credentials to do this.'
    );
    header('Content-Type: application/json');
    echo json_encode($resp);
}
?>