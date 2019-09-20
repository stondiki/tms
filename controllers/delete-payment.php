<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["pid"] != ""){
        $sql = "DELETE FROM payments WHERE id = ".$_POST["pid"];
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Payment deleted successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../finance.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error occured during deletion.'
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
}
?>