<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["sem"] != "" && $_POST["act"] != "" && $_POST["reg"] != ""){
        $sql = "SELECT * FROM semesters";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql2 = "UPDATE semesters
                SET active = 'no', registration = 'no'
                WHERE id = '".$row["id"]."'";
                if($conn->query($sql2) === TRUE){
                    $resp = array(
                        'status' => 'success',
                        'message' => 'Semester set to no successfully.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error setting '.$row["semester"].' to no.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error selecting semesters.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }

        $sql3 = "UPDATE semesters
        SET active = '".$_POST["act"]."', registration = '".$_POST["reg"]."'
        WHERE id = '".$_POST["sem"]."'";
        if($conn->query($sql3) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Semester update successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../semester-setup.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating semester.'
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