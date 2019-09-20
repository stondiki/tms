<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if(isset($_POST["fid"])  && isset($_POST["fname"])){
        $fa = strtolower($_POST["fname"]);
        $sql = "UPDATE faculties
        SET faculty_name = '".$fa."'
        WHERE id = ".$_POST["fid"];

        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Faculty updated successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../faculties.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating faculty.'
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