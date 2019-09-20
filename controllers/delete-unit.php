<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["uid"] != ""){
        $sql = "DELETE FROM units WHERE id = ".$_POST["uid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Unit deleted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../units.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error deleting unit.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Course for deletion not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>