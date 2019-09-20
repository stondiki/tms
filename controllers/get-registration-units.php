<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "student"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_GET["usr_id"] != ""){
        $sql = "SELECT * FROM students WHERE user_details_id = ".$_GET["usr_id"];
        $result = $conn->query($sql);
        $units = array();
        $year = "";
        $semester = "";
        if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $year = ceil($row["ac_level"]/2);
                $semester = ($row["ac_level"]%3); 
                $sql2 = "SELECT * FROM units WHERE course_id = ".$row["course"]." AND unit_year = ".$year." AND unit_semester = ".$semester;
                $result2 = $conn->query($sql2);
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                            $u = array(
                                'id' => $row2["id"],
                                'name' => $row2["unit_name"],
                                'code' => $row2["unit_code"],
                                'course_id' => $row2["course_id"],
                                'branch' => $row2["unit_branch"],
                                'year' => $row2["unit_year"],
                                'sem' => $row2["unit_semester"],
                                'venue' => $row2["preferred_venue"],
                                'fee' => $row2["fee"]
                            );
                            array_push($units, $u);
                    }
                    $resp = array(
                        'status' => 'success',
                        'message' => 'Here are the units the student has not done',
                        'data' => $units
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'No results'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'More than one result was returned'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    }
    $conn->close();
}
?>