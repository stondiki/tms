<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["uid"] != "" && $_POST["uname"] != "" && $_POST["ucode"] != "" && $_POST["ucid"] != "" && $_POST["ucname"] != "" && $_POST["ubranch"] != "" && $_POST["uyear"] != "" && $_POST["usem"] != "" && $_POST["upvenue"] != ""){
        $un = strtolower($_POST["uname"]);
        $sql = "UPDATE units
        SET unit_name = '".$un."', unit_code = '".$_POST["ucode"]."', unit_branch = '".$_POST["ubranch"]."', unit_year = '".$_POST["uyear"]."', unit_semester = '".$_POST["usem"]."', preferred_venue = '".$_POST["upvenue"]."'
        WHERE id = '".$_POST["uid"]."'";
        if($conn->query($sql) === TRUE){
            $resp = array(
                'status' => 'success',
                'message' => 'Unit updated successfully.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
            header("Location: ../units.php");
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating unit.'
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