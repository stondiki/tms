<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["uname"] != "" && $_POST["ucode"] != "" && $_POST["ucid"] != "" && $_POST["ubranch"] != "" && $_POST["uyear"] != "" && $_POST["usem"] != ""){
        $un = strtolower($_POST["uname"]);
        $checkunit = "SELECT * FROM units WHERE unit_name = '".$un."'";
        $unitres = $conn->query($checkunit);
        if($unitres->num_rows > 0){
            $resp = array(
                'status' => 'error',
                'message' => 'Unit already exists.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $sql = "INSERT INTO units (unit_name, unit_code, course_id, unit_branch, unit_year, unit_semester)
            VALUES('".$un."', '".$_POST["ucode"]."', '".$_POST["ucid"]."', '".$_POST["ubranch"]."', '".$_POST["uyear"]."', '".$_POST["usem"]."')";
            if($conn->query($sql) === TRUE){
                $resp = array(
                    'status' => 'success',
                    'message' => 'Unit created successfully.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error creating unit.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'The form is not properly filled.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>