<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if(isset($_POST["tid"])){
        include("db.php");
        $sql = "DELETE FROM timetables WHERE id = ".$_POST["tid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Timetable entry deleted successfully'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error deleting timetable entry'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'No parameters were received'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>