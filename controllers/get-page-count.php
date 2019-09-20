<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["filter"] == "username"){
        $sql = "SELECT COUNT(*) AS c FROM system_log WHERE usr_id = ".$_POST["criteria"];
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $count = $row["c"];
            }
        }
        $resp = array(
            'status' => 'success',
            'message' => 'Here are the results.',
            'data' => $count
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    } else if ($_POST["filter"] == "event"){
        $sql = "SELECT COUNT(*) AS c FROM system_log WHERE system_event = '".$_POST["criteria"]."'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $count = $row["c"];
            }
        }
        $resp = array(
            'status' => 'success',
            'message' => 'Here are the results.',
            'data' => $count
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    } else if ($_POST["filter"] == "ip"){
        $sql = "SELECT COUNT(*) AS c FROM system_log WHERE ip_address = '".$_POST["criteria"]."'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $count = $row["c"];
            }
        }
        $resp = array(
            'status' => 'success',
            'message' => 'Here are the results.',
            'data' => $count
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>