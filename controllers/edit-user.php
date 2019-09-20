<?php
session_start();

if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    if($_POST["uid"] != "" || $_POST["email"] != "" || $_POST["fname"] != "" || $_POST["lname"] != "" || $_POST["phone"] != ""){
        $uid = $_POST["uid"];
        $email = $_POST["email"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $oname = $_POST["oname"];
        $phone = $_POST["phone"];
        $role = $_POST["role"];

        $sql = "UPDATE logins
        SET user_email = '".$email."', user_role = '".$role."'
        WHERE id = $uid";

        $sql2 = "UPDATE user_details
        SET first_name = '".$fname."', last_name = '".$lname."', other_names = '".$oname."', phone_number = '".$phone."'
        WHERE login_id = $uid";

        if($conn->query($sql) === TRUE){
            if($conn->query($sql2) === TRUE){
                $resp = array(
                    'status' => 'success',
                    'message' => 'User updated successfully.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
                header("Location: ../users.php");
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error updating user details.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'Error updating login details.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'The form has to be filled.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>