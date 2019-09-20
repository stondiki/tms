<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["fid"] != ""){
        $sql = "DELETE FROM faculties WHERE id = ". $_POST["fid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Faculty deleted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../faculties.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error deleting faculty.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Faculty for deletion not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>