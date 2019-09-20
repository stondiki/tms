<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_GET["sid"] != ""){
        $sql = "SELECT * FROM students WHERE student_id = ".$_GET["sid"];
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $sql2 = "SELECT * FROM user_details WHERE id = ".$row["user_details_id"];
                $result2 = $conn->query($sql2);
                if($result2->num_rows == 1){
                    while($row2 = $result2->fetch_assoc()){
                        $resp = array(
                            'status' => 'success',
                            'message' => 'Student details retrieved successfully.',
                            'name' => $row2["first_name"]." ".$row2["last_name"]
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error retrieving student details.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error retrieving student ID.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'The student ID is not in the correct format.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>