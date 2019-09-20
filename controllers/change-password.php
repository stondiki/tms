<?php
session_start();
if(isset($_SESSION["uid"])){
    include("db.php");
    if($_POST["pwd"] != "" && $_POST["pwd2"] != "" && $_POST["cpwd"] != ""){
        $pwd1 = $_POST["pwd"];
        $pwd2 = $_POST["pwd2"];
        $cpwd = $_POST["cpwd"];
        if($pwd1 != $pwd2){
            $resp = array(
                'status' => 'error',
                'message' => 'The new passwords do not match.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            $sql = "SELECT * FROM logins WHERE id = ".$_SESSION["uid"];
            $result = $conn->query($sql);
            if($result->num_rows == 1){
                while($row = $result->fetch_assoc()){
                    if(password_verify($cpwd, $row["user_password"])){
                        $pass = password_hash($pwd1, PASSWORD_DEFAULT);
                        $sql2 = "UPDATE logins SET user_password = '".$pass."', first_password = 'no' WHERE id = ".$_SESSION["uid"];
                        if($conn->query($sql2) === TRUE){
                            $resp = array(
                                'status' => 'success',
                                'message' => 'Password updated successfully.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                            header("Location: ../index.php");
                        } else {
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Error updating your password.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    } else {
                        $resp = array(
                            'status' => 'error',
                            'message' => 'Your current password is incorrect.'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error retrieving your login details.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'One of the fields is not properly filled.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
} else {
    $resp = array(
        'status' => 'error',
        'message' => 'An error occured with your session.'
    );
    header('Content-Type: application/json');
    echo json_encode($resp);
}
?>