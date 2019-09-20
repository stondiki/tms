<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["did"] != ""){
        $sql = "DELETE FROM departments WHERE id = ".$_POST["did"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Department deleted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../departments.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error deleting department.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Department for deletion not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>