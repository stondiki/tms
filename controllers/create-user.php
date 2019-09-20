<?php
session_start();

if(!isset($_SESSION["uid"]) || $_SESSION["role"] != "staff"){
    header("Location: ../index.php");
} else {
    include("db.php");
    $_POST = json_decode(file_get_contents('php://input'), true);
    if($_POST["email"] != "" || $_POST["fname"] != "" || $_POST["lname"] != "" || $_POST["phone"] != ""){
        $email = $_POST["email"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $oname = $_POST["oname"];
        $phone = $_POST["phone"];
        $role = $_POST["role"];

        $sql = "SELECT * FROM logins WHERE user_email = '".$email."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $resp = array(
                'status' => 'error',
                'message' => 'Email is already taken.'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else{
            $str = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9";
            $p = "";
            $x = explode(',', $str);
            for($i=0; $i<12; $i++){
                $p = $p.$x[rand(0,61)];
            }
            
            $pass = password_hash($p, PASSWORD_DEFAULT);
            $sql1 = "INSERT INTO logins (user_email, user_role, user_password)
            VALUES('".$email."', '".$role."', '".$pass."')";
            if($conn->query($sql1) === TRUE){
                $sql2 = "SELECT * FROM logins WHERE user_email = '".$email."'";
                $result2 = $conn->query($sql2);
                if($result2->num_rows == 1){
                    while($row2 = $result2->fetch_assoc()){
                        $sql3 = "INSERT INTO user_details (login_id, first_name, last_name, other_names, phone_number)
                        VALUES('".$row2["id"]."', '".$fname."', '".$lname."', '".$oname."', '".$phone."')";
                        if($conn->query($sql3) === TRUE){
                            if($role == "student"){
                                $sql4 = "SELECT * FROM user_details WHERE login_id = '".$row2["id"]."'";
                                $result4 = $conn->query($sql4);
                                if($result4->num_rows == 1){
                                    while($row4 = $result4->fetch_assoc()){
                                        $sql5 = "INSERT INTO students (user_details_id)
                                        VALUES('".$row4["id"]."')";
                                        if($conn->query($sql5) === TRUE){

                                            $n = $fname." ".$lname;
                                            $com = "node ./email/index.js ".$n." ".$email." ".$p."";
                                            $output = shell_exec($com);

                                            $resp = array(
                                                'status' => 'success',
                                                'message' => 'Student created successfully. '.$output
                                            );
                                            header('Content-Type: application/json');
                                            echo json_encode($resp);
                                            
                                        } else {
                                            $resp = array(
                                                'status' => 'error',
                                                'message' => 'Error crearing student admission number.'
                                            );
                                            header('Content-Type: application/json');
                                            echo json_encode($resp);
                                        }
                                    }
                                } else {
                                    $resp = array(
                                        'status' => 'error',
                                        'message' => 'Error selecting student details for admission number creation.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                }
                            } else {

                                $n = $fname." ".$lname;
                                $com = "node ./email/index.js ".$n." ".$email." ".$p."";
                                $output = shell_exec($com);

                                $resp = array(
                                    'status' => 'success',
                                    'message' => 'User created successfully. '.$output
                                );
                                header('Content-Type: application/json');
                                echo json_encode($resp);
                                //header("Location: ../users.php");
                            }
                        } else {
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Error entering user details.'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    }
                } else {
                    $resp = array(
                        'status' => 'error',
                        'message' => 'Error retrieving log in details for user detail entry.'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($resp);
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'There was a problem creating user login.'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        }
    } else {
        $resp = array(
            'status' => 'error',
            'message' => 'First name, last name, email and phone need to be filled in correctly.'
        );
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
    $conn->close();
}
?>