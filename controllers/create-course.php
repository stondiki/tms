<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    include("db.php");
    if($_POST["cname"] != "" && $_POST["cdid"] != ""){
        $co = strtolower($_POST["cname"]);
        $checkco = "SELECT * FROM courses WHERE course_name = '".$co."'";
        $cores = $conn->query($checkco);
        if($cores->num_rows > 0){
            $resp = array(
                'status' => 'error',
                'message' => 'Course already exists.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $sql = "INSERT INTO courses (course_name, department_id)
            VALUES('".$co."', '".$_POST["cdid"]."')";
            if($conn->query($sql) === TRUE){
                $resp = array(
                    'status' => 'success',
                    'message' => 'Course created successfully.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
                //header("Location: ../courses.php");
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error creating course.'
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
    $conn->close();
}
?>