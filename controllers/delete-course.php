<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["cid"] != ""){
        $sql = "DELETE FROM courses WHERE id = ".$_POST["cid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Course deleted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../courses.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error deleting course.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Course for deletion not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>