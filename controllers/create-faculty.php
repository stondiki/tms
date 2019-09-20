<?php
session_start();

if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    include("db.php");
    if(isset($_POST["fname"])){
        $fa = strtolower($_POST["fname"]);
        $check = "SELECT * FROM faculties WHERE faculty_name = '".$fa."'";
        $checkres = $conn->query($check);
        if($checkres->num_rows > 0){
            $resp = array(
                'status' => 'error',
                'message' => 'Faculty already exists.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $sql = "INSERT INTO faculties (faculty_name) VALUES('".$fa."')";
            if($conn->query($sql) === TRUE){
                $resp = array(
                    'status' => 'success',
                    'message' => 'Faculty created successfully.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error creating faculty.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'You need to fill the form.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>