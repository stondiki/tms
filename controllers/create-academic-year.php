<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    include("db.php");
    if($_POST["ayear"] != "" && $_POST["sepdecstart"] != "" && $_POST["sepdecend"] != "" && $_POST["janaprstart"] != "" && $_POST["janaprend"] != "" && $_POST["mayaugstart"] != "" && $_POST["mayaugend"] != ""){
        
        $year = explode("-",$_POST["ayear"]);
            $septDecStart = explode("-",$_POST["sepdecstart"]);
            $septDecEnd = explode("-",$_POST["sepdecend"]);
            $janAprStart = explode("-",$_POST["janaprstart"]);
            $janAprEnd = explode("-",$_POST["janaprend"]);
            $mayAugStart = explode("-",$_POST["mayaugstart"]);
            $mayAugEnd = explode("-",$_POST["mayaugend"]);
            if($septDecStart[0] == $year[0] && $septDecEnd[0] == $year[0] && $janAprStart[0] == $year[1] && $janAprEnd[0] == $year[1] && $mayAugStart[0] == $year[1] && $mayAugEnd[0] == $year[1]){
                $checkYear = "SELECT * FROM academic_years WHERE year_span = '".$_POST["ayear"]."'";
                $checkYearResults = $conn->query($checkYear);
                if($checkYearResults->num_rows == 0){
                    $sql = "INSERT INTO academic_years (year_span) VALUES('".$_POST["ayear"]."')";
                    if($conn->query($sql) === TRUE){
                        $sql2 = "SELECT * FROM academic_years WHERE year_span = '".$_POST["ayear"]."'";
                        $result2 = $conn->query($sql2);
                        if($result2->num_rows == 1){
                            while($row2 = $result2->fetch_assoc()){
                                $sql3 = "INSERT INTO semesters (semester, sem_start, sem_end, academic_year)
                                VALUES('September-December', '".$_POST["sepdecstart"]."', '".$_POST["sepdecend"]."', '".$row2["id"]."'),
                                ('January-April', '".$_POST["janaprstart"]."', '".$_POST["janaprend"]."', '".$row2["id"]."'),
                                ('May-August', '".$_POST["mayaugstart"]."', '".$_POST["mayaugend"]."', '".$row2["id"]."')";
                                if($conn->query($sql3) === TRUE){
                                    $resp = array(
                                        'status' => 'success',
                                        'message' => 'Academic year created successfully.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                    header("Location: ../academic-calendar.php");
                                } else {
                                    $resp = array(
                                        'status' => 'error',
                                        'message' => 'Error creating semesters.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                }
                            }
                        } else {
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Error retrieving academic year.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    } else {
                        $resp = array(
                            'status' => 'error',
                            'message' => 'Error inserting academic year.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Academic year already exixts.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'One or more of the semester dates is invalid (Does not fall within academic year).'
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