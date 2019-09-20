<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_GET["yr"] != ""){
        $sql = "SELECT * FROM semesters WHERE academic_year = ".$_GET["yr"];
        $result = $conn->query($sql);
        $re = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $r = array(
                    'id' => $row["id"],
                    'semester' => $row["semester"],
                    'start' => $row["sem_start"],
                    'end' => $row["sem_end"],
                    'ayear' => $row["academic_year"],
                    'active' => $row["active"],
                    'registration' => $row["registration"]
                );
                array_push($re, $r);
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Here are the results.',
                'data' => $re
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
        $resp = array(
            'status' => 'error',
            'message' => 'Search term not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>