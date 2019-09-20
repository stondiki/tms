<?php
    session_start();
    if(isset($_SESSION["uid"])){
        header("Location: ../index.php");
    } else {
        include("db.php");
        if(!empty($_POST["email"]) && !empty($_POST["password"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $sql = "SELECT * FROM logins WHERE user_email = '$email'";
            $result = $conn->query($sql);

            if($result->num_rows == 1){
                while($row = $result->fetch_assoc()){
                    if(password_verify($password, $row["user_password"])){
                        $_SESSION["uid"] = $row["id"];
                        $_SESSION["email"] = $row["user_email"];
                        $_SESSION["role"] = $row["user_role"];

                        $sql2 = "SELECT * FROM user_details WHERE login_id = ".$row["id"];
                        $result2 = $conn->query($sql2);

                        if($result2->num_rows == 1){
                            while($row2 = $result2->fetch_assoc()){
                                $_SESSION["fname"] = $row2["first_name"];
                                $_SESSION["lname"] = $row2["last_name"];
                                $_SESSION["usr_img"] = $row2["user_img"];
                                $_SESSION["usr_id"] = $row2["id"];

                                /* Log FUnctions */
                                function getUserIpAddr(){
                                    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                                        //ip from share internet
                                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                                    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                                        //ip pass from proxy
                                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                    }else{
                                        $ip = $_SERVER['REMOTE_ADDR'];
                                    }
                                    return $ip;
                                }
                                $ipAddr = getUserIpAddr();
                
                                $log = "INSERT INTO system_log (usr_id, system_event, clicked_element, clicked_page, ip_address)
                                VALUES('".$_SESSION["usr_id"]."', 'login', 'login', 'login', '".$ipAddr."')";
                                if($conn->query($log) === TRUE){
                                    $resp = array(
                                        'status' => 'success',
                                        'message' => 'Log inserted successfully'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                } else {
                                    $resp = array(
                                        'status' => 'error',
                                        'message' => 'Error inserting log entry.'
                                    );
                                    header('Content-Type: application/json');
                                    echo json_encode($resp);
                                }
                                /* End of log functions*/

                                $resp = array(
                                    'status' => 'success',
                                    'message' => 'Logged in successfully'
                                );
                                header('Content-Type: application/json');
                                echo json_encode($resp);

                                header("Location: ../index.php");
                            }
                        } else{
                            $resp = array(
                                'status' => 'error',
                                'message' => 'Error getting user details'
                            );
                            header('Content-Type: application/json');
                            echo json_encode($resp);
                        }
                    } else{
                        $resp = array(
                            'status' => 'error',
                            'message' => 'Invalid credentials'
                        );
                        header('Content-Type: application/json');
                        echo json_encode($resp);
                    }
                }
            } else {
                $resp = array(
                    'status' => 'error',
                    'message' => 'Error querying db'
                );
                header('Content-Type: application/json');
                echo json_encode($resp);
            }
        } else {
            $resp = array(
                'status' => 'error',
                'message' => 'One of the values is empty'
            );
            header('Content-Type: application/json');
            echo json_encode($resp);
        }
        $conn->close();
    }
?>