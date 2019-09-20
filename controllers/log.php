<?php
session_start();

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ipAddr = getUserIpAddr();
$_POST = json_decode(file_get_contents('php://input'), true);

include("db.php");
if(isset($_SESSION)){
    $sql = "INSERT INTO system_log (usr_id, system_event, clicked_element, clicked_page, ip_address)
    VALUES('".$_SESSION["usr_id"]."', '".$_POST["event"]."', '".$_POST["element"]."', '".$_POST["page"]."', '".$ipAddr."')";
    if($conn->query($sql) === TRUE){
        $resp = array(
            'status' => 'success',
            'message' => 'Log inserted successfully'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Error inserting log entry.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
} else {
    $sql = "INSERT INTO system_log (usr_id, system_event, clicked_element, clicked_page, ip_address)
    VALUES('0', '".$_POST["event"]."', '".$_POST["element"]."', '".$_POST["page"]."', '".$ipAddr."')";
    if($conn->query($sql) === TRUE){
        $resp = array(
            'status' => 'success',
            'message' => 'Log inserted successfully'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Error inserting log entry.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>