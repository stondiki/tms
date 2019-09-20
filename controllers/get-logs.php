<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    include("db.php");
    if(!isset($_POST["page"])){
        $start = 0;
    } else {
        $start = ($_POST["page"] - 1) * 20;
    }

    if($_POST["filter"] == "none" || !isset($_POST)){
        $sql = "SELECT system_log.id, user_details.first_name, user_details.last_name, system_log.system_event, system_log.clicked_element, system_log.clicked_page, system_log.ip_address, system_log.action_time
        FROM user_details, system_log
        WHERE user_details.id = system_log.usr_id
        ORDER BY system_log.id
        LIMIT $start, 20";
        $result = $conn->query($sql);
        $logs = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $r = array(
                    'id' => $row["id"],
                    'name' => $row["first_name"]." ".$row["last_name"],
                    'event' => $row["system_event"],
                    'element' => $row["clicked_element"],
                    'page' => $row["clicked_page"],
                    'ip_address' => $row["ip_address"],
                    'time' => $row["action_time"],
                );
                array_push($logs, $r);
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Here are the results.',
                'data' => $logs
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
    } else {
        if($_POST["filter"] == "time"){
            $filter = "";
            $selected = $_POST["selected"];
        } else if($_POST["filter"] == "username"){
            $filter = "user_details.id";
            $selected = $_POST["selected"];
        } else if($_POST["filter"] == "event"){
            $filter = "system_log.system_event";
            $selected = $_POST["selected"];
        } else if($_POST["filter"] == "clicked"){
            $filter = "system_log.clicked_element";
            $selected = $_POST["selected"];
        } else if($_POST["filter"] == "page"){
            $filter = "system_log.clicked_page";
            $selected = $_POST["selected"];
        } else if($_POST["filter"] == "ip"){
            $filter = "system_log.ip_address";
            $selected = $_POST["selected"];
        }

        $sql = "SELECT system_log.id, user_details.first_name, user_details.last_name, system_log.system_event, system_log.clicked_element, system_log.clicked_page, system_log.ip_address, system_log.action_time
        FROM user_details, system_log
        WHERE user_details.id = system_log.usr_id AND ".$filter." = '".$selected."'
        ORDER BY system_log.id
        LIMIT $start, 20";
        $result = $conn->query($sql);
        $logs = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $r = array(
                    'id' => $row["id"],
                    'name' => $row["first_name"]." ".$row["last_name"],
                    'event' => $row["system_event"],
                    'element' => $row["clicked_element"],
                    'page' => $row["clicked_page"],
                    'ip_address' => $row["ip_address"],
                    'time' => $row["action_time"],
                );
                array_push($logs, $r);
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Here are results.',
                'data' => $logs
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
}
?>