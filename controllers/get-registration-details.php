<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $getSem = "SELECT * FROM semesters WHERE active = 'yes' AND registration = 'yes'";
    $getSemRes = $conn->query($getSem);
    $semID = "";
    if($getSemRes->num_rows == 1){
        while($sem = $getSemRes->fetch_assoc()){
            $semID = $sem["id"];
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'Error retrieving semester'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    if($_GET["courseid"] != ""){
        $sql = "SELECT DISTINCT(unit_id) FROM registrations WHERE semester_id = '".$semID."' AND course_id = '".$_GET["courseid"]."'";
        $result = $conn->query($sql);
        $dets = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql2 = "SELECT * FROM units WHERE id = ".$row["unit_id"];
                $result2 = $conn->query($sql2);
                if($result2->num_rows == 1){
                    while($row2 = $result2->fetch_assoc()){
                        $sql3 = "SELECT COUNT(*) AS reg_count FROM registrations WHERE unit_id = ".$row2["id"];
                        $result3 = $conn->query($sql3);
                        if($result3->num_rows == 1){
                            while($row3 = $result3->fetch_assoc()){
                                $r = array(
                                    'unit_id' => $row["unit_id"],
                                    'unit_name' => $row2["unit_name"],
                                    'count' => $row3["reg_count"]
                                );
                                array_push($dets, $r);
                            }
                        }
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'More than one result was returned from units'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
            $resp = array(
                'status' => 'success',
                'message' => 'Registered units are listed below',
                'data' => $dets
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'No parameters to search'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'No course ID specified in get request'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>