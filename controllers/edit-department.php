<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["did"] != "" && $_POST["dname"] != "" && $_POST["fname"] != ""){
        $da = strtolower($_POST["dname"]);
        $sql = "UPDATE departments
        SET department_name = '".$da."', faculty_id = ".$_POST["fname"]."
        WHERE id = ".$_POST["did"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Department updated successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../departments.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating departments.'
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