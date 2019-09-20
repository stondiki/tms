<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["cid"] != "" && $_POST["cname"] != "" && $_POST["dname"] != ""){
        $co = strtolower($_POST["cname"]);
        $sql = "UPDATE courses
        SET course_name = '".$co."', department_id = ".$_POST["dname"]."
        WHERE id = ".$_POST["cid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Course updated successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../courses.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating course.'
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