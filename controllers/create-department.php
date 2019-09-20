<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["dname"] !="" && $_POST["fname"] != ""){
        $da = strtolower($_POST["dname"]);
        $checkdep = "SELECT * FROM  departments WHERE department_name = '".$da."'";
        $depres = $conn->query($checkdep);
        if($depres->num_rows > 0){
            $resp = array(
                'status' => 'error',
                'message' => 'Department already exists.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $sql = "INSERT INTO departments (department_name, faculty_id)
            VALUES('".$da."', '".$_POST["fname"]."')";
            if($conn->query($sql) === TRUE){
                $resp = array(
                    'status' => 'success',
                    'message' => 'Department created successfully.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error creating department.'
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