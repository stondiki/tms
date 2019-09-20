<?php
session_start();

if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");

    if($_POST["uid"] != $_SESSION["uid"]){
        if($_POST["uid"] != ""){
            $uid = $_POST["uid"];
            if($_POST["role"] == "student"){
                $uid = $_POST["uid"];
                $sql = "SELECT id FROM user_details WHERE login_id = $uid";
                $result = $conn->query($sql);
                if($result->num_rows == 1){
                    while($row = $result->fetch_assoc()){
                        $sql2 = "DELETE FROM students WHERE user_details_id = ".$row["id"];
                        if($conn->query($sql2) === TRUE){
                            $sql3 = "DELETE FROM user_details WHERE login_id = $uid";
                            if($conn->query($sql3) === TRUE){
                                $sql4 = "DELETE FROM logins WHERE id = $uid";
                                if($conn->query($sql4) === TRUE){
                                    $resp = array(
                                        'status' => 'success',
                                        'message' => 'Student data deleted.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                    header("Location: ../users.php");
                                } else {
                                    $resp = array(
                                        'status' => 'error',
                                        'message' => 'Error deleting user login.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                }
                            } else {
                                $resp = array(
                                    'status' => 'error',
                                    'message' => 'Error deleting user details.'
                                );
                                header('Content-Type: application/json');
                                echo json_encode($resp);
                            }
                        } else {
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Error deleting student admission number.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error retrieving user details.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            } else {
                $sql = "DELETE FROM user_details WHERE login_id = $uid";
                if($conn->query($sql) === TRUE){
                    $sql2 = "DELETE FROM logins WHERE id = $uid";
                    if($conn->query($sql2) === TRUE){
                        $resp = array(
                            'status' => 'success',
                            'message' => 'User deleted.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                        header("Location: ../users.php");
                    } else {
                        $resp = array(
                            'status' => 'error',
                            'message' => 'Error deleting user login.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error deleting user details.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            }
        }
    } else{
        $resp = array(
            'status' => 'error',
            'message' => 'You cannot delete the account you are currently logged into.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>