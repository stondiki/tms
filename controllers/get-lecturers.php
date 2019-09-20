<?php
session_start();
if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $sql = "SELECT * FROM logins WHERE user_role = 'lecturer'";
    $result = $conn->query($sql);
    $lecturers = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $sql2 = "SELECT * FROM user_details WHERE login_id = ".$row["id"];
            $result2 = $conn->query($sql2);
            if($result2->num_rows == 1){
                while($row2 = $result2->fetch_assoc()){
                    $lecturer = array(
                        'id' => $row2["id"],
                        'fname' => $row2["first_name"],
                        'lname' => $row2["last_name"]
                    );
                    array_push($lecturers, $lecturer);
                }
            }
        }
        $resp = array(
            'status' => 'success',
            'message' => 'Lecturers retrieved successfully.',
            'data' => $lecturers
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
}
?>