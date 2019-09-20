<?php
for($x = 1; $x < 50; $x++){
    $com = "ping 192.168.33.".$x." -n 1";
    $output = shell_exec($com);
    }
    $a = "arp -a";
    $b = shell_exec($a);
echo json_encode($b);
?>