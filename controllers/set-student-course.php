<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["suid"] != "" && $_POST["scourse"] != ""){
        $sql = "UPDATE students
        SET course = '".$_POST["scourse"]."'
        WHERE user_details_id = '".$_POST["suid"]."'";
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Student course updated successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../index.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error occured while updating student course.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'The form is not properly filled.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>