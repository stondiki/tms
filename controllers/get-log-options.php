<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["filter"] != ""){
        if($_POST["filter"] == "username"){
            $sql = "SELECT id, first_name, last_name FROM user_details WHERE id IN (SELECT usr_id FROM system_log)";
            $res = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $r = array(
                       'id' => $row["id"],
                       'name' => $row["first_name"]." ".$row["last_name"] 
                    );
                    array_push($res, $r);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $res
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if ($_POST["filter"] == "event") {
            $sql = "SELECT DISTINCT(system_event) FROM system_log";
            $res = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $r = array(
                        'r' => $row["system_event"]
                    );
                    array_push($res, $r);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $res
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else if ($_POST["filter"] == "clicked") {
            $sql = "SELECT DISTINCT(clicked_element) FROM system_log";
            $res = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $r = array(
                        'r' => $row["clicked_element"]
                    );
                    array_push($res, $r);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $res
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }  else if ($_POST["filter"] == "ip") {
            $sql = "SELECT DISTINCT(ip_address) FROM system_log";
            $res = array();
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $r = array(
                        'r' => $row["ip_address"]
                    );
                    array_push($res, $r);
                }
                $resp = array(
                    'status' => 'success',
                    'message' => 'Here are the results.',
                    'data' => $res
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'No results.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Expected input not received.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>