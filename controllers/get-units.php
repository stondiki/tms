<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_GET["cid"] != ""){
        $sql = "SELECT * FROM units WHERE course_id = ".$_GET["cid"]." AND id NOT IN (SELECT unit_id FROM timetables)";
        $result =$conn->query($sql);
        $units = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $unit = array(
                    'id' => $row["id"],
                    'code' => $row["unit_code"],
                    'name' => $row["unit_name"],
                    'unitYear' => $row["unit_year"],
                    'unitSem' => $row["unit_semester"],
                    'course' => $row["course_id"],
                    'duration' => $row["unit_duration"],
                    'branch' => $row["unit_branch"],
                    'year' => $row["unit_year"],
                    'semester' => $row["unit_semester"],
                    'venue' => $row["preferred_venue"]
                );
                array_push($units, $unit);
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Units are listed below.',
                'data' => $units
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Search criteria not specified.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>